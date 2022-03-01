<?php

namespace Tests\Feature;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\NationalId;

use function PHPUnit\Framework\assertGreaterThan;

uses(RefreshDatabase::class);

beforeEach(function () {

    NationalId::create([
        'national_id' => 123,
    ]);
    NationalId::create([
        'national_id' => 122,
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
        'name' => 'dm',
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
test('isolation hospital can modify hospital statistics', function () {

    $response = $this->post('/staff/isohospital/update', [
        'hospital' => 1,
        'total_capacity' => 100,
        "care_beds" => 60,
        'avail_care_beds' => 50,
        'available_beds' => 30,
        'recoveries' => 10,
        'deaths' => 5,
    ]);

    $care_beds = Hospital::find(1)->care_beds;
    $available_beds = Hospital::find(1)->available_beds;
    $total_capacity = Hospital::find(1)->capacity;

    if (!($care_beds + $available_beds == 100)) {
        $this->assertGreaterThan($care_beds + $available_beds, $total_capacity);
    }


    $this->assertEquals(Hospital::find($this->user->hospital_id)->capacity, 100);
    $this->assertEquals(Hospital::find($this->user->hospital_id)->care_beds, 60);
    $this->assertEquals(Hospital::find($this->user->hospital_id)->avail_care_beds, 50);
    $this->assertEquals(Hospital::find($this->user->hospital_id)->available_beds, 30);
    $this->assertEquals(Hospital::find($this->user->hospital_id)->statistics()->first()->recoveries, 10);
    $this->assertEquals(Hospital::find($this->user->hospital_id)->statistics()->first()->deaths, 5);

    $response->assertRedirect('/staff/isohospital/modify');
});

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
        'name' => 'ali',
        'birthdate' => now(),
        'address' => 'any add',
        'telephone_number' => '0122222222',
        'gender' => 'female',
        'country'   =>  'Egypt',
        'blood_type'    =>  'A+',
        'is_diagnosed'  =>  0,
    ]);
    // dd( $response->getContent());
    $patient = Hospital::find(1)->patients()->find(2);
    // dd($patient->toArray());
    // expect($patient->toArray())->dd();
    $this->assertEquals($patient->name, "ali");
});
