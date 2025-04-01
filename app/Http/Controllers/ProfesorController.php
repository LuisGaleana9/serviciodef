<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Password;
use App\Models\Professor;
use App\Models\Student;
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
}
