<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ChronicDisease;
use App\Models\NationalId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use App\Jobs\InfectionNotificationJob;
use App\Models\Campaign;
use App\Notifications\InfectionNotification;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);


beforeEach(function () {
    NationalId::create([
        'national_id' => 29710018901232,
    ]);
    NationalId::create([
        'national_id' => 29710018901231,
    ]);

    $this->user = User::create([
        'id' => 1,
        'name' => 'Ali',
        'role_id'       =>      5,
        'national_id'   =>      29710018901232,
    ]);

    $campaign = Campaign::factory()->create();
    $campaign->start_date = '2022-06-01';
    $campaign->end_date = '2022-06-29';
    $campaign->status = 'active';
    $campaign->save();
    $this->user->reservations()->attach(1, [
        'date'  => now(),
    ]);
    $this->user->campaigns()->attach($campaign, [
        'from'  =>  '2022-06-01',
        'to'    =>  '2022-06-29'
    ]);

    // add relative to user
    $this->user->relatives()->attach(2, [
        'relation' => 'father',
    ]);

    // add phone to user
    $this->user->phones()->create([
        'phone_number' => '09122222222',
    ]);

    $this->user2 = User::create([
        'id' => 2,
        'name' => 'Adam',
        'role_id' => 3,
        'national_id' => 29710018901231,
    ]);

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
    Bus::fake();

    $response = $this->post('/staff/clerk/1/complete', [
        'national_id'   =>  '29710018901232',
        'blood_type'    => 'A+',
        'is_diagnosed'  =>  'true',
        'disease1'      =>  'disease1',
        'disease2'      =>  'disease2',
        'infection'     =>  '2022-06-22',
        'is_recovered'  =>  'true',
        'city'          =>  'city',
    ]);
    $response->assertStatus(302);

    $this->assertEquals($this->user->diseases()->count(), 2);
    $this->assertEquals(ChronicDisease::find(1)->name, 'disease1');
    $this->assertEquals(ChronicDisease::find(2)->name, 'disease2');
    $this->assertTrue(User::first()->infections()->exists());

    // $this->assertEquals(User::find(1)->is_diagnosed, 1);
    // $this->assertEquals(User::first()->city, 'city');

    // $this->assertEquals(User::first()->infections()->first()->infection_date, '2022-06-22');
    // $this->assertEquals(User::first()->infections()->first()->is_recovered, 1);


    // $this->assertEquals(User::first()->blood_type, 'A+');

    // Bus::assertDispatched(InfectionNotificationJob::class);
});
