<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\NationalId;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Question;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);


beforeEach(function () {
    NationalId::create([
        'national_id' => 29710018901232,
    ]);

    $this->user = User::factory()->create();
    $this->campaign = Campaign::factory()->create();
    $this->user->reservations()->attach(1, ['date' => '2020-01-01']);

    Question::factory(4)->create();
    DB::table('question_user')->insert([
        'user_id' => $this->user->id,
        'question_id' => 1,
        'answer' => 'Yes',
        'created_at'    =>  now()
    ]);


    $this->actingAs($this->user);
});

test('appointments page gets rendered', function () {
    $response = $this->get('/appointments');

    // assert see the appointments
    // $response->assertSee('2020-01-01');

    $response->assertStatus(200);
});

test('appointments can be cancelled', function () {
    $response = $this->get('/appointments/1/cancel');

    $this->assertEquals(1, $this->user->reservations()->where('campaign_appointments.status', 'cancelled')->count());

    $response->assertStatus(302);
});
