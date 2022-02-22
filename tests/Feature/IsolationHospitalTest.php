<?php

namespace Tests\Feature;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\NationalId;

uses(RefreshDatabase::class);

beforeEach(function () {

    NationalId::create([
        'national_id' => 123,
    ]);

    Hospital::create([
        'id' => 1,
        'name' => 'Kampala',
        'city' => 'Kampala',
        'capacity' => 100,
        'is_isolation' => 1,
    ]);

    $this->user = User::factory()->make([
        'id' => 1,
        'national_id' => 123,
        'role_id' => 6,
        'hospital_id' => 1,
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
        'available_beds' => 50,
        'recoveries' => 10,
        'deaths' => 5,
    ]);


    $this->assertEquals(Hospital::find($this->user->hospital_id)->capacity, 100);
    $this->assertEquals(Hospital::find($this->user->hospital_id)->available_beds, 50);
    $this->assertEquals(Hospital::find($this->user->hospital_id)->statistics()->first()->recoveries, 10);
    $this->assertEquals(Hospital::find($this->user->hospital_id)->statistics()->first()->deaths, 5);

    $response->assertRedirect('/staff/isohospital/modify');
});
