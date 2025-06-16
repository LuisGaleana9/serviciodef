<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Password;
use App\Models\Professor;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class ProfesorController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')
            ->with(['password', 'student'])
            ->get();
        return view('profesor.panel', compact('students'));
    }

    //Crear profesor
    public function createStudent()
    {
        return view('profesor.create_student');
    }
    
    //Almacenar profesor
    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'matricula' => 'required|unique:passwords',
            'password' => 'required|min:6',
            'estado_servicio' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            $student = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'student'
            ]);

            Password::create([
                'user_id' => $student->id,
                'matricula' => $request->matricula,
                'password' => Hash::make($request->password)
            ]);
            
            Student::create([
                'user_id' => $student->id,
                'estado_servicio' => $request->estado_servicio
            ]);
        });

        return redirect()->route('professor.index')
            ->with('success', 'Alumno creado exitosamente');
    }

    //Editar Estudiante
    public function editStudent($id)
    {
        $student = User::with(['password', 'student'])->findOrFail($id);
        return view('profesor.edit_students', compact('student'));
    }

    //Actualizar Estudiante
    public function updateStudent(Request $request, $id)
    {
    //Este es el modelo que consulta el correo, role ,etc
    $credencialesestudiante = User::findOrFail($id);

    //Este es el modelo donde se encuentra el estado del estudiante
    $infoestudiante = Student::findOrFail($id);
    
    //y aqui esta la matricula y password
    $contrasena = Password::findOrFail($id);

    

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        'matricula' => 'required|unique:passwords,matricula,'.$contrasena->matricula.',matricula',
        'estado_servicio' => 'required'
    ]);

    try {

            $credencialesestudiante->update([
                'name' => $request->name,
                'email' => $request->email
            ]);


            // Actualizar contraseña del profesor si se requiere
            if ($request->filled('password')) {
                $contrasena->update([
                    'matricula' => $request->matricula,
                    'password' => bcrypt($request->password)
                ]);
            } else {
    
                $contrasena->update([
                    'matricula' => $request->matricula
                ]);
            }
            
            // Actualizar area del profesor
            $infoestudiante->update([
                'estado_servicio' => $request->estado_servicio
            ]);
  

        return redirect()->route('professor.index')
            ->with('success', 'Estudiante actualizado exitosamente');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Error al actualizar el estudiante: ' . $e->getMessage()]);
        }   
    }

    //Eliminar Estudiante
    public function destroyStudent($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return redirect()->route('professor.index')
            ->with('success', 'Estudiante eliminado exitosamente');
    }

     /**
     * Agrega un nuevo horario para un estudiante.
     */
    public function addSchedule(Request $request, $student_user_id)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Buscamos al estudiante para asegurar que existe
        $student = Student::where('user_id', $student_user_id)->firstOrFail();
        
        // Creamos el horario usando la relación
        $student->schedules()->create($request->all());

        return back()->with('success', 'Horario agregado correctamente.');
    }

    /**
     * Elimina un horario.
     */
    public function removeSchedule(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Horario eliminado correctamente.');
    }

    // Asegúrate de que tu método 'edit' cargue los horarios
    public function edit($id)
    {
        $studentUser = User::findOrFail($id);
        // Carga la relación 'student' y anidada la de 'schedules'
        $studentUser->load('student.schedules');
        return view('profesor.edit_students', ['student' => $studentUser]);
    }
        
}
