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
        'blood_type'
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

    //# Relation to medical passport
    public function medical_passport()
    {
        return $this->hasOne(MedicalPassport::class);
    }

    //# Relation to infections
    public function infections()
    {
        return $this->hasMany(Infection::class);
    }

    //# Relation to campaign appointments
    public function appointments()
    {
        return $this->hasMany(CampaignAppointment::class);
    }

    //# Relation to hospital (hospitalize)
    public function hospital()
    {
        return $this->belongsToMany(Hospital::class)->withPivot('checkin_date', 'checkout_date');
    }

    //# Relation to campaigns (campaign doctors)
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class)->withPivot('start_date', 'end_date');
    }

    //# Relation to hospital (works in)
    public function hospitals()
    {
        return $this->belongsTo(Hospital::class);
    }

    //# Relation to chronic diseases
    public function chronic_diseases()
    {
        return $this->belongsToMany(ChronicDisease::class);
    }


}
