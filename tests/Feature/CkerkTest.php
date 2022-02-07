<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ChronicDisease;
use App\Models\NationalId;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);


beforeEach(function () {
    NationalId::create([
        'national_id' => 555,
    ]);

    $this->user = User::factory()->create([
        'role_id'       =>      5,
        'national_id'   =>      555,
    ]);

    $this->user2 = User::factory()->create();

    $this->actingAs($this->user);
});

test('clerk page is rendered when user is clerk', function () {
    $response = $this->get('/staff/clerk');

    $response->assertStatus(200);
});

test('clerk page doesnt rendered when user is not clerk', function () {
    $this->actingAs($this->user2);
    $response = $this->get('/staff/clerk');

    $response->assertRedirect('/');
});

test('clerk can save user data', function () {
    $response = $this->post('/staff/clerk', [
        'national_id'   =>  '555',
        'blood_type' => 'A+',
        'is_diagnosed'  =>  'true',
        'disease1'  =>  'disease1',
        'disease2'  =>  'disease2'
    ]);

    $this->assertEquals($this->user->diseases()->count(), 2);
    $this->assertEquals(ChronicDisease::find(1)->name, 'disease1');
    $this->assertEquals(ChronicDisease::find(2)->name, 'disease2');
    $this->assertEquals(User::first()->is_diagnosed, '1');


    $this->assertEquals(User::first()->blood_type, 'A+');

    $response->assertStatus(200);
});