<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HospitalFactory extends Factory
{
    protected $cities = ['6th of October', 'Alexandria', 'Aswan', 'Asyut', 'Beheira', 'Beni Suef', 'Cairo', 'Dakahlia', 'Damietta', 'Faiyum', 'Gharbia', 'Giza', 'Helwan', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Minya', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'city'  => $this->faker->randomElement($this->cities),
            'capacity' => $this->faker->numberBetween(20, 300),
            'is_isolation' => $this->faker->boolean,
            'available_beds' => $this->faker->numberBetween(100, 200),
            'care_beds' =>      $this->faker->numberBetween(50, 70),
            'avail_care_beds' => $this->faker->numberBetween(5, 9),
        ];
    }
}
