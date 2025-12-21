<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = [
        'department_id',
        'code',
        'name',
        'level',
        'is_active',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}

