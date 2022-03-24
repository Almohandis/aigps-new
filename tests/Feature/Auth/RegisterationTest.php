<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\NationalId;
use App\Models\User;
use App\Providers\RouteServiceProvider;

uses(RefreshDatabase::class);

beforeEach(function () {
    NationalId::create([
        'national_id' => 22345678901234,
    ]);
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});


test('new users can register', function () {
    $response = $this->post('/register', [
        'national_id'           =>  '22345678901234',
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'address' => 'Test Address',
        'telephone_number' => '555-555-5555',
        'country'       =>  'US',
        'city'         =>  'CA',
        'birthdate'    =>  '1990-01-01',
        'gender'        =>  'Male'
    ]);

    $this->assertEquals(1, User::count());

    $this->assertAuthenticated();
    $response->assertRedirect('/survey');
});

test('new users cannot register with invalid national id', function () {
    $response = $this->post('/register', [
        'national_id'           =>  333,
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'address' => 'Test Address',
        'telephone_number' => '555-555-5555',
        'country'       =>  'US',
        'city'         =>  'CA',
        'birthdate'    =>  '1990-01-01',
        'gender'        =>  'Male'
    ]);

    $this->assertEquals(0, User::count());
    $this->assertGuest();
});
