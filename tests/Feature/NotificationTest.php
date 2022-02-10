<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Notification;
use App\Models\NationalId;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);


beforeEach(function () {
    NationalId::create([
        'national_id' => 555,
    ]);

    $this->user = User::factory()
    ->create([
        'role_id'       =>      5,
        'national_id'   =>      555,
    ]);

    Notification::factory()->count(5)->create([
        'read'      =>      false,
        'user_id'   =>      $this->user->id,
    ]);

    $this->actingAs($this->user);
});

test('user can visit notifications page', function () {
    $response = $this->get('/notifications');

    $response->assertStatus(200);
});

test('notifications are read when user open notifications page', function () {
    $response = $this->get('/notifications');

    $this->assertEquals(0, DB::table('notifications')->where('read', false)->count());
    $this->assertEquals(5, DB::table('notifications')->where('read', true)->count());

    $response->assertStatus(200);
});