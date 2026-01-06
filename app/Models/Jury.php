<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jury extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'promotion',
        'semester',
        'session',
        'meeting_at',
        'status',
    ];
    protected $casts = [
        'meeting_at' => 'datetime',
    ];


    // Many-to-many : un jury concerne plusieurs étudiants
    public function students()
    {
        return $this->belongsToMany(Student::class)
            ->withTimestamps();
            // ->withPivot('decision', 'comment') si tu ajoutes ces colonnes
    }
}
