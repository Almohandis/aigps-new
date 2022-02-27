<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Survey;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Survey::factory(1)->hasQuestions(5)->create();
    }
}
