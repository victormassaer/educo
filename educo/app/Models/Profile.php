<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'company_id',
    ];

    public function user() {
        return $this->hasMany(User::class);
    }

    public function profileHasSkills() {
        return $this->hasMany(ProfileHasSkills::class);
    }

    public function mandatoryCourse() {
        return $this->hasMany(MandatoryCourse::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'profile_has_skills');
    }



}
