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
        'is_isolation',
    ];

    //# Relation to user (hospitalized patient)
    public function user()
    {
        return $this->belongsToMany(User::class)->withPivot('checkin_date', 'checkout_date');
    }

    //# Relation to user (doctor works in)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
