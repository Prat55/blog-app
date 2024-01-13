<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwofaOtp extends Model
{
    use HasFactory;
    protected $fillable = [
        'userID',
        'otp',
        'expires_in',
    ];
}
