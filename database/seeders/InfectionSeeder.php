<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Infection;
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
        $hospitals = Hospital::pluck('id');
        $infections = Infection::get();
        foreach ($infections as $infection) {
            $infection->update([
                'hospital_id' => $this->faker->randomElement($hospitals),
            ]);
        }
    }
}
