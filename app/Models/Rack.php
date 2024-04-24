<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Rack extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'racks';
    
    protected $fillable = [
    'name',
    'lantai'
];

        
}