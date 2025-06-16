<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // <-- Asegúrate de que esta línea esté presente

class SessionsController extends Controller
{
    public function login_post(Request $request)
    {
        // 1. Validar los datos del formulario
        $credentials = $request->validate([
            'matricula' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Buscar al usuario por su matrícula
        $password_data = DB::table('passwords')->where('matricula', $credentials['matricula'])->first();

        // 3. Verificar que el usuario y la contraseña sean correctos
        if (!$password_data || !Hash::check($credentials['password'], $password_data->password)) {
            return back()->withErrors([
                'matricula' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ])->onlyInput('matricula');
        }

        // 4. Si las credenciales son correctas, buscar el modelo de usuario
        $user = User::find($password_data->user_id);

        if (!$user) {
             return back()->withErrors([
                'matricula' => 'Ocurrió un error inesperado al intentar iniciar sesión.',
            ])->onlyInput('matricula');
        }
        
        // 5. Iniciar sesión oficialmente en Laravel
        Auth::login($user);

        // 6. Regenerar la sesión para seguridad
        $request->session()->regenerate();

        // 7. Redirigir según el rol del usuario
        if ($user->role == 'root') {
            return redirect()->intended(route('root.index'));
        }
        
        // CORRECCIÓN AQUÍ: Usar 'professor' y la ruta 'professor.index'
        if ($user->role == 'professor') {
            return redirect()->intended(route('professor.index'));
        }
        
        if ($user->role == 'student') {
            return redirect()->intended(route('alumno.panel'));
        }

        // Si no tiene un rol válido, lo deslogueamos y mandamos a login
        Auth::logout();
        return redirect('/login');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}