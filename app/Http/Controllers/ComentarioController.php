<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        // Validamos los datos del formulario
        $request->validate([
            'contenido' => 'required|string',
            'id_posteo' => 'required|exists:posteos,id',
        ]);

        // Creamos el comentario
        $comentario = new Comentario();
        $comentario->contenido = $request->input('contenido');
        $comentario->fecha_creacion = now();
        $comentario->ultima_actualizacion = now();
        $comentario->id_usuario = auth()->id();
        $comentario->id_posteo = $request->input('id_posteo');
        $comentario->save();

        return redirect()->back()->with('success', 'Comentario creado correctamente.');
    }
}
