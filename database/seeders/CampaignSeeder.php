<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Campaign::factory(2)
        ->state(new Sequence(
            ['location' => '31.233334, 30.033333'],
            ['location' => '30.128611, 31.242222'],
        ))
        ->create();
    }
}
