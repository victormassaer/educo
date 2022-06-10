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
        'video_id',
        'order'
    ];

    public $timestamps = false;

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function video()
    {
        return $this->hasOne(Video::class);
    }
    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
