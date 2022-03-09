<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'     =>      $this->faker->word,
            'content'   =>      $this->faker->sentence,
            'type'      =>      'article',
            'link'      =>      'https://www.google.com'
        ];
    }
}
