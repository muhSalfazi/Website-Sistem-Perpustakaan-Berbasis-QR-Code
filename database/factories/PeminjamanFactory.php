<?php

namespace Database\Factories;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Peminjaman::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Ambil satu baris acak dari tabel 'members' untuk mendapatkan 'nim'
        $member = User::inRandomOrder()->first();

        return [
         'resi_pjmn' => $this->faker->unique()->regexify('[0-9]{10}'), 
            'book_id' => $this->faker->numberBetween(1, 10),
            'stok_buku' => $this->faker->numberBetween(1, 5),
            'member_id' => $member->id, // Gunakan ID member
            'tgl_pinjam' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'tgl_kembali' => $this->faker->dateTimeBetween('now', '+1 month'),
            'return_date' => $this->faker->dateTimeBetween('now', '+2 days'),
             'created_at' => null, // Set created_at menjadi NULL
            'updated_at' => null, // Set updated_at menjadi NULL
        ];
    }
}