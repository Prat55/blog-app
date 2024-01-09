<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller
{

    protected function random_Token()
    {
        do {
            $token = substr(md5(mt_rand()), 0, 30);
        } while (Blog::where("blog_uid", "=", $token)->first());

        return $token;
    }

    protected function addBlog(Request $request)
    {
        $request->validate([
            'blog_title' => 'required|max:50|min:5',
            'blog_description' => 'required|min:150',
            'coverimg' => 'required|max:7500|mimes:png,jpg,jpeg,gif,svg,webp',
        ]);

        $uid = $this->random_Token();

        if ($request->hasFile('coverimg')) {
            $coverimg = $request->file('coverimg');
            $imageName = time() . '_' . $coverimg->getClientOriginalName();
            $coverimg->move(\public_path("blog_images/"), $imageName);

            $newBlog = Blog::create([
                'userID' => Auth::user()->userID,
                'blog_uid' => $uid,
                'blog_title' => $request->blog_title,
                'blog_description' => $request->blog_description,
                'cover_img' => $imageName,
            ]);

            if ($newBlog) {
                return back()->with('success', 'Blog posted successfully');
            } else {
                return back()->with('error', 'Something went wrong! Please try again');
            }
        }
    }

    protected function update($token, Request $request)
    {
        $blog = Blog::where('blog_uid', $token)->first();
        if ($blog->userID == Auth::user()->userID) {
            $request->validate([
                'blog_new_title' => 'max:198|min:5',
                'blog_cover_img' => 'max:7500|mimes:png,jpg,jpeg,gif,svg,webp',
                'description' => 'min:150',
            ]);

            if ($request->hasFile('blog_cover_img')) {

                //? Deleting previous image
                if (!empty($blog->cover_img)) {
                    if (file::exists("books/" . $blog->cover_img)) {
                        File::delete("books/" . $blog->cover_img);
                    }
                }

                // ? Adding new image
                $blogCover = $request->file('blog_cover_img');
                $blogCoverName = time() . '_' . $blogCover->getClientOriginalName();
                $blogCover->move(\public_path("blog_images/"), $blogCoverName);

                $blog->blog_title = $request->blog_new_title;
                $blog->cover_img = $blogCoverName;
                $blog->blog_description = $request->description;

                $blog->update();

                if ($blog) {
                    return Redirect::back();
                } else {
                    return abort(404);
                }
            } else {
                $blog->blog_title = $request->blog_new_title;
                $blog->blog_description = $request->description;

                $blog->update();

                if ($blog) {
                    return Redirect::back();
                } else {
                    return abort(404);
                }
            }
        }
    }

    protected function destroy($uid)
    {
        $blog = Blog::where('blog_uid', $uid)->first();
        if ($blog->userID === Auth::user()->userID || Auth::user()->role === 'admin') {
            if (file::exists("blog_images/" . $blog->cover_img)) {
                File::delete("blog_images/" . $blog->cover_img);
            }
            $blog->delete();

            return Redirect::route('dashboard')->with('success', 'Blog deleted successfully');
        } else {
            return Redirect::route('dashboard')->with('error', "You doesn't have access to do this!");
        }
    }

    protected function read_more($uid)
    {
        $blog = Blog::where('blog_uid', $uid)->first();
        $comments = Comment::where('blog_id', $uid)->latest()->get();
        return view('read-more.read-more', compact('blog', 'comments'));
    }
}
