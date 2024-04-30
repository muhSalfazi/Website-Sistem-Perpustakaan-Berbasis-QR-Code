<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminModels extends Authenticatable
{
    use HasFactory;

    protected $table = 'tbl_admin';

    protected $fillable = [
        'username',
        'email',
        'password',
        'last_login'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}