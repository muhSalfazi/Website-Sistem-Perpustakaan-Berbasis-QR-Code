<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'tbl_members';

    protected $fillable = [
        'user_id',
        'nim',
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
        return $this->belongsTo(User::class, 'user_id');
    }
}