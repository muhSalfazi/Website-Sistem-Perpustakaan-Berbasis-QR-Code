<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Member extends Model
{
use HasFactory;

    protected $table = 'tbl_members';

    protected $fillable = [
        'id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'imageProfile',
        'phone',
        'address', 
        'tgl_lahir',
        'last_login',
        'qr_code',
        'created_at',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'member_id');
    }

    public function favoriteBooks()
    {
        return $this->belongsToMany(Book::class, 'favorite_books')->withTimestamps();
    }
    
     public function isQrCodeExpired()
     {
     $updatedAt = $this->updated_at;
     $now = Carbon::now();
     $timeDifference = $now->diffInMinutes($updatedAt);

     return $timeDifference > 1;
     }
}