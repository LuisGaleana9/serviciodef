<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Root</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Panel Root</a>
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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Gestión de Profesores</h4>
                <a href="{{ route('root.create.professor') }}" class="btn btn-primary">Nuevo Profesor</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Matrícula</th>
                            <th>Área</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($professors as $professor)
                        <tr>
                            <td>{{ $professor->name }}</td>
                            <td>{{ $professor->email }}</td>
                            <td>{{ $professor->password->matricula }}</td>
                            <td>{{ $professor->professor->area }}</td>
                            <td>
                                <a href="{{ route('root.edit.professor', $professor->id) }}" 
                                   class="btn btn-sm btn-info">Editar</a>
                                <form action="{{ route('root.destroy.professor', $professor->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Está seguro de eliminar este profesor?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>