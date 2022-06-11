<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_id',
        'profile_picture',
        'age',
        'company_id',
        'role_id',
        'gender',
        'degree',
        'country'
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

    public function skills()
    {
        //userhasskill table aanmaken
        return $this->hasMany(Skill::class);
    }
    public function userHasSkills()
    {
        //userhasskill table aanmaken
        return $this->hasMany(userHasSkill::class);
    }

    public function certificate()
    {
        return $this->hasMany(Certificate::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function participation()
    {
        return $this->hasMany(Participation::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
