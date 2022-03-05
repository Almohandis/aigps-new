<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Sequence;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::factory(14)
        ->state(new Sequence(
            ['title'    =>      'Do you have today or in the past ten days Any symptoms such as fever, cough, shortness of breath, muscle aches, headache, sore throat, runny nose, nausea, vomiting or diarrhea?'],
            ['title'    =>      'have you been infected with the Covid-19 during the past 3 months, or were you suspected of having it?'],
            ['title'    =>      'Have you received any vaccinations within 14 days (eg seasonal flu vaccination)?'],
            ['title'    =>      'Have you ever had an allergy to a medicine or vaccine?'],
            ['title'    =>      'Do you suffer from diseases that weaken the immune system (such as cancerous tumors)?'],
            ['title'    =>      'Do you use immunosuppressant drugs such as cortisone?'],
            ['title'    =>      'Do you suffer from immune diseases (eg AIDS)?'],
            ['title'    =>      'Do you suffer from high blood pressure (unstable)?'],
            ['title'    =>      'Do you suffer from diabetes (unstable)?'],
            ['title'    =>      'Do you suffer from chronic heart disease?'],
            ['title'    =>      'Do you suffer from chronic nervous diseases or nervous spasms?'],
            ['title'    =>      'Do you suffer from blood diseases (eg Haemophilia or blood clots)?'],
            ['title'    =>      '(For women) Are you currently pregnant or planning to become pregnant in the near future (within a year) ?'],
            ['title'    =>      '(For women) Are you breastfeeding a baby under 6 months?']
        ))
        ->create();

    }
}
