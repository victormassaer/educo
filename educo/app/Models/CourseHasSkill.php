<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseHasSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'skill_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
