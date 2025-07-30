<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posteo;

class PosteoController extends Controller
{
    public function store(Request $request)
    {
        // Validamos los datos recibidos del formulario
        $request->validate([
            'contenido' => 'required|string',
            'id_pagina' => 'required|exists:paginas,id',
        ]);

        // Creamos el nuevo posteo
        $posteo = new Posteo();
        $posteo->contenido = $request->input('contenido');
        $posteo->fecha_publicacion = now();
        $posteo->ultima_actualizacion = now();
        $posteo->id_usuario = auth()->id(); // El usuario que está logueado
        $posteo->id_pagina = $request->input('id_pagina');
        $posteo->save();

        return redirect()->back()->with('success', 'Posteo creado correctamente.');
    }
}
