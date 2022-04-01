<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hospital::factory(35)
            ->state(new Sequence(
                ['name' =>  'Wadi Elneel Hospital'],
                ['name' =>  'El Safa Hospital'],
                ['name' =>  'El Nozha International Hospital'],
                ['name' =>  'El Salam Mohandesin Hospital'],
                ['name' =>  'El Salam International Hospital'],
                ['name' =>  'Hayat Medical Center'],
                ['name' =>  'Ibn Sina Hospital'],
                ['name' =>  'Dar el Salam General Hospital'],
                ['name' =>  'Dar el Oyoun Hospital'],
                ['name' =>  'Dar El Teb Diagnostic Center'],
                ['name' =>  'Dar El Teb IVF Center'],
                ['name' =>  'Dar El Shefa Hospital'],
                ['name' =>  'Demerdash Hospital'],
                ['name' =>  'El Merghany Hospital'],
                ['name' =>  'El Mobarra MaadiHospital'],
                ['name' =>  'El Monera General Hospital'],
                ['name' =>  'El Nada Maternity Hospital'],
                ['name' =>  'International Medical Center Cairo'],
                ['name' =>  'Italian Hospita Cairo'],
                ['name' =>  'Greek Hospital Cairo'],
                ['name' =>  'El Kabbari'],
                ['name' =>  'El Mamoora Psychiatry Hospital'],
                ['name' =>  'El Madina El Tebbeya'],
                ['name' =>  'El Maleka Nazly Paediatric Hospital'],
                ['name' =>  'El Mowassah'],
                ['name' =>  'El Seguini (El Sammak Hospital)'],
                ['name' =>  'El Sherook'],
                ['name' =>  'El Thaghr Specialized'],
                ['name' =>  'El Sharkia Eye Center'],
                ['name' =>  'El Delta Abdel Latif Hospital'],
                ['name' =>  'Alzakazik International Hospital'],
                ['name' =>  'Al Obour Specialized Hospital'],
                ['name' =>  'Al Fatah Specialized Hospital'],
                ['name' =>  'Al Fredaws Specialized Hospital'],
                ['name' =>  'Al Forkan Specialized Hospital'],
                ['name' =>  'Al Montazah Specialized Hospital']
            ))
            ->create();
    }
}
