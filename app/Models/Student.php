<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'matricule',
        'first_name',
        'last_name',
        'email',
        'filiere_id',
        'group',
    ];

   

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name} {$this->first_name}";
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
    public function juries()
    {
        return $this->belongsToMany(Jury::class)
            ->withTimestamps();
    }

   
}


