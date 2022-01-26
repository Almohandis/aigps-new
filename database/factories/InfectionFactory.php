<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InfectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'infection_date' => $this->faker->dateTimeBetween('-1 years', '+1 years'),
            'is_recovered' => $this->faker->boolean,
        ];
    }
}
