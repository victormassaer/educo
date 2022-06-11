<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function userHasSkills()
    {
        return $this->BelongsToMany(UserHasSkill::class);
    }
    public function coursesHasSkill()
    {
        return $this->hasMany(CourseHasSkill::class);
    }
    public function ProfileHasSkill()
    {
        return $this->BelongsToMany(ProfileHasSkills::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    public function Profiles()
    {
        return $this->BelongsToMany(Profile::class);
    }
}
