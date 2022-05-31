<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'element_id',
        'url',
    ];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }
}
