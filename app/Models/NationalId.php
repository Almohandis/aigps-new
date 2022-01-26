<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationalId extends Model
{
    use HasFactory;

    protected $primaryKey = 'national_id';

    protected $fillable = [
        'national_id'
    ];

    public $timestamps = false;
}
