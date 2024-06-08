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
        'imageProfile', // Tambahkan imageProfile
        'phone', // Tambahkan phone
        'address', // Tambahkan address
        'qr_code', // Tambahkan qr_code
    ];

    protected $hidden = [
        'password',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role == 'member') {
                Member::create([
                    'user_id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'imageProfile' => $user->imageProfile,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'qr_code' => $user->qr_code,
                ]);
            }
        });
    }

    public function setLastLoginAttribute($value)
    {
        $this->attributes['last_login'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'user_id');
    }
}