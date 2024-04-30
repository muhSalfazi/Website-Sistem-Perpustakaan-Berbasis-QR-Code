<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminModels;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Masukkan data admin ke dalam database
        AdminModels::insert([
            'username' => 'salman fauzi',
            'email' => 'salman@gmail.com',
            'password' => Hash::make('admin'), // Hash password sebelum dimasukkan
            'last_login' => now()
        ]);
    }
}