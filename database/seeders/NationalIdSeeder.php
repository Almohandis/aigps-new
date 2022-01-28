<?php

namespace Database\Seeders;

use Brick\Math\BigInteger;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Type\Integer;

class NationalIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //# Seeder
        DB::table('national_ids')->insert([
            'national_id' => BigInteger::randomBits(9),
        ]);
    }
}
