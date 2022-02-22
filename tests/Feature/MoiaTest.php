<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\NationalId;
use App\Models\User;

uses(RefreshDatabase::class);

beforeEach(function () {

    //# Future campaign
    Campaign::create([
        'id' => 1,
        'start_date' => now()->addDays(10),
        'end_date' => now(),
        'location' => 'Kampala',
        'address' => 'Kampala',
        'status' => 'pending',
        'type' => 'vaccination',
    ]);
    //# Ended campaign
    Campaign::create([
        'id' => 2,
        'start_date' => now()->subDays(1),
        'end_date' => now(),
        'location' => 'Kampala',
        'address' => 'Kampala',
        'type' => 'vaccination',
        'status' => 'active',
    ]);


    $this->user = User::factory()->make([
        'role_id' => 4,
    ]);

    $this->actingAs($this->user);
});

//# Moia can access escorting page
test('moia can access escorting page', function () {
    $response = $this->get('/staff/moia/escorting');

    $response->assertStatus(200);
});

//# Moia can modify campaign status (escort)
test('moia can modify campaign status escort', function () {

    $response = $this->get('/staff/moia/modify?id=1&action=Escort');

    $this->assertEquals(Campaign::where('status', 'active')->count(), 2);

    $response->assertStatus(200);
});

//# Moia can modify campaign status (undo escorting)
test('moia can modify campaign status undo escorting', function () {

    $response = $this->get('/staff/moia/modify?id=2&action=Undo%20Escort');
    $this->assertEquals(Campaign::where('status', 'pending')->count(), 2);

    $response->assertStatus(200);
});
