<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4 px-4">
        <a class="navbar-brand text-white" href="/">Sistema de Posteos</a>
    </nav>

    <div class="container">
        @yield('contenido')
    </div>
</body>
</html>
