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
        NationalId::factory()->count(3)->create();
        $nationalIds = NationalId::get();
        $ids = array();
        foreach ($nationalIds as $nationalId) {
            $ids[] = $nationalId->national_id;
        }

        for ($i = 0; $i < 3; $i++) {
            User::factory()
                ->hasPhones(2)
                ->for(Hospital::factory())
                ->has(Infection::factory(2))
                ->create([
                    'national_id' => $ids[$i],
                ]);
        }
    }
}
