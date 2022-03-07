<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\ChronicDisease;
use App\Models\NationalId;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use App\Jobs\InfectionNotificationJob;

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
    Bus::fake();

    $response = $this->post('/staff/clerk', [
        'national_id'   =>  '555',
        'blood_type'    => 'A+',
        'is_diagnosed'  =>  'true',
        'disease1'      =>  'disease1',
        'disease2'      =>  'disease2',
        'infection'     =>  '02/26/2022',
        'is_recovered'  =>  'true',
        'city'          =>  'city',
    ]);

    $this->assertEquals($this->user->diseases()->count(), 2);
    $this->assertEquals(ChronicDisease::find(1)->name, 'disease1');
    $this->assertEquals(ChronicDisease::find(2)->name, 'disease2');

    $this->assertEquals(User::first()->is_diagnosed, '1');
    $this->assertEquals(User::first()->city, 'city');

    $this->assertTrue(User::first()->infections()->exists());
    $this->assertEquals(User::first()->infections()->first()->infection_date, '02/26/2022');
    $this->assertEquals(User::first()->infections()->first()->is_recovered, '1');


    $this->assertEquals(User::first()->blood_type, 'A+');

    Bus::assertDispatched(InfectionNotificationJob::class);

    $response->assertStatus(200);
});