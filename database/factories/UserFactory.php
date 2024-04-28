<?php

// database/factories/UserFactory.php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //random dateTime 
         $currentMonth = Carbon::now()->month;
        $randomDay = $this->faker->numberBetween(1, Carbon::now()->daysInMonth);
        $randomHour = $this->faker->numberBetween(0, 23);
        $randomMinute = $this->faker->numberBetween(0, 59);
        $randomSecond = $this->faker->numberBetween(0, 59);
        $randomDate = Carbon::create(null, $currentMonth, $randomDay, $randomHour, $randomMinute, $randomSecond);

        return [
            'nim' => $this->faker->unique()->regexify('[0-9]{14}'), // Generate a unique NIM with 8 digits
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'date_of_birth' => $this->faker->date,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            // 'qr_code' => $this->faker->imageUrl(), // Generating a random image URL for QR code
            // 'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            // 'updated_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
             'created_at' =>  $randomDate,
            'updated_at' => null, // Set updated_at menjadi NULL
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}