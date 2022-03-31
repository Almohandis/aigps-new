<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hospital::factory(7)
            ->state(new Sequence(
                ['name' =>  'Wadi Elneel Hospital'],
                ['name' =>  'El Safa Hospital'],
                ['name' =>  'El Nozha International Hospital'],
                ['name' =>  'El Salam Mohandesin Hospital'],
                ['name' =>  'El Salam International Hospital'],
                ['name' =>  'Hayat Medical Center'],
                ['name' =>  'Ibn Sina Hospital'],
            ))
            ->create();
    }
}
