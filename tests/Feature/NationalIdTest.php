<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\NationalId;
use App\Models\User;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    NationalId::create([
        'national_id' => 123,
    ]);

    $this->user = User::factory()->make([
        'role_id' => 2,
    ]);

    $this->actingAs($this->user);
});

//# National id can access national id modify page
test('modifying national IDs page can be rendered', function () {
    $response = $this->get('/staff/nationalid/modify');

    $response->assertStatus(200);
});

//# National id cannot add new natinoal id if it exists
test('national id cannot add new national id if it exist', function () {
    $response = $this->post('/staff/nationalid/modify', [
        'entered_id' => 123,
        'add' => true,
    ]);

    $this->assertEquals(NationalId::count(), 1);
});

//# National id can add new national id if it does not exist
test('national id can add new national id if it does not exist', function () {
    $response = $this->post('/staff/nationalid/add', [
        'entered_id' => 999,
        'add' => true,
    ]);
    $natinoalId = NationalId::find(999)->national_id;
    $this->assertEquals($natinoalId, 999);
    $response->assertRedirect('/staff/nationalid/modify');
});

//# National id can delete national id if it exists
test('national id can delete national id if it exists', function () {
    $response = $this->post('/staff/nationalid/add', [
        'entered_id' => 123,
        'delete' => true,
    ]);

    $this->assertEquals(NationalId::count(), 0);
    $response->assertRedirect('/staff/nationalid/modify');
});

//# National id cannot delete national id if it does not exist
test('national id cannot delete national id if it does not exist', function () {
    $response = $this->post('/staff/nationalid/add', [
        'entered_id' => 321,
        'delete' => true,
    ]);

    $this->assertEquals(NationalId::count(), 1);
});
