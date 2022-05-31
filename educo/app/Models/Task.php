<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'element_id',
    ];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }
    public function questions()
    {
        return $this->hasMany(Questions::class);
    }
}
