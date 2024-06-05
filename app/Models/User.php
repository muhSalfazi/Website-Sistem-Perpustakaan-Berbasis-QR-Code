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
                    'first_name' => $user->first_name, // Gunakan first_name dari inputan
                    'last_name' => $user->last_name, // Gunakan last_name dari inputan
                    'email' => $user->email,
                    'imageProfile' => $user->imageProfile, // Gunakan imageProfile dari inputan
                    'phone' => $user->phone, // Gunakan phone dari inputan
                    'address' => $user->address, // Gunakan address dari inputan
                    // 'password' => $user->password,
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