<?php

namespace Tests\Feature;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\NationalId;

uses(RefreshDatabase::class);

beforeEach(function () {

    NationalId::create([
        'national_id' => 29710018901231,
    ]);
    NationalId::create([
        'national_id' => 29710018901233,
    ]);
    NationalId::create([
        'national_id' => 29710018901232,
    ]);

    $patient = User::factory()->create();
    $patient->national_id = 29710018901232;
    $patient->save();


    Hospital::create([
        'id' => 1,
        'name' => 'Kampala',
        'city' => 'Kampala',
        'capacity' => 100,
        'is_isolation' => 1,
    ]);

    //# Hospital clerk
    $this->user = User::create([
        'id' => 1,
        'name' => 'admin',
        'national_id' => 29710018901231,
        'role_id' => 6,
        'hospital_id' => 1,
    ]);

    //# Patient
    User::create([
        'id' => 2,
        'name' => 'Adam',
        'national_id' => 29710018901233,
        'role_id' => 3,
    ]);

    Hospital::find(1)->patients()->attach(2, [
        'checkin_date' => '2020-01-01',
        'checkout_date' => null,
    ]);


    $this->actingAs($this->user);
});

//# Isolation hospital can access isolation hospital page
test('isolation hospital can access isolation hospital page', function () {
    $response = $this->get('/staff/isohospital/infection');

    $response->assertStatus(200);
});


//# Isolation hospital can access patient's data modification page
test('isolation hospital can access patient\'s data modification page', function () {
    $response = $this->get('/staff/isohospital/infection');

    $response->assertStatus(200);
});

//# Isolation hospital can access add-new-patient page
// test('isolation hospital can access add-new-patient page', function () {
//     $response = $this->post('/staff/isohospital/infection/add',[
//         'national_id'   =>  29710018901232
//     ]);

//     $response->assertStatus(200);
// });

//# Isolation hospital can access detailed-patient-data page
// test('isolation hospital can access detailed-patient-data page', function () {

//     $response = $this->get('/staff/isohospital/infection/more/122');

//     $response->assertStatus(200);
// });

//# Isolation hospital can submit detailed patient's data
// test('isolation hospital can submit detailed patient\'s data', function () {
//     $response = $this->post('/staff/isohospital/infection/more/122', [
//         'name' => 'Ali',
//         'birthdate' => now(),
//         'address' => 'any add',
//         'telephone_number' => '0122222222',
//         'gender' => 'female',
//         'country'   =>  'Egypt',
//         'blood_type'    =>  'A+',
//         'is_diagnosed'  =>  0,
//     ]);
//     $patient = Hospital::find(1)->patients()->find(2);
//     $this->assertEquals($patient->name, "Ali");

//     $response->assertRedirect('/staff/isohospital/infection');
// });

//# Isolation hospital can update primary patient's data
// test('isolation hospital can update primary patient\'s data', function () {
//     $response = $this->post('/staff/isohospital/infection/save/122', [
//         'name' => 'Nour',
//         'birthdate' => now(),
//         'address' => 'any add',
//         'telephone_number' => '0122222222',
//         'gender' => 'male',
//         'blood_type' => 'A+',
//         'is_diagnosed' => 1,
//     ]);

//     $patient = Hospital::find(1)->patients()->find(2);
//     $this->assertEquals($patient->name, "Nour");
//     $this->assertEquals($patient->address, 'any add');
// });

//# Isolation hospital can submit new patient's data
test('isolation hospital can submit new patient\'s data', function () {
    $response = $this->post('/staff/isohospital/infection/add', [
        'national_id' => 29710018901232,
        'name' => 'New patient',
        'birthdate' => now(),
        'address' => 'any add',
        'telephone_number' => '0122222222',
        'gender' => 'male',
        'country' => 'Egypt',
        'blood_type' => 'A+',
        'is_diagnosed' => 1,
    ]);

    $patients = Hospital::find(1)->patients()->count();
    $this->assertEquals($patients, 2);
});
