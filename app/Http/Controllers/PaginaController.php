<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagina;  // Asegúrate que el modelo Pagina exista y esté en esta ruta

class PaginaController extends Controller
{
    public function mostrar($id)
    {
        // Buscar la página por ID
        $pagina = Pagina::find($id);

        // Si no existe la página, devolver error 404
        if (!$pagina) {
            abort(404);
        }

        // Obtener los posteos relacionados (asegúrate que la relación esté en el modelo Pagina)
        $posteos = $pagina->posteos;

        // Retornar la vista y pasarle la info
        return view('pagina', compact('pagina'));
    }
    public function show($id)
    {
        // ... lógica para obtener la publicación con el ID ...
        return view('nombre_de_la_vista', ['publicacion' => $publicacion]);
    }
}

