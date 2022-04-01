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
    public function run() {
        NationalId::factory()->count(200)->create();

        NationalId::factory()->count(9)->state(new Sequence(function ($sequence) {
            return [
                'national_id'   => '2971001890123' . $sequence->index + 1
            ];
        }))->create();
    }
}
