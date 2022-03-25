<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Hospital;
use App\Models\NationalId;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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

    $this->user = User::create([
        'id' => 1,
        'name' => 'admin',
        'national_id' => 123,
        'role_id' => 1,
        'hospital_id' => 1,
    ]);

    //# Hospital
    Hospital::create([
        'id' => 1,
        'name' => 'Kampala',
        'city' => 'Kampala',
        'capacity' => 100,
        'is_isolation' => 0,
    ]);

    //# A hospital doctor
    User::create([
        'id' => 2,
        'name' => 'doctor',
        'national_id' => 122,
        'role_id' => 3,
        'hospital_id' => 1,
    ]);

    //# New hospital doctor
    User::create([
        'id' => 3,
        'name' => 'doctor',
        'national_id' => 133,
        'role_id' => 3,
    ]);


    $this->actingAs($this->user);
});

//# Moh can access manage hospitals page
test('moh can access manage hospitals page', function () {
    $response = $this->get('/staff/moh/manage-hospitals');
    $response->assertStatus(200);
});

//# Moh can access manage doctors page
test('moh can access manage doctors page', function () {
    $response = $this->get('/staff/moh/manage-doctors');
    $response->assertStatus(200);
});

//# Moh can access manage campaigns page
test('moh can access manage campaigns page', function () {
    $response = $this->get('/staff/moh/manage-campaigns');
    $response->assertStatus(200);
});

//# Moh can add new hospital
test('moh can add new hospital', function () {
    $response = $this->post('/staff/moh/manage-hospitals/add', [
        'name' => 'Kampala',
        'city' => 'Kampala',
        'capacity' => 200,
        'is_isolation' => 1,
    ]);

    $hospitals = Hospital::count();
    $this->assertEquals(2, $hospitals);
});

//# Moh can get hospital doctors using ajax
test('moh can get hospital doctors using ajax', function () {
    $response = $this->get('/staff/moh/manage-doctors/1');

    $response->assertStatus(200);
});

//# Moh can remove hospital doctors using ajax
test('moh can remove hospital doctors using ajax', function () {
    $response = $this->get('/staff/moh/manage-doctors/remove-doctor/2');

    $user = User::find(2);
    $this->assertEquals(0, $user->hospital_id);
});

//# Moh can add new hospital doctor
test('moh can add new hospital doctor', function () {
    $response = $this->post('/staff/moh/manage-doctors/add', [
        'hospital_id' => 1,
        'national_id' => 133,
    ]);

    $user = User::find(3);
    $this->assertEquals(1, $user->hospital_id);
});

//# Moh can add new campaign
test('moh can add new campaign', function () {
    $response = $this->post('/staff/moh/manage-campaigns/add', [
        'start_date' => '2020-01-01',
        'end_date' => '2022-02-02',
        'location' => "33.2344, 23.2344",
        'address' => 'cairo',
        'city' => 'cairo',
        'capacity_per_day' => 8,
    ]);

    $campaign = Campaign::count();
    $this->assertEquals(1, $campaign);
});
