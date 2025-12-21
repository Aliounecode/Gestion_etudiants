<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsables';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'grade',
        'is_active',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return trim(($this->grade ? $this->grade.' ' : '').$this->first_name.' '.$this->last_name);
    }

    public function modules()
    {
        // plus tard : Module aura une colonne responsable_id
        return $this->hasMany(Module::class, 'responsable_id');
    }
}

