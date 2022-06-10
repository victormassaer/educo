<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_id',
    ];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function skill() {
        return $this->hasOne(Skill::class);
    }
}
