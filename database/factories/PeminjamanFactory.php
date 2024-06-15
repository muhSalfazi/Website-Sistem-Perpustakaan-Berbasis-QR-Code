<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition()
    {
        $createdAt = Carbon::now()->subDays(rand(10, 20));
        $returnDate = $createdAt->copy()->addDays(rand(5, 15));

        return [
            'id_member' => 1,
            'id_book' => 1,
            'created_at' => $createdAt,
            'return_date' => $returnDate,
        ];
    }
}