<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HospitalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'city'  => $this->faker->city,
            'capacity' => $this->faker->numberBetween(1, 100),
            'is_isolation' => $this->faker->boolean,
        ];
    }
}
