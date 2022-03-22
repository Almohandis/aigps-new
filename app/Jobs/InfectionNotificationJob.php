<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Notifications\InfectionNotification;
use Illuminate\Support\Facades\Notification;


class InfectionNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->relatives()->get()->each(function ($user) {
            $user->notifications()->create([
                'text'  => 'Your relative ('.$this->user->name.') has been infected!',
                'read'  =>  false
            ]);
        });

        $relatives = $this->user->relatives()->get();
        Notification::send($relatives, new InfectionNotification($this->user));
    }
}
