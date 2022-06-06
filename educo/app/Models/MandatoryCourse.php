<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandatoryCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'profile_id',
        'company_id',
    ];

    public function course()
    {
        return $this->hasOne(Course::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


}
