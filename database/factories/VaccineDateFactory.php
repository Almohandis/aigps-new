<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vaccine_date' => $this->faker->dateTimeBetween('-1 years', '+1 years'),
        ];
    }
}
