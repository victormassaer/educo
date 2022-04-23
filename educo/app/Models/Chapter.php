<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'course_id',
    ];

    public function elements() {
        return $this->hasMany(Element::class);
    }
}
