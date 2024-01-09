<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected function random_Token()
    {
        do {
            $token = substr(md5(mt_rand()), 0, 30);
        } while (Comment::where("comment_uid", "=", $token)->first());

        return $token;
    }

    protected function comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'blogID' => 'required',
        ]);


        if (Auth::check()) {
            if ($validator->fails()) {
                return response()->json([
                    'status' => 404,
                    'errors' => $validator->messages()
                ]);
            } else {
                $user = Auth::user()->userID;

                $comment = Comment::create([
                    'comment_uid' => $this->random_Token(),
                    'comment' => $request->comment,
                    'blog_id' => $request->blogID,
                    'userID' => $user,
                ]);
                $comment->save();

                return response()->json([
                    'status' => 200,
                ]);
            }
        } else {
            return Redirect::route('login');
        }
    }

    protected function remove($uid)
    {
        $comment = Comment::where('comment_uid', $uid)->first();

        if (Auth::check()) {
            if ($comment->userID === Auth::user()->userID || Auth::user()->role === 'admin') {
                $comment->delete();
                return Redirect::back();
            } else {
                return Redirect::back();
            }
        } else {
            return Redirect::route('login');
        }
    }
}
