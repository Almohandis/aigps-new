<?php

namespace Database\Seeders;

use App\Models\Hospital;
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
            // HospitalSeeder::class,
            // NationalIdSeeder::class,
            QuestionSeeder::class,
            UserSeeder::class,
            CampaignSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
