<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'location',
        'address',
        'status',   //# pending, active, completed
        'city',
        'capacity_per_day'
    ];

    public function doctors()
    {
        return $this->belongsToMany(User::class, 'campaign_doctors')->withPivot('from', 'to');
    }

    public function appointments() {
        return $this->belongsToMany(Campaign::class, 'campaign_appointments')->withPivot('date', 'status');
    }
}
