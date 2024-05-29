<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    protected $table = 'tbl_members';

    protected $fillable = [
        'id',
        'nim',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'password',
        'date_of_birth',
        'gender',
        'qr_code',
       
    ];
    protected $hidden = [
        'password',
    ];
}