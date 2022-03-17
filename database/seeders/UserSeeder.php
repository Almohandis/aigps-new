<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\ChronicDisease;
use App\Models\Hospital;
use App\Models\Infection;
use App\Models\NationalId;
use App\Models\Question;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;

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
        $campaigns = Campaign::get();
        $hospitalIDs = Hospital::pluck('id');
        $hospitalIDs = json_decode(json_encode($hospitalIDs));
        $nationalIds = NationalId::pluck('national_id');

        foreach ($nationalIds as $nid) {
            $user = User::factory()
                ->hasPhones(2)
                ->hasPassport(1, [
                    'vaccine_dose_count'    => $this->faker->numberBetween(0, 2),
                ])
                ->has(ChronicDisease::factory(2))
                ->has(Infection::factory(2))
                ->hasAttached($questions, ['answer' => $this->faker->randomElement(['Yes', 'No'])])
                ->create([
                    'national_id' => $nid,
                    'hospital_id' => $this->faker->randomElement([null, $this->faker->randomElement($hospitalIDs)]),
                ]);
            // $user->hospitalizations()->attach($hospitalIDs, [
            //     'checkin_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            //     'checkout_date' => $this->faker->randomElement([null, null, $this->faker->dateTimeBetween('now', '+1 month')])
            // ]);
            shuffle($hospitalIDs);
            $sub_hospitalizations = array_slice($hospitalIDs, 0, $this->faker->numberBetween(0, count($hospitalIDs) - 1));
            foreach ($sub_hospitalizations as $hos_id) {
                $user->hospitalizations()->attach($hos_id, [
                    'checkin_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
                    'checkout_date' => $this->faker->randomElement([null, null, $this->faker->dateTimeBetween('now', '+1 month')])
                ]);
            }
            $user->campaigns()->attach($campaigns, [
                'from' => $this->faker->dateTimeBetween('-1 month', 'now'),
                'to' => $this->faker->dateTimeBetween('now', '+1 month'),
            ]);
            $user->reservations()->attach($campaigns, [
                'date'  => $this->faker->dateTimeBetween('-3 days', '+3 days'),
            ]);
        }
        $users = User::where('gender', 'Male')->get();
        $relatives = User::where('gender', 'Female')->pluck('id');
        $relatives = json_decode(json_encode(array_rand($relatives->all(), 3)));
        foreach ($users as $user) {
            $user->relatives()->attach([
                $relatives[0]  => ['relation' => 'Mother'],
                $relatives[1] => ['relation' => 'Sister'],
                $relatives[2] => ['relation' => 'Aunt'],
            ]);
        }
    }
}
