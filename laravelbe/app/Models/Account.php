<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'email',
        'password',
        'accessToken',
        'otp',  
        'otp_expires_at',
        'otp_used',
    ];

    use HasFactory;
}
