<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'userID',
        'blog_uid',
        'blog_title',
        'blog_description',
        'cover_img',
    ];

    protected function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    protected function user2()
    {
        return $this->belongsTo(DeletedUser::class, 'userID', 'userID');    
    }
}
