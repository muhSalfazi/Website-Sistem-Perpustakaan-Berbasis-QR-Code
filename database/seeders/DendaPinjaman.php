<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\DendaPnjmnFactory;


use App\Models\Denda;
class DendaPinjaman extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         Denda::factory()->count(5)->create();
    }
}