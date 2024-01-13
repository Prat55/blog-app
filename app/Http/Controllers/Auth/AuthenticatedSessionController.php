<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\TwoFaOtpMail;
use App\Models\TwofaOtp;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    protected function otp()
    {
        do {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $otp =  substr(str_shuffle(str_repeat($pool, 5)), 0, 5);
        } while (TwofaOtp::where("otp", "=", $otp)->first());

        return $otp;
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->loginName)->orWhere('name', $request->loginName)->first();

        if ($user->status === 'active') {
            $request->authenticate();

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);

            if ($user->twoFA == 1) {
                $otp = $this->otp();

                $newOtpSave = TwofaOtp::create([
                    'userID' => $user->userID,
                    'otp' => $otp,
                    'expires_in' => now()->addMinutes(10),
                ]);
                $newOtpSave->save();

                $mailData = [
                    'otp' => $otp,
                ];

                Mail::to($user->email)->send(new TwoFaOtpMail($mailData));

                return redirect()->route('login_verification', ['token' => $user->userID]);
            }
        } else {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been banned by administrator!');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = User::where('userID', Auth::user()->userID)->first();
        if ($user->twofa_verify === 'verified') {
            $user->twofa_verify = 'unverified';
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
