<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'start_time',
        'total_completed',
        'mandatory'
    ];

    public function participant() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->hasOne(Course::class);
    }
}
