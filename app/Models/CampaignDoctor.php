<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignDoctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'start_date',
        'end_date'
    ];
}
