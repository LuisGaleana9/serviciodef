<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Editar Profesor</h4>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <form action="{{ route('profesor.update.student', ['id' => $student->id]) }}" method="POST" class="register-form" id="register-form">                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $student->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $student->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="matricula" class="form-label">Matrícula</label>
                        <input type="text" class="form-control @error('matricula') is-invalid @enderror" 
                               id="matricula" name="matricula" 
                               value="{{ old('matricula', $student->password->matricula) }}" required>
                        @error('matricula')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña (dejar en blanco para mantener la actual)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="estado_servicio" class="form-label">Estado del servicio</label>
                        <select class="form-select @error('estado_servicio') is-invalid @enderror" 
                                id="estado_servicio" name="estado_servicio" required>
                            <option value="">Selecciona el estado</option>
                            <option value="Activo" {{ $student->student->estado_servicio == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="En pausa" {{ $student->student->estado_servicio == 'En pausa' ? 'selected' : '' }}>En pausa</option>
                            <option value="Terminado" {{ $student->student->estado_servicio == 'Terminado' ? 'selected' : '' }}>Terminado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('professor.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
                {{-- ... después de los campos del formulario de edición del estudiante ... --}}

                <hr>

                <h4>Horario de Servicio Social</h4>

                @if($student->student->schedules->count() > 0)
                    <p><strong>Horario Actual:</strong></p>
                    <table class="table table-striped">
                        <thead>
                            <tr><th>Día</th><th>Inicio</th><th>Fin</th><th>Acción</th></tr>
                        </thead>
                        <tbody>
                            @foreach($student->student->schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->day_of_week }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td>
                                    <td>
                                        <form action="{{ route('profesor.schedule.remove', $schedule->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>El estudiante aún no tiene un horario asignado.</p>
                @endif

                <h5>Agregar Nuevo Horario</h5>
                <form action="{{ route('profesor.schedule.add', $student->id) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="day_of_week">Día</label>
                            <select name="day_of_week" class="form-control" required>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sábado">Sábado</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="start_time">Hora Inicio</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="end_time">Hora Fin</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                        <div class="form-group col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>