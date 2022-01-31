<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\NationalId;
use App\Models\User;

uses(RefreshDatabase::class);

beforeEach(function () {
    NationalId::create([
        'national_id' => 123,
    ]);

    $this->user = User::factory()->make([
        'role_id' => 4,
    ]);

    $this->actingAs($this->user);
});
