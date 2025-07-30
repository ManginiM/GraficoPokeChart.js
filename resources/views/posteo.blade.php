@extends('layout')

@section('titulo', 'Posteo')

@section('contenido')
<h2>Posteo</h2>
<p>{{ $posteo->contenido }}</p>
<p><strong>Publicado:</strong> {{ $posteo->fecha_publicacion }}</p>

<h4>Comentarios</h4>
<ul class="list-group">
    @foreach($posteo->comentarios as $comentario)
        <li class="list-group-item">
            {{ $comentario->contenido }}
            <small class="d-block text-muted">{{ $comentario->fecha_creacion }}</small>
        </li>
    @endforeach
</ul>
@endsection
