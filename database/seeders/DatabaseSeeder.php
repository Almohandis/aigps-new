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
            NationalIdSeeder::class,
            QuestionSeeder::class,
            HospitalSeeder::class,
            ArticleSeeder::class,
            CampaignSeeder::class,
            UserSeeder::class,
            InfectionSeeder::class,
            VaccineDateSeeder::class,
        ]);
    }
}
