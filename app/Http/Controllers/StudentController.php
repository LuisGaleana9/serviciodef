<?php

// app/Http/Controllers/StudentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth

class StudentController extends Controller
{
    public function panel()
    {
        // 1. Obtener el usuario autenticado
        $user = Auth::user();

        // 2. Cargar explícitamente la relación 'student' y, dentro de ella, 'schedules'
        // El método load() modifica el objeto $user actual.
        $user->load('student.schedules');

        // 3. Pasar el usuario con las relaciones ya cargadas a la vista
        return view('alumno.panel', ['user' => $user]);
    }
}