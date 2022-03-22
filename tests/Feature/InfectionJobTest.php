<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Notification;
use App\Jobs\InfectionNotificationJob;
use Illuminate\Support\Facades\Bus;
use App\Notifications\InfectionNotification;

uses(RefreshDatabase::class);

test('infected user relatives get notified of infection', function () {
    \Illuminate\Support\Facades\Notification::fake();
    Bus::fake();

    User::factory(3)->create();

    $user = User::find(1);
    $user2 = User::find(2);
    $user3 = User::find(3);

    
    $user->relatives()->attach($user2->id, [
        'relation'     =>      'brother'
    ]);

    $user->relatives()->attach($user3->id, [
        'relation'      =>      'sister'
    ]);

    $job = new InfectionNotificationJob($user);
    $job->handle();

    $this->assertEquals($user2->notifications()->count(), 1);
    $this->assertEquals($user3->notifications()->count(), 1);
});