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
        'is_diagnosed',
        'city'
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
        return $this->belongsToMany(Campaign::class, 'campaign_appointments')->withPivot('date', 'id')->withTimestamps();
    }

    public function diseases()
    {
        return $this->hasMany(ChronicDisease::class);
    }

    public function hospitalizations()
    {
        return $this->belongsToMany(Hospital::class, 'hospitalizations')->withPivot('checkin_date', 'checkout_date');
    }

    public function infections()
    {
        return $this->hasMany(Infection::class);
    }

    public function relatives()
    {
        return $this->belongsToMany(User::class, 'user_relative', 'user_id', 'relative_id')->withPivot('relation', 'relative_id')->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_doctors')->withPivot('from', 'to');
    }

    public function passport()
    {
        return $this->hasOne(MedicalPassport::class);
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function answers()
    {
        return $this->belongsToMany(Question::class)->withPivot('answer')->withTimestamps();
    }

    //# DON'T DELETE OR REMOVE IT PLEASE, IT'S USED IN THE SEEDER
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('answer')->withTimestamps();
    }
}
