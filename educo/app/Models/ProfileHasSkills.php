<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileHasSkills extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'skill_id',
        'company_id',
    ];

    public function profiles(){
        return $this->hasMany(Profile::class, 'profiles');
    }
    public function skills(){
        return $this->hasMany(Skill::class, 'skills');
    }
}
