<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Reservation::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(3, 100),
            'shop_id' => $this->faker->numberBetween(1, 20),
            'date' => $this->faker->dateTimeBetween('-1weeks', '3months')->format('Y-m-d'),
            'time' => $this->faker->randomElement(['17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00']),
            'number' => $this->faker->numberBetween(1, 5),
        ];
    }
}
