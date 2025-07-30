@extends('layout')

@section('titulo', 'Inicio')

@section('contenido')
<h2>Páginas disponibles</h2>
<ul class="list-group">
    @foreach($paginas as $pagina)
        <li class="list-group-item">
            <a href="{{ route('pagina.ver', $pagina->id_pagina) }}">{{ $pagina->titulo }}</a>
            <p>{{ $pagina->descripcion }}</p>
        </li>
    @endforeach
</ul>
@endsection
