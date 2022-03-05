<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Article;
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

    Article::factory(3)->create();

    $this->actingAs($this->user);
});

test('user can open articles list page', function () {
    $response = $this->get('/articles');

    $response->assertStatus(200);
    $response->assertSee(Article::find(1)->title);
    $response->assertSee(Article::find(2)->title);
    $response->assertSee(Article::find(3)->title);
});

test('user can open specific article', function () {
    $response = $this->get('/articles/1');

    $response->assertStatus(200);
    $response->assertSee(Article::find(1)->title);
    $response->assertSee(Article::find(1)->content);
});