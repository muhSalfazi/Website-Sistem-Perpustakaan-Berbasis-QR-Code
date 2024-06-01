<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\BookStock;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookStock>
 */
class BookStockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currentMonth = Carbon::now()->month;
        $randomDay = $this->faker->numberBetween(1, Carbon::now()->daysInMonth);
        $randomHour = $this->faker->numberBetween(0, 23);
        $randomMinute = $this->faker->numberBetween(0, 59);
        $randomSecond = $this->faker->numberBetween(0, 59);

        $randomDate = Carbon::create(null, $currentMonth, $randomDay, $randomHour, $randomMinute, $randomSecond);

        return [
            'book_id' => function () {
                return \App\Models\Book::factory()->create()->id;
            },
            'jmlh_tersedia' => $this->faker->numberBetween(1, 100),
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}