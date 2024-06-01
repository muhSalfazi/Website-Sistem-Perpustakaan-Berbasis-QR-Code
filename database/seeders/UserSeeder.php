<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Membuat admin
        User::create([
            'first_name'=>'jonn',
            'last_name'=>'udin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        // Membuat member
        User::create([
            'first_name' => 'salman',
            'last_name' => 'fauzi',
            'email' => 'member@mail.com',
            'password' => Hash::make('member'),
            'role' => 'member',
        ]);
    }
}