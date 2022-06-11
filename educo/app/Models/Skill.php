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

    public function ProfileHasSkills(){
        return $this->belongsToMany(ProfileHasSkills::class);
    }

    public function Profiles(){
        return $this->BelongsToMany(Profile::class);
    }
}
