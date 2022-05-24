<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'img',
        'instructor_id',
        'mandatory',
        'duration',
        'number_of_chapters',
        'difficulty',
        'draft',
    ];

    public $timestamps = false;

    public function instructor()
    {
        return $this->belongsTo(User::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function participation() {
        return $this->belongsTo(Participation::class);
    }
}
