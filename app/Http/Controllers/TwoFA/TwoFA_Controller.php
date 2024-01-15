<?php

namespace App\Http\Controllers\TwoFA;

use App\Http\Controllers\Controller;
use App\Mail\TwoFaOtpMail;
use App\Models\TwofaOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TwoFA_Controller extends Controller
{
    protected function otp()
    {
        do {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $otp =  substr(str_shuffle(str_repeat($pool, 5)), 0, 5);
        } while (TwofaOtp::where("otp", "=", $otp)->first());

        return $otp;
    }

    protected function enable_request()
    {
        $user = Auth::user();

        if ($user->email_verified_at) {

            $otp =  $this->otp();

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

            return redirect()->route('verification');
        } else {
            return redirect()->route('profile.edit')->with('error', 'Email verification is required for 2FA!');
        }
    }

    protected function verification(Request $request)
    {

        return view('2FA.2FA-otp');
    }

    protected function verify_otp(Request $request)
    {
        $request->validate([
            'char1' => 'required|max:1|min:1',
            'char2' => 'required|max:1|min:1',
            'char3' => 'required|max:1|min:1',
            'char4' => 'required|max:1|min:1',
            'char5' => 'required|max:1|min:1',
        ]);

        $user = Auth::user();
        $userInputOpt = $request->char1 . $request->char2 . $request->char3 . $request->char4 . $request->char5;
        $otp = TwofaOtp::where('otp', $userInputOpt)->where('userID', $user->userID)->first();

        if ($otp) {
            $userVerify = User::where('userID', $user->userID)->first();
            $userVerify->twoFA = 1;
            $userVerify->update();
            $otp->delete();

            return redirect()->route('profile.edit')->with('success', '2FA enabled successfully');
        } else {
            return redirect()->route('profile.edit')->with('error', 'Your two factor authentication is failed to enable.Make sure you have enter right code!');
        }
    }

    protected function disable_request()
    {
        $user = Auth::user();
        $userModel = User::where('userID', $user->userID)->first();
        $userModel->twoFA = 0;
        $userModel->update();

        return redirect()->route('profile.edit')->with('success', 'Your two factor authentication is disabled');
    }

    protected function login_verification()
    {
        return view('2FA.login-2FA-otp');
    }

    protected function login_verification_user(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'char1' => 'required|max:1|min:1',
            'char2' => 'required|max:1|min:1',
            'char3' => 'required|max:1|min:1',
            'char4' => 'required|max:1|min:1',
            'char5' => 'required|max:1|min:1',
        ]);

        $userInputOpt = $request->char1 . $request->char2 . $request->char3 . $request->char4 . $request->char5;
        $otp = TwofaOtp::where('otp', $userInputOpt)->where('userID', $user->userID)->first();

        if ($otp) {
            $userVerify = User::where('userID', $user->userID)->first();
            $userVerify->twoFA = 1;
            $userVerify->twofa_verify = 'verified';
            $userVerify->update();
            $otp->delete();

            return redirect()->route('dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->with('error', 'You have entered wrong code! Please try again.');
        }
    }
}
