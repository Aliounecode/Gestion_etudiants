<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'module_id',
        'score_exam',
        'score_cc',
        'average',
        'status',
    ];

    // Un grade appartient à un étudiant
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Un grade appartient à un module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
