<?php

namespace App\Http\Controllers\blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            'blog_description' => 'required|min:150',
            'coverimg' => 'required|max:7500|mimes:png,jpg,jpeg,gif,svg,webp',
        ]);

        $uid = $this->random_Token();

        if ($request->hasFile('coverimg')) {
            $coverimg = $request->file('coverimg');
            $imageName = time() . '_' . $coverimg->getClientOriginalName();
            $coverimg->move(\public_path("blog_images/"), $imageName);

            $newBlog = Blog::create([
                'blog_uid' => $uid,
                'blog_description' => $request->blog_description,
                'cover_img' => $imageName,
            ]);
            $newBlog->save();

            if ($newBlog) {
                return back()->with('success', 'Blog posted successfully');
            } else {
                return back()->with('error', 'Something went wrong! Please try again');
            }
        }
    }
}
