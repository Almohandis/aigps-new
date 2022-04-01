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
    public function run() {
        $question = Question::first();
        $national_ids = NationalId::where('national_id', 'NOT LIKE', '2971001890123%')->get()->toArray();
        $hospital_ids_pluck = Hospital::pluck('id')->toArray();
        $campaigns = Campaign::get();

        $users = User::factory(count($national_ids))
            ->state(new Sequence(function ($sequence) use ($national_ids) {
                return [
                    'national_id' =>  $national_ids[$sequence->index]['national_id']
                ];
            }))
            ->hasPhones(2)
            ->hasPassport()
            ->create()
            ->each(function ($user) use ($question, $national_ids, $hospital_ids_pluck, $campaigns) {
                $hasChronicDisease = $this->faker->boolean;
                if ($hasChronicDisease) {
                    $user->chronicDiseases()->create([
                        'name' => $this->faker->randomElement(['Diabetis', 'Asthma', 'Cancer', 'Hepatitis', 'Tuberculosis', 'HIV/AIDS']),
                    ]);
                }

                $hasSurvey = $this->faker->boolean;
                if ($hasSurvey) {
                    $user->questions()->attach($question, ['answer' => $this->faker->randomElement(['Yes', 'No'])]);
                }

                $hasInfection = $this->faker->boolean;
                if ($hasInfection) {
                    $user->infections()->create([
                        'hospital_id'   => $this->faker->randomElement($hospital_ids_pluck),
                    ]);
                }

                $isDoctor = $this->faker->boolean;
                if ($isDoctor) {
                    $user->update([
                        'hospital_id'       =>      $this->faker->randomElement($hospital_ids_pluck)
                    ]);
                }

                $isHospitalized = $this->faker->boolean;
                if ($isHospitalized) {
                    $user->hospitalizations()->attach($this->faker->randomElement($hospital_ids_pluck), [
                        'checkin_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
                        'checkout_date' => $this->faker->randomElement([null, null, $this->faker->dateTimeBetween('+1 day', '+1 month')])
                    ]);
                }

                $isCampaignDoctor = $this->faker->boolean;
                if ($isCampaignDoctor) {
                    $user->campaigns()->attach($campaigns, [
                        'from' => $this->faker->dateTimeBetween('-1 month', 'now'),
                        'to' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
                    ]);
                }

                $hasReservation = $this->faker->boolean;
                if ($hasReservation) {
                    $user->reservations()->attach($campaigns, [
                        'date'  => $this->faker->dateTimeBetween('-3 days', '+3 days'),
                    ]);
                }
            });

        $clerkIds = NationalId::where('national_id', 'LIKE', '2971001890123%')->get()->toArray();

        $clerkUsers = User::factory(count($clerkIds))
            ->state(
                new Sequence(function ($sequence) use ($clerkIds) {
                    return [
                        'national_id' =>  $clerkIds[$sequence->index]['national_id'],
                        'role_id' => $sequence->index + 1
                    ];
                })
            )
            ->create();
    }
}
