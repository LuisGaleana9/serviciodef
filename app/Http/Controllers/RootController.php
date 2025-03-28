<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Password;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RootController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!session()->has('id') || session('role') !== 'root') {
                return redirect('/login');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $professors = User::where('role', 'professor')
            ->with(['password', 'professor'])
            ->get();
        return view('root.panel', compact('professors'));
    }

    //Crear profesor
    public function createProfessor()
    {
        return view('root.create_professor');
    }

    //Almacenar profesor
    public function storeProfessor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'matricula' => 'required|unique:passwords',
            'password' => 'required|min:6',
            'area' => 'required'
        ]);

        DB::transaction(function () use ($request) {
            $professor = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'professor'
            ]);

            Password::create([
                'user_id' => $professor->id,
                'matricula' => $request->matricula,
                'password' => Hash::make($request->password)
            ]);

            Professor::create([
                'user_id' => $professor->id,
                'area' => $request->area
            ]);
        });

        return redirect()->route('root.index')
            ->with('success', 'Profesor creado exitosamente');
    }

    //Editar profesor
    public function editProfessor($id)
    {
        $professor = User::with(['password', 'professor'])->findOrFail($id);
        return view('root.edit_professor', compact('professor'));
    }

    //Actualizar profesor
    public function updateProfessor(Request $request, $id)
    {
    //Este es el modelo que consulta el correo, role ,etc
    $credencialesprofesor = User::findOrFail($id);

    //Este es el modelo donde se encuentra el area de prof
    $infoprofesor = Professor::findOrFail($id);
    
    //y aqui esta la matricula y password
    $contrasena = Password::findOrFail($id);

    

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        'matricula' => 'required|unique:passwords,matricula,'.$contrasena->matricula.',matricula',
        'area' => 'required'
    ]);

    try {

            $credencialesprofesor->update([
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
            $infoprofesor->update([
                'area' => $request->area
            ]);
  

        return redirect()->route('root.index')
            ->with('success', 'Profesor actualizado exitosamente');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'Error al actualizar el profesor: ' . $e->getMessage()]);
        }   
    }

    //Eliminar profesor
    public function destroyProfessor($id)
    {
        $professor = User::findOrFail($id);
        $professor->delete();

        return redirect()->route('root.index')
            ->with('success', 'Profesor eliminado exitosamente');
    }
}