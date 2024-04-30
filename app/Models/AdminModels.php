<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

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

    // Method untuk mengatur last_login
    public function setLastLoginAttribute($value)
    {
        $this->attributes['last_login'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}