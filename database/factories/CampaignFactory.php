<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_date' => $this->faker->dateTimeBetween('-1 years', '+1 years'),
            'end_date' => $this->faker->dateTimeBetween('-1 years', '+1 years'),
            'type' => $this->faker->randomElement(['sanitization', 'vaccination']),
            'location' => 'location',
            'address' => $this->faker->address,
        ];
    }
}
