<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MandatoryCourse extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'course_id',
        'profile_id',
        'company_id',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

}
