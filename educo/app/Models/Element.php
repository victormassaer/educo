<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'title',
        'description',
        'type',
        'task_id',
        'video_id'
    ];

    public $timestamps = false;

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
