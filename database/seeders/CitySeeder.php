<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $cities = [
            'Alexandria'  =>  [
              'lat' =>  31.2001,
              'lng' =>  29.9187,
            ],
            'Aswan'  =>  [
              'lat' =>  24.0889,
              'lng' =>  32.8998,
            ],
            'Asyut'  =>  [
              'lat' =>  27.1783,
              'lng' =>  31.1859,
            ],
            'Beheira'  =>  [
              'lat' =>  30.8481,
              'lng' =>  30.3436,
            ],
            'Beni Suef'  =>  [
              'lat' =>  29.0661,
              'lng' =>  31.0994,
            ],
            'Cairo'  =>  [
              'lat' =>  30.0444,
              'lng' =>  31.2357,
            ],
            'Dakahlia'  =>  [
              'lat' =>  31.1656,
              'lng' =>  31.4913,
            ],
            'Damietta'  =>  [
              'lat' =>  31.4175,
              'lng' =>  31.8144,
            ],
            'Faiyum'  =>  [
              'lat' =>  29.3565,
              'lng' =>  30.6200,
            ],
            'Gharbia'  =>  [
              'lat' =>  30.8754,
              'lng' =>  31.0335,
            ],
            'Giza'  =>  [
              'lat' =>  30.0131,
              'lng' =>  31.2089,
            ],
            'Helwan'  =>  [
              'lat' =>  29.8403,
              'lng' =>  31.2982,
            ],
            'Ismailia'  =>  [
              'lat' =>  30.5965,
              'lng' =>  32.2715,
            ],
            'Kafr El Sheikh'  =>  [
              'lat' =>  31.1107,
              'lng' =>  30.9388,
            ],
            'Luxor'  =>  [
              'lat' =>  25.6872,
              'lng' =>  32.6396,
            ],
            'Matruh'  =>  [
              'lat' =>  31.3543,
              'lng' =>  27.2373,
            ],
            'Minya'  =>  [
              'lat' =>  28.0871,
              'lng' =>  30.7618,
            ],
            'Monufia'  =>  [
              'lat' =>  30.5972,
              'lng' =>  30.9876,
            ],
            'New Valley'  =>  [
              'lat' =>  24.5456,
              'lng' =>  27.1735,
            ],
            'North Sinai'  =>  [
              'lat' =>  30.2824,
              'lng' =>  33.6176,
            ],
            'Port Said'  =>  [
              'lat' =>  31.2653,
              'lng' =>  32.3019,
            ],
            'Qalyubia'  =>  [
              'lat' =>  30.3292,
              'lng' =>  31.2168,
            ],
            'Qena'  =>  [
              'lat' =>  26.1551,
              'lng' =>  32.7160,
            ],
            'Red Sea'  =>  [
              'lat' =>  24.6826,
              'lng' =>  34.1532,
            ],
            'Sharqia'  =>  [
              'lat' =>  30.7327,
              'lng' =>  31.7195,
            ],
            'Sohag'  =>  [
              'lat' =>  26.5591,
              'lng' =>  31.6957,
            ],
            'South Sinai'  =>  [
              'lat' =>  29.3102,
              'lng' =>  34.1532,
            ],
            'Suez'  =>  [
              'lat' =>  29.9668,
              'lng' =>  32.5498,
            ],
            '6th of October'  =>  [
              'lat' =>  29.9285,
              'lng' =>  30.9188,
            ]
        ];

        foreach ($cities as $name => $coordinates) {
            City::create([
                'name'  =>  $name,
                'lat'   =>  $coordinates['lat'],
                'lng'   =>  $coordinates['lng']
            ]);
        }
    }
}
