<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChronicDisease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    //# Relation to user (chronic disease)
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
