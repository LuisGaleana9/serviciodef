<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Panel Alumno</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto fs-5">
                    {{-- Usamos Auth::user()->name que es más estándar y seguro --}}
                    <span class="nav-link me-3">Bienvenido <strong class="text-light">{{ strtoupper(Auth::user()->name) }}</strong>!</span>
                    <a class="nav-link" href="{{ route('login.destroy') }}">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        {{-- Mantenemos la sección de alertas por si la necesitas en el futuro --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Mi Servicio Social</h4>
                {{-- Aquí puedes agregar más botones para otras opciones en el futuro --}}
                <div>
                    <span class="btn btn-primary active">Mi Horario</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($user->student && $user->student->schedules->count() > 0)
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Día</th>
                                    <th>Hora de Inicio</th>
                                    <th>Hora de Fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->student->schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->day_of_week }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Aún no tienes un horario asignado. Por favor, contacta a tu profesor.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>