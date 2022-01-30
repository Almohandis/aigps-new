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
        'available_beds',
        'is_isolation',
    ];

    public function statistics()
    {
        return $this->hasMany(HospitalStatistics::class);
    }

    public function clerks()
    {
        return $this->belongsToMany(User::class, 'hospital_clerks');
    }
}
