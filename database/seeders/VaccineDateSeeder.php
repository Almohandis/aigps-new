<?php

namespace Database\Seeders;

use App\Models\MedicalPassport;
use App\Models\VaccineDate;
use Illuminate\Container\Container;
use Faker\Generator;
use Illuminate\Database\Seeder;

class VaccineDateSeeder extends Seeder
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
        $passports = MedicalPassport::pluck('id')->toArray();

        for ($i = 0; $i < count($passports) / 2; $i++) {
            VaccineDate::factory()->create([
                'medical_passport_id' => $this->faker->randomElement($passports),
            ]);
        }
    }
}
