<?php

namespace Database\Seeders;

use App\Models\NationalId;
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
        NationalId::factory()->count(20)->create();
    }
}
