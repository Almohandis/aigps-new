<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Infection;
use App\Models\User;
use Illuminate\Container\Container;
use Faker\Generator;
use Illuminate\Database\Seeder;

class InfectionSeeder extends Seeder
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
        Infection::factory()->count(200)->create();
        $hospitals = Hospital::pluck('id');
        $users = User::pluck('id');
        $infections = Infection::get();
        foreach ($infections as $infection) {
            $infection->update([
                'user_id'       =>  $this->faker->randomElement($users),
                'hospital_id' => $this->faker->randomElement($hospitals),
                'infection_date' => $this->faker->dateTimeBetween('-1 years', '-3 days'),
                'is_recovered' => $this->faker->boolean,
                'has_passed_away' => $this->faker->boolean,
            ]);
        }
    }
}
