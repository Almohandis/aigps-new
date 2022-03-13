<?php

namespace Tests\Feature;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\NationalId;

uses(RefreshDatabase::class);

beforeEach(function () {

    NationalId::create([
        'national_id' => 123,
    ]);
    NationalId::create([
        'national_id' => 122,
    ]);
    NationalId::create([
        'national_id' => 133,
    ]);


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
        'national_id' => 123,
        'role_id' => 6,
        'hospital_id' => 1,
    ]);

    //# Patient
    User::create([
        'id' => 2,
        'name' => 'Adam',
        'national_id' => 122,
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
    $response = $this->get('/staff/isohospital/modify');

    $response->assertStatus(200);
});

//# Isolation hospital can modify hospital statistics
//# This route has been disabled
// test('isolation hospital can modify hospital statistics', function () {

//     // $response = $this->post('/staff/isohospital/update', [
//     //     'hospital' => 1,
//     //     'total_capacity' => 100,
//     //     "care_beds" => 60,
//     //     'avail_care_beds' => 50,
//     //     'available_beds' => 30,
//     //     'recoveries' => 10,
//     //     'deaths' => 5,
//     // ]);

//     // $care_beds = Hospital::find(1)->care_beds;
//     // $available_beds = Hospital::find(1)->available_beds;
//     // $total_capacity = Hospital::find(1)->capacity;

//     // if (!($care_beds + $available_beds == 100)) {
//     //     $this->assertGreaterThan($care_beds + $available_beds, $total_capacity);
//     // }


//     // $this->assertEquals(Hospital::find($this->user->hospital_id)->capacity, 100);
//     // $this->assertEquals(Hospital::find($this->user->hospital_id)->care_beds, 60);
//     // $this->assertEquals(Hospital::find($this->user->hospital_id)->avail_care_beds, 50);
//     // $this->assertEquals(Hospital::find($this->user->hospital_id)->available_beds, 30);
//     // $this->assertEquals(Hospital::find($this->user->hospital_id)->statistics()->first()->recoveries, 10);
//     // $this->assertEquals(Hospital::find($this->user->hospital_id)->statistics()->first()->deaths, 5);

//     // $response->assertRedirect('/staff/isohospital/modify');
// });

//# Isolation hospital can access patient's data modification page
test('isolation hospital can access patient\'s data modification page', function () {
    $response = $this->get('/staff/isohospital/infection');

    $response->assertStatus(200);
});

//# Isolation hospital can access add-new-patient page
test('isolation hospital can access add-new-patient page', function () {
    $response = $this->get('/staff/isohospital/infection/add');

    $response->assertStatus(200);
});

//# Isolation hospital can access detailed-patient-data page
test('isolation hospital can access detailed-patient-data page', function () {

    $response = $this->get('/staff/isohospital/infection/more/122');

    $response->assertStatus(200);
});

//# Isolation hospital can submit detailed patient's data
test('isolation hospital can submit detailed patient\'s data', function () {
    $response = $this->post('/staff/isohospital/infection/more/122', [
        'name' => 'Ali',
        'birthdate' => now(),
        'address' => 'any add',
        'telephone_number' => '0122222222',
        'gender' => 'female',
        'country'   =>  'Egypt',
        'blood_type'    =>  'A+',
        'is_diagnosed'  =>  0,
    ]);
    $patient = Hospital::find(1)->patients()->find(2);
    $this->assertEquals($patient->name, "Ali");

    $response->assertRedirect('/staff/isohospital/infection');
});

//# Isolation hospital can update primary patient's data
test('isolation hospital can update primary patient\'s data', function () {
    $response = $this->post('/staff/isohospital/infection/save/122', [
        'name' => 'Nour',
        'birthdate' => now(),
        'address' => 'any add',
        'telephone_number' => '0122222222',
        'gender' => 'male',
        'blood_type' => 'A+',
        'is_diagnosed' => 1,
    ]);

    $patient = Hospital::find(1)->patients()->find(2);
    $this->assertEquals($patient->name, "Nour");
    $this->assertEquals($patient->address, 'any add');
});

//# Isolation hospital can submit new patient's data
test('isolation hospital can submit new patient\'s data', function () {
    $response = $this->post('/staff/isohospital/infection/add', [
        'national_id' => 133,
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
