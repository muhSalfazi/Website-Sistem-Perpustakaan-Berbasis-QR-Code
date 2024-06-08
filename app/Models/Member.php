<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Member extends Model
{
use HasFactory, SoftDeletes;

    protected $table = 'tbl_members';

    protected $fillable = [
        'id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'imageProfile',
        'phone',
        'address', 
        'tgl_lahir',
        'last_login',
        'qr_code',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'member_id');
    }
}