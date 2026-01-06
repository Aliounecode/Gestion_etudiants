<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;
    protected $fillable = ['filename', 'file_path', 'user_id', 'status', 'metadata'];
    
    // Pour lier à l'utilisateur qui a scanné
    public function user() {
        return $this->belongsTo(User::class);
    }
}
