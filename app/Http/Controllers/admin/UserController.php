<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    protected function ban($uid)
    {
        $user = User::where('userID', $uid)->first();
        if ($user) {
            $user->status = 'ban';
            $user->update();

            return Redirect::back()->with('success', 'User banned successfully');
        } else {
            return Redirect::back()->with('error', 'No such user!');
        }
    }

    protected function unban($uid)
    {
        $user = User::where('userID', $uid)->first();
        if ($user) {
            $user->status = 'active';
            $user->update();

            return Redirect::back()->with('success', 'User unbaned successfully');
        } else {
            return Redirect::back()->with('error', 'No such user!');
        }
    }
}
