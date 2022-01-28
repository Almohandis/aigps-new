<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class NationalIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\NationalId::factory(2)
        ->state(new Sequence(
            ['national_id' => '1234'],
            ['national_id' => '12345'],
        ))
        ->create();
    }
}
