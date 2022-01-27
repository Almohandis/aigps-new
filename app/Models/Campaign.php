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
        'type',
        'location',
        'address',
    ];

    //# Relation to campaign appointments
    public function campaign_appointments()
    {
        return $this->hasMany(CampaignAppointment::class);
    }

    //# Relation to users (doctors)
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('start_date', 'end_date');
    }


}
