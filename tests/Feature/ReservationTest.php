<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\NationalId;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Question;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Notifications\ReservationNotification;

uses(RefreshDatabase::class);


beforeEach(function () {
    NationalId::create([
        'national_id' => 555,
    ]);

    $this->user = User::factory()->create();
    Question::factory(1)->create();
    DB::table('question_user')->insert([
        'user_id' => $this->user->id,
        'question_id' => 1,
        'answer' => 'No',
        'created_at'    =>  now()
    ]);

    Campaign::factory()->create([
        'start_date' => '2020-01-01',
        'end_date' => now()->addDays(10)
    ]);

    for($i = 0; $i < 20; $i++) {
        Campaign::find(1)->appointments()->attach(1, ['date'    =>  '2020-01-01', 'user_id' =>  1]);
    }

    $this->actingAs($this->user);
});

test('reservation page1 can be rendered', function () {
    $response = $this->get('/reserve');

    $response->assertStatus(200);
});

test('User cannot reserve when survey answer has Yes', function () {
    DB::table('question_user')->insert([
        'user_id' => $this->user->id,
        'question_id' => 1,
        'answer' => 'Yes',
        'created_at'    =>  now()
    ]);

    $response = $this->get('/reserve');

    $response->assertViewIs('citizen.survey-error');
});

test('reservation page1 can create appointment', function () {
    Notification::fake();

    $response = $this->post('/reserve/map/1');

    $this->assertEquals(DB::table('campaign_appointments')->count(), 21);

    $this->assertEquals(DB::table('campaign_appointments')->where('campaign_id', 1)->where('user_id', $this->user->id)->where('date', '>=', '2020-01-01')->where('date', '<=', now()->addDays(10))->count(), 21);

    $this->assertTrue(DB::table('campaign_appointments')->where('id', 21)->where('date', '2020-01-02')->exists());

    $response->assertViewIs('citizen.reservecomplete');

    Notification::assertSentTo($this->user, ReservationNotification::class);
});

test('user cannot make a reservation when he already has one active', function () {
    Campaign::find(1)->appointments()->attach(1, ['date'    =>  now(), 'user_id' =>  1]);

    $response = $this->from('/reserve')->post('/reserve/map/1');

    $this->assertEquals(21, DB::table('campaign_appointments')->count());

    $response->assertRedirect('/reserve');
});