<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posteo extends Model
{
    use HasFactory;
    public function comentarios() {
        return $this->hasMany(Comentario::class, 'id_posteo');
    }
    
}
