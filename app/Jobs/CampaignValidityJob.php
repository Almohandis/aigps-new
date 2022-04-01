<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            ->where('status', '!=', 'cancelled')
            ->where('end_date', '<=', now()->addDays(3))
            ->get();

        foreach ($campaigns as $campaign) {
            $start = new Carbon($campaign->start_date);
            $end = new Carbon($campaign->end_date);
            $days = $start->diffInDays($end);

            if (($days * $campaign->capacity_per_day) * 0.6 < $campaign->appointments()->count()) {
                $campaign->update([
                    'status'    =>  'cancelled'
                ]);

                DB::table('campaign_appointments')
                    ->where('campaign_id', $campaign->id)
                    ->where('status', '!=', 'cancelled')
                    ->where('status', '!=', 'finished')
                    ->update([
                        'status'    =>  'cancelled'
                    ]);
            }
        }

        $campaigns = Campaign::where('status', '!=', 'cancelled')->where('status', '!=', 'finished')->get();

        foreach ($campaigns as $campaign) {
            $start = new Carbon($campaign->start_date);
            $end = new Carbon($campaign->end_date);

            if ($end < now()) {
                $campaign->update([
                    'status'    =>  'finished'
                ]);

                DB::table('campaign_appointments')
                    ->where('campaign_id', $campaign->id)
                    ->where('status', '!=', 'cancelled')
                    ->update([
                        'status'    =>  'finished'
                    ]);
                continue;
            }

            if ($start > now()) {
                $campaign->update([
                    'status'    =>  'upcoming'
                ]);
                continue;
            }

            $campaign->update([
                'status'    =>  'active'
            ]);
        }
    }
}
