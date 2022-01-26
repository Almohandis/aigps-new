<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalPassportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vaccine_name' => $this->faker->randomElement(['Hepatitis B', 'Hepatitis A', 'Hepatitis C']),
            'vaccine_date' => $this->faker->dateTimeBetween('-1 years', '+1 years'),
        ];
    }
}
