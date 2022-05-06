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
            'vaccine_name'          => $this->faker->randomElement(['Hepatitis B', 'Hepatitis A', 'Hepatitis C']),
            'vaccine_dose_count'    => $this->faker->numberBetween(0, 2),
            'passport_number'       => 'A' . $this->faker->numberBetween(1000000, 9999999),
        ];
    }
}
