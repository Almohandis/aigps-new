<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NationalIdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $year = $this->faker->numberBetween(1900, 2022);
        $month = $this->faker->numberBetween(1, 12);
        $day = $this->faker->numberBetween(1, 28);

        $gender = $this->faker->numberBetween(1, 9);

        $cities = ['01', '02', '03', '04', '11', '12', '13', '14', '15', '16', '17', '18', '19', '21', '22', '23', '24', '25', '26', '27', '28', '29', '31', '32', '33', '34', '35', '88'];

        $melinium = $year > 2000 ? '3' : '2';

        $yearStr = $year % 100 < 10 ? '0' . $year % 100 : $year % 100;

        $monthStr = $month < 10 ? '0' . $month : $month;
        $dayStr = $day < 10 ? '0' . $day : $day;

        $unique = $this->faker->numberBetween(100, 999);

        // rand between cities
        $city = $this->faker->randomElement($cities);

        $control = $this->faker->numberBetween(0, 9);

        return [
            'national_id' => $melinium . $yearStr . $monthStr . $dayStr . $city . $unique . $gender . $control,
        ];
    }
}
