<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HosptialDoctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'hosptial_id',
        'user_id',
    ];
}
