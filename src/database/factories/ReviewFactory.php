<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 101),
            'shop_id' => $this->faker->numberBetween(1, 20),
            'star' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->realText(15),
        ];
    }
}
