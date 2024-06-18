<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'last_login',
        'qr_code',
        'reset_token',
        'reset_token_created_at',
    ];

    protected $hidden = [
        'password',
    ];


    public function setLastLoginAttribute($value)
    {
        $this->attributes['last_login'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'user_id');
    }
     public function favoriteBooks()
    {
        return $this->belongsToMany(Book::class, 'favorite_books')->withTimestamps();
    }
}