<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hospital_id',
        'infection_date',
        'is_recovered',
        'has_passed_away',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
