<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendRegisterUserMail;
use App\Models\DeletedUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    protected function random_Token()
    {
        do {
            $token = substr(md5(mt_rand()), 0, 30);
        } while (DeletedUser::where("userID", "=", $token)->first());

        return $token;
    }

    protected function random_Username($user)
    {
        do {
            $token = str_replace(' ', '', Str::lower($user)) . '_' . mt_rand(10000, 99999);
        } while (DeletedUser::where("name", "=", $token)->first());

        return $token;
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:10', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $username = $this->random_Username($request->name);

        $uid = $this->random_Token();

        $user = User::create([
            'userID' => $uid,
            'name' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $deleteUser = DeletedUser::create([
            'userID' => $uid,
            'name' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $deleteUser->save();

        $mailData = [
            'name' => $username,
        ];

        event(new Registered($user));

        Auth::login($user);

        dispatch(new SendRegisterUserMail($request->email, $mailData));

        return redirect(RouteServiceProvider::HOME);
    }
}
