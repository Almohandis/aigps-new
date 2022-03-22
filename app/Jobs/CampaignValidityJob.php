<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Carbon\Carbon;

class CampaignValidityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaigns = Campaign::where('start_date', '>=', now()->addDays(2))
            ->where('end_date', '<=', now()->addDays(3))
            ->get();

        foreach ($campaigns as $campaign) {
            $start = new Carbon($campaign->start_date);
            $end = new Carbon($campaign->end_date);
            $days = $start->diffInDays($end);

            if ($days * $campaign->capacity_per_day < $campaign->appointments()->count()) {
                $campaign->update([
                    'status'    =>  'cancelled'
                ]);
            }
        }
    }
}
