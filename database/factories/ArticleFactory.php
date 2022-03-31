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
        $paragraphs = $this->faker->numberBetween(1, 5);
        return [
            'title'     =>      $this->faker->sentence,
            'content'   =>      $this->faker->paragraphs($paragraphs, true),
            'video_link'      =>      'https://www.youtube.com/embed/7nmVILOWYbo',
            'full_article_link'      =>      NULL,
        ];
    }
}
