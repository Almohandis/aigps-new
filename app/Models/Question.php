<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
    ];

    public function answers() {
        return $this->belongsToMany(User::class)->withPivot('id', 'answer');
    }
}
