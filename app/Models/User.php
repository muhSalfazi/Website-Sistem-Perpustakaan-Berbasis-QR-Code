<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'members';
    
    protected $fillable = [
    'nim',
    'fist_name',
    'last_name',
    'email',
    'phone',
    'address',
    'date_of_birth',
    'gender', ['Male', 'Female'],
    
];


}