<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileHasSkill extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'skill_id',
        'company_id',
    ];

    public function profile() {
        return $this->hasOne(User::class);
    }

    public function company() {
        return $this->hasOne(Company::class);
    }
}