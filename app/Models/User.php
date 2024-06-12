<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'tbl_users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'last_login',
        'qr_code', 
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