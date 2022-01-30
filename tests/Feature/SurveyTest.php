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

    $this->actingAs($this->user);
});

test('survey page is rendered when user doesnt have survey', function () {
    $response = $this->get('/survey');

    $response->assertStatus(200);
});

test('survey page doesnt render when user completed the survey already', function () {
    $this->user->survey()->create([
        'question1' => '1',
        'question2' => '2',
        'question3' => '3',
        'question4' => '4',
    ]);

    $response = $this->get('/survey');

    $response->assertRedirect('/');
});

test('user can submit survey', function () {
    $response = $this->post('/survey', [
        'question1' => '1',
        'question2' => '2',
        'question3' => '3',
        'question4' => '4'
    ]);

    $this->assertTrue($this->user->survey()->exists());

    $response->assertRedirect('/');
});