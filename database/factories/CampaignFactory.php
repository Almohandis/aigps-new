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
            'start_date' => $this->faker->dateTimeBetween('-3 days', '+2 weeks'),
            'end_date' => $this->faker->dateTimeBetween('+3 weeks', '+4 weeks'),
            'city' => $this->faker->city,
            'location' => 'location',
            'address' => $this->faker->address,
        ];
    }
}
