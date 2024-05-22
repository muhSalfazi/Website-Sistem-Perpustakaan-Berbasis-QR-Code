<?php

namespace Database\Factories;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
         $currentMonth = Carbon::now()->month;
        $randomDay = $this->faker->numberBetween(1, Carbon::now()->daysInMonth);
        $randomHour = $this->faker->numberBetween(0, 23);
        $randomMinute = $this->faker->numberBetween(0, 59);
        $randomSecond = $this->faker->numberBetween(0, 59);
        $randomDate = Carbon::create(null, $currentMonth, $randomDay, $randomHour, $randomMinute, $randomSecond);

        
        // Ambil satu baris acak dari tabel 'members' untuk mendapatkan 'nim'
        $member = User::inRandomOrder()->first();

        return [
         'resi_pjmn' => $this->faker->unique()->regexify('[0-9]{10}'), 
            'book_id' => $this->faker->numberBetween(1, 10),
           'jmlh_book' => $this->faker->numberBetween(1, 5),
            'member_id' => $member->id, // Gunakan ID member
            'tgl_pinjam' => $randomDate,
            // 'tengat_wktu' => $this->faker->dateTimeBetween('now', '+3 days'),
            'tgl_kembali' => $this->faker->dateTimeBetween('now', '+10 days'),
            'created_at' =>  $randomDate, // Set created_at menjadi NULL
            'updated_at' => null, // Set updated_at menjadi NULL
        ];
    }
}