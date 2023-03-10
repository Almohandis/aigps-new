<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChronicDiseaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Diabetis', 'Asthma', 'Cancer', 'Hepatitis', 'Tuberculosis', 'HIV/AIDS']),
        ];
    }
}
