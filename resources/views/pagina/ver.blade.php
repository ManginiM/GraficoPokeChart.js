<h1>{{ $pagina->titulo }}</h1>
<p>{{ $pagina->descripcion }}</p>

@if(Auth::check())
    <form method="POST" action="{{ route('posteo.store') }}">
        @csrf
        <textarea name="contenido" placeholder="Escribe tu posteo..." required></textarea>
        <input type="hidden" name="id_pagina" value="{{ $pagina->id }}">
        <button type="submit">Publicar Posteo</button>
    </form>
@endif

<hr>

@foreach($pagina->posteos as $posteo)
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <p><strong>Posteo:</strong> {{ $posteo->contenido }}</p>

        <h5>Comentarios:</h5>
        @foreach($posteo->comentarios as $comentario)
            <p>- {{ $comentario->contenido }}</p>
        @endforeach

        @if(Auth::check())
            <form method="POST" action="{{ route('comentario.store') }}">
                @csrf
                <textarea name="contenido" placeholder="Escribe un comentario..." required></textarea>
                <input type="hidden" name="id_posteo" value="{{ $posteo->id }}">
                <button type="submit">Comentar</button>
            </form>
        @endif
    </div>
@endforeach
