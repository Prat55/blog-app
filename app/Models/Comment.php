<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'blog_id',
        'comment_uid',
        'comment',
    ];

    protected function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    protected function user2()
    {
        return $this->belongsTo(DeletedUser::class, 'userID', 'userID');
    }

    protected function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_uid', 'blog_id');
    }
}
