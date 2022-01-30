<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question1'     =>      $this->faker->sentence,
            'question2'     =>      $this->faker->sentence,
            'question3'     =>      $this->faker->sentence,
            'question4'     =>      $this->faker->sentence
        ];
    }
}
