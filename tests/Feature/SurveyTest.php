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
        'national_id' => 555,
    ]);

    $this->user = User::factory()->create();
    Question::factory(4)->create();

    $this->actingAs($this->user);
});

test('survey page is rendered when user doesnt have survey', function () {
    $response = $this->get('/survey');

    $response->assertStatus(200);
});

test('survey page doesnt render when user completed the survey already', function () {
    DB::table('question_user')->insert([
        'user_id' => $this->user->id,
        'question_id' => 1,
        'answer' => 'Yes',
        'created_at'    =>  now()
    ]);

    $response = $this->get('/survey');

    $response->assertRedirect('/');
});

test('user can submit survey', function () {
    $response = $this->post('/survey', [
        'answers'    => [
            '1' => 'Yes',
            '2' => 'No',
            '3' => 'Yes',
            '4' => 'No',
        ],
    ]);

    $this->assertEquals(DB::table('question_user')->where('user_id', $this->user->id)->count(), 4);

    $response->assertRedirect('/');
});