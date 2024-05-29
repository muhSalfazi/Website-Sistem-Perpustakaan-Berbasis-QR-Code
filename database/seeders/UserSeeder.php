<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Tambahkan use statement untuk DB
use Carbon\Carbon;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nim' => '12902852238040',
            'first_name' => 'Mala',
            'last_name' => 'Agustina',
            'email' => 'jessica.putra@example.net',
            'phone' => '0678 7397 0743',
            'address' => 'Jln. Zamrud No. 464, Pekanbaru 61948, Kalsel',
            'date_of_birth' => '2003-09-26',
            'password' => Hash::make('user'), // Ensure password is hashed
        ]);
    }
}