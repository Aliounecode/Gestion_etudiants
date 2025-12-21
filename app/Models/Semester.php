<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [
        'code',
        'name',
        'order',
        'is_active',
    ];

    public function modules()
    {
        return $this->hasMany(Module::class, 'semester_id');
    }
}

