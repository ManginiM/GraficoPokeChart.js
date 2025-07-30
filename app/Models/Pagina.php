<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    use HasFactory;

    // Indicar el nombre de la tabla (opcional si Laravel ya lo detecta como plural)
    protected $table = 'paginas';
    
    
    // Indicar el nombre de la clave primaria personalizada
    protected $primaryKey = 'id_pagina';

    // Si no estás usando timestamps (created_at, updated_at)
    public $timestamps = false;
    protected $fillable = ['titulo', 'descripcion', 'creador'];

    // Relación con Posteo
    public function posteos()
    {
        return $this->hasMany(Posteo::class, 'id_pagina');
    }
    
}
