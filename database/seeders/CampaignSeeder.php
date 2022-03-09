<?php

namespace Database\Seeders;

use App\Models\Campaign;
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
        Campaign::factory(7)
            ->state(new Sequence(
                ['location' => '31.233334, 30.033333', 'status'     =>      'active'],
                ['location' => '30.128611, 31.242222', 'status'     =>      'active'],
                ['location' =>  '30.181925, 31.349375', 'status'    =>      'active'],
                ['location' =>  '30.234150, 30.886598', 'status'    =>      'active'],
                ['location' =>  '30.702300, 30.845484', 'status'    =>      'active'],
                ['location' =>  '29.533438, 29.954749', 'status'    =>      'active'],
                ['location' =>  '25.448931, 29.806026', 'status'    =>      'active'],
            ))
            ->create();
    }
}
