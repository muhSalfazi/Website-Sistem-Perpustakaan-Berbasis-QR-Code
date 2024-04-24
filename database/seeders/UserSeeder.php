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
        // Memasukkan data pengguna manual
        User::create([
            'nim' => '22416255201083',
            'first_name' => 'salman',
            'last_name' => 'fauzi',
            'email' => 'salmanfauzi@gmail.com',
            'phone' => '93523512',
            'address' => 'karawang',
            'date_of_birth' => Carbon::createFromFormat('d-m-Y', '05-12-2003')->format('Y-m-d'), // Memformat tanggal ke format 'YYYY-MM-DD'
            'gender' => 'male'
        ]);

        // Memasukkan data pengguna menggunakan factory
        User::factory()->count(50)->create();
    }
}