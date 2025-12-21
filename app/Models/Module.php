<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'filiere_id',
        'semester_id',
        'responsable_id',
        'code',
        'title',
        'status',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function responsable()
    {
        return $this->belongsTo(Responsable::class);
    }
    public function grades()
{
    return $this->hasMany(Grade::class);
}
}
