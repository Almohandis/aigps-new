<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_id',
        'date',
    ];

    //# Inverse relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //# Inverse relation to campaign
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
