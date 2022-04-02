<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\Roles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Roles;

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
        return $this->belongsToMany(Campaign::class, 'campaign_appointments')->withPivot('date', 'id', 'status')->withTimestamps();
    }

    public function diseases()
    {
        return $this->hasMany(ChronicDisease::class);
    }

    //# DON'T DELETE IT OR REMOVE IT PLEASE, IT'S USED IN THE SEEDER
    public function chronicDiseases()
    {
        return $this->hasMany(ChronicDisease::class);
    }

    public function hospitalizations()
    {
        return $this->belongsToMany(Hospital::class, 'hospitalizations', 'user_id', 'hospital_id')->withPivot('checkin_date', 'checkout_date');
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
        return $this->belongsToMany(Question::class)->withPivot('answer', 'created_at')->withTimestamps();
    }

    public function hasSurvey() {
        return $this->answers()->where('question_user.created_at', '>', now()->subDays(14))->exists();
    }

    //# DON'T DELETE OR REMOVE IT PLEASE, IT'S USED IN THE SEEDER
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('answer')->withTimestamps();
    }

    public function routeNotificationForTwilio() {
        $phone = $this->phones()->first() ?? NULL;
        return $phone;
    }

    public function emailProfiles() {
        return $this->hasMany(EmailProfile::class);
    }

    public function getCity() {
        return City::where('name', $this->city)->first();
    }
}
