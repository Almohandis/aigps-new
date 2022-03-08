<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Infection;
use App\Models\MedicalPassport;
use App\Models\NationalId;
use App\Models\Question;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class UserSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'Do you have today or in the past ten days Any symptoms such as fever, cough, shortness of breath, muscle aches, headache, sore throat, runny nose, nausea, vomiting or diarrhea?',
            'have you been infected with the Covid-19 during the past 3 months, or were you suspected of having it?',
            'Have you received any vaccinations within 14 days (eg seasonal flu vaccination)?',
            'Have you ever had an allergy to a medicine or vaccine?',
            'Do you suffer from diseases that weaken the immune system (such as cancerous tumors)?',
            'Do you use immunosuppressant drugs such as cortisone?',
            'Do you suffer from immune diseases (eg AIDS)?',
            'Do you suffer from high blood pressure (unstable)?',
            'Do you suffer from diabetes (unstable)?',
            'Do you suffer from chronic heart disease?',
            'Do you suffer from chronic nervous diseases or nervous spasms?',
            'Do you suffer from blood diseases (eg Haemophilia or blood clots)?',
            '(For women) Are you currently pregnant or planning to become pregnant in the near future (within a year) ?',
            '(For women) Are you breastfeeding a baby under 6 months?'
        ];
        $questions = Question::get();
        NationalId::factory()->count(3)->create();
        $nationalIds = NationalId::pluck('national_id');

        foreach ($nationalIds as $nid) {
            User::factory()
                ->hasPhones(2)
                ->hasPassport(1)
                ->for(Hospital::factory())
                ->has(Infection::factory(2))
                ->hasAttached($questions, ['answer' => $this->faker->randomElement(['Yes', 'No'])])
                ->create([
                    'national_id' => $nid
                ]);
        }
    }
}
