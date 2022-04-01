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
            'infection_date' => $this->faker->dateTimeBetween('-1 years', '-3 days'),
            'is_recovered' => $this->faker->boolean,
            'has_passed_away' => $this->faker->boolean,
        ];
    }
}
