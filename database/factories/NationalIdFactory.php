<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NationalIdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'national_id' => $this->faker->unique()->numberBetween(300,1000),
        ];
    }
}
