<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Infection;
use App\Models\NationalId;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NationalId::factory()->count(500)->create();
        $nationalIds = NationalId::pluck('national_id');

        foreach($nationalIds as $nid) {
            User::factory()
            ->hasPhones(2)
            ->for(Hospital::factory())
            ->has(Infection::factory(2))
            ->create([
                'national_id' => $nid
            ]);
        }
    }
}
