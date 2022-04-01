<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CitySeeder::class,
            NationalIdSeeder::class,
            QuestionSeeder::class,
            CampaignSeeder::class,
            HospitalSeeder::class,
            ArticleSeeder::class,
            UserSeeder::class,
            VaccineDateSeeder::class,
        ]);
    }
}
