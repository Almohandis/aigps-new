<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalStatistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'date',
        'recoveries',
        'deaths',
    ];
}
