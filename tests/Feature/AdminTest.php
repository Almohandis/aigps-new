<?php

namespace Tests\Feature;

use App\Models\NationalId;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {

    NationalId::create([
        'national_id' => 29710018901231,
    ]);
    NationalId::create([
        'national_id' => 29710018901232,
    ]);
    $this->user = User::create([
        'id' => 1,
        'name' => 'admin',
        'national_id' => 29710018901231,
        'role_id' => 9,
    ]);
    User::create([
        'id' => 2,
        'name' => 'national id db',
        'national_id' => 29710018901232,
        'role_id' => 3,
    ]);

    $this->actingAs($this->user);
});

//# Admin can access manage roles page
test('Admin can access manage roles page', function () {
    $response = $this->actingAs($this->user)->get('/staff/admin');

    $response->assertStatus(200);
});

//# Admin can add roles
test('Admin can add roles', function () {
    $response = $this->post('/staff/admin/add', [
        'national_id' => 29710018901232,
        'role_id' => 2,
    ]);

    $user = User::find(2);
    $this->assertEquals(2, $user->role_id);
    $response->assertStatus(302);
});

//# Admin can update roles
test('Admin can update roles', function () {
    $response = $this->post('/staff/admin/2/update', [
        'role' => 5,
    ]);

    $user = User::find(2);
    $this->assertEquals(5, $user->role_id);
    $response->assertStatus(302);
});
