<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Blog;
use App\Models\DeletedUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        $user = User::where('userID', Auth::user()->userID)->first();
        $user2 = DeletedUser::where('userID', Auth::user()->userID)->first();

        $phone = $request->phone ?: null;

        $user->phone =  $phone;
        $user->update();

        $user2->phone =  $phone;
        $user2->update();

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    protected function change_profile(Request $request, $uid)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = User::where('userID', $uid)->first();
            $user2 = DeletedUser::where('userID', $uid)->first();

            if (!empty($user->profile_img) && !empty($user2->profile_img)) {
                if (file::exists("profile_img/" . $user->profile_img)) {
                    File::delete("profile_img/" . $user->profile_img);
                }
            }

            // Store the new image in the database
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(\public_path("profile_img/"), $imageName);

            if ($user) {
                $user->profile_img = $imageName;
                $user2->profile_img = $imageName;

                $user->update();
                $user2->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Profile Picture Updated Successfully',
                ]);
            } else {

                return response()->json([
                    'status' => 404,
                    'message' => "File Not Found",
                ]);
            }
        }
    }

    protected function remove_profile($uid)
    {
        $user = User::where('userID', $uid)->first();
        if (!empty($user->profile_img)) {
            if (file::exists("profile_img/" . $user->profile_img)) {
                File::delete("profile_img/" . $user->profile_img);
            }

            $user->profile_img = null;
            $user->update();

            return Redirect::back();
        } else {
            return Redirect::back()->with('error', 'Set your profile image first.');
        }
    }
}
