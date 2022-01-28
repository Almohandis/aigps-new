<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(1)
        ->hasPhones(1)
        ->create([
            'email'         =>  'test@test.com',
            'national_id'   =>  12345
        ]);
    }
}
