<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['code', 'name', 'head_of_department', 'is_active'];

    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }
}

