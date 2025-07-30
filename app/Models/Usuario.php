<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_usuario';

    protected $fillable = ['nombre', 'apellido', 'email', 'contraseña', 'rol'];
    

    protected $hidden = ['contraseña'];
    
    public function estadistica() {
        return $this->hasOne(Estadistica::class, 'id_usuario');
    }    
    public function crearPosteo($datos) {
        return $this->posteos()->create($datos);
    }
    public $timestamps = false;

    
    public function comentarPosteo($datos) {
        return $this->comentarios()->create($datos);
    }
    
    public function accesos() {
        return $this->hasMany(Acceso::class, 'id_usuario');
    }
    
    public function posteos() {
        return $this->hasMany(Posteo::class, 'id_usuario');
    }
    
    public function comentarios() {
        return $this->hasMany(Comentario::class, 'id_usuario');
    }
    
}

