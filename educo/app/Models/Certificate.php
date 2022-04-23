<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'img',
        'title',
        'skill_id',
        'date_acquired'
    ];

    public function skill() {
        return $this->belongsTo(Skill::class);
    }
}
