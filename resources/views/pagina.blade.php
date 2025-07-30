@extends('layout')

@section('titulo', $pagina->titulo)

@section('contenido')
<h2>{{ $pagina->titulo }}</h2>
<p>{{ $pagina->descripcion }}</p>

<h4>Posteos</h4>
<ul class="list-group">
    @foreach($pagina->posteos as $post)
        <li class="list-group-item">
            <a href="{{ route('posteo.ver', $post->id_posteo) }}">{{ Str::limit($post->contenido, 100) }}</a>
            <small class="d-block text-muted">Publicado: {{ $post->fecha_publicacion }}</small>
        </li>
    @endforeach
</ul>
@endsection
@extends('layout')

@section('titulo', $pagina->titulo)

@section('contenido')
    <h2>{{ $pagina->titulo }}</h2>
    <p>{{ $pagina->descripcion }}</p>

    <h4>Posteos</h4>
    <ul class="list-group">
        @foreach($pagina->posteos as $post)
            <li class="list-group-item">
                {{ $post->contenido }}
            </li>
        @endforeach
    </ul>
@endsection
