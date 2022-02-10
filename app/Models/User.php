<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'national_id',
        'email',
        'password',
        'birthdate',
        'address',
        'telephone_number',
        'role_id',
        'gender',
        'blood_type',
        'hospital_id',
        'country',
        'is_diagnosed'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function phones()
    {
        return $this->hasMany('App\Models\Phone');
    }

    public function reservations()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_appointments')->withPivot('date');;
    }

    public function survey()
    {
        return $this->hasOne('App\Models\Survey');
    }

    public function diseases()
    {
        return $this->hasMany(ChronicDisease::class);
    }

    public function hospital()
    {
        return $this->hasOne(Hospital::class);
    }

    public function hospitalizations()
    {
        return $this->belongsToMany(Hospital::class, 'hospitalizations')->withPivot('checkin_date', 'checkout_date');
    }

    public function infections()
    {
        return $this->hasMany(Infection::class);
    }
}
