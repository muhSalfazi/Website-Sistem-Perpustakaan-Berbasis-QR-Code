<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;
    protected $table = 'tbl_denda';
    
    protected $fillable = [
    'id_member',
    'denda_yg_diberikan',
    'uang_yg_dibyrkn',
    'kembalian',
    'total_days',
];
}