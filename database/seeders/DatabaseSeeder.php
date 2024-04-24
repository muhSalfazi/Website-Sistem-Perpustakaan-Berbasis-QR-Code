<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            RackSeeder::class,
            BookSeeder::class,
            PinjamBukuSeeder ::class
        ]);
        
        // User:factory(10)>create();
    }
}