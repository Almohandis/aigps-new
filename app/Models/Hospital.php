<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'city',
        'care_beds',
        'avail_care_beds',
        'available_beds',
        'is_isolation',
    ];

    public function statistics()
    {
        return $this->hasMany(HospitalStatistics::class);
    }

    public function clerks()
    {
        return $this->hasMany(User::class);
    }
    public function patients()
    {
        return $this->belongsToMany(User::class, 'hospitalizations')->withPivot('checkin_date', 'checkout_date');
    }
}
