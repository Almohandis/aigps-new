<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\NationalId;
use App\Models\User;
use App\Models\Campaign;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);


beforeEach(function () {
    NationalId::create([
        'national_id' => 555,
    ]);

    $this->user = User::factory()->create();
    $this->user->survey()->create([
        'question1' => '1',
        'question2' => '2',
        'question3' => '3',
        'question4' => '4',
    ]);

    Campaign::factory()->create([
        'start_date' => '2020-01-01',
        'end_date' => now()->addDays(10)
    ]);

    $this->actingAs($this->user);
});

test('reservation page1 can be rendered when data is incomplete', function () {
    $response = $this->get('/reserve');

    $response->assertStatus(200);
});

test('reservation page1 can can save user data correctly', function () {
    $response = $this->post('/reserve', [
        'address' => 'address',
        'telephone_number' => '123456789',
        'birthdate' => '1999-01-01',
        'phone1'        =>  '123456789',
        'phone2'        =>  '123456789',
        'gender'        =>  'Male',
        'country'       =>  'Egypt'
    ]);

    $this->assertEquals($this->user->address, 'address');
    $this->assertEquals($this->user->telephone_number, '123456789');
    $this->assertEquals($this->user->birthdate, '1999-01-01');
    $this->assertEquals($this->user->gender, 'Male');
    $this->assertEquals($this->user->country, 'Egypt');

    $this->assertEquals($this->user->phones->count(), 2);

    $response->assertRedirect('/reserve/step2');
});

test('reservation page1 redirect to page2 when data is complete', function () {
    $this->user->update([
        'address' => 'address',
        'telephone_number' => '123456789',
        'birthdate' => '1999-01-01',
        'gender'        =>  'Male',
        'country'       =>  'Egypt'
    ]);
    $this->user->phones()->create([
        'phone_number'  =>  '123456789'
    ]);

    $response = $this->get('/reserve');

    $response->assertRedirect('/reserve/step2');
});

test('reservation page2 can be rendered', function () {
    $this->user->update([
        'address' => 'address',
        'telephone_number' => '123456789',
        'birthdate' => '1999-01-01',
        'gender'        =>  'Male',
        'country'       =>  'Egypt'
    ]);

    $this->user->phones()->create([
        'phone_number'  =>  '123456789'
    ]);

    $response = $this->get('/reserve/step2');

    $response->assertStatus(200);
});

test('reservation page2 can save data', function () {
    $this->user->update([
        'address' => 'address',
        'telephone_number' => '123456789',
        'birthdate' => '1999-01-01',
        'gender'        =>  'Male'
    ]);

    $this->user->phones()->create([
        'phone_number'  =>  '123456789'
    ]);

    $response = $this->post('/reserve/final/1');

    $this->assertEquals(DB::table('campaign_appointments')->count(), 1);

    $this->assertTrue(DB::table('campaign_appointments')->where('campaign_id', 1)->where('user_id', $this->user->id)->where('date', '>=', '2020-01-01')->where('date', '<=', now()->addDays(10))->exists());

    $response->assertStatus(200);
});