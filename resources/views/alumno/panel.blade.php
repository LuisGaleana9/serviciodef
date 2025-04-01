<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiante</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Panel de Estudiante</a>
            <div class="navbar-nav ms-auto fs-4">
                <span class="nav-link me-3">Bienvenido <strong class="text-light">{{ strtoupper(session('name')) }}</strong>!</span>
                <a class="nav-link" href="{{ route('login.destroy') }}">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
</body>
</html>