@extends('layout')

@section('titulo', 'Perfil de Usuario')

@section('contenido')
<h2>{{ $usuario->nombre }} {{ $usuario->apellido }}</h2>
<p><strong>Email:</strong> {{ $usuario->email }}</p>
<p><strong>Rol:</strong> {{ $usuario->rol }}</p>

<h4>Estadísticas</h4>
<ul>
    <li>Total accesos: {{ $usuario->estadistica->total_accesos ?? 0 }}</li>
    <li>Total posteos: {{ $usuario->estadistica->total_posteos ?? 0 }}</li>
    <li>Total comentarios: {{ $usuario->estadistica->total_comentarios ?? 0 }}</li>
</ul>
@endsection
