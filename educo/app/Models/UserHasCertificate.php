<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificate_id',
    ];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function certificate() {
        return $this->hasOne(Certificate::class);
    }
}