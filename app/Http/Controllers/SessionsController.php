<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function login_post(Request $request)
    {
        //declaramos variables capturando los datos del formulario
        $matricula = request('matricula');
        $password = request('password');
        
        //consulta a la base de datos de password verificando que la matricula sea igual a la capturada
        $consulta = DB::table('passwords')
        ->where('matricula', '=', $matricula)
        ->get();
        
        //Verificar si la consulta retornó resultados
        if($consulta->isEmpty()){ 
            return redirect()->back()
            ->withInput()
            ->withErrors(['matricula' => 'La matrícula ('.$matricula.') no existe en el sistema']);
        }

 
            if(isset($consulta)){ 
                if (Hash::check($password, $consulta[0]->password)) {
                    //si es correcta la contraseña, consultamos el rol del usuario
                    $consultarol = DB::table('users')
                    ->where('id', '=', $consulta[0]->user_id)
                    ->get();
                    
                    session([
                        'id' => $consulta[0]->user_id,
                        'matricula' => $consulta[0]->matricula,
                        'role' => $consultarol[0]->role,
                        'name' => $consultarol[0]->name,
                        'email' => $consultarol[0]->email,
                        'expired_at' => now()->addMinutes(30),
                    ]);
                    //verificamos el rol del usuario
                    if ($consultarol[0]->role == 'root') {
                        return redirect('/root');
                    } elseif ($consultarol[0]->role == 'professor') {
                        return redirect('/profesor');
                    } elseif ($consultarol[0]->role == 'alumno') {
                        return redirect('/alumno');
                    }else{
                        return redirect('/login');
                    }
                }else{
                    //si la contraseña es incorrecta, se redirige a login
                    return redirect()->back()
                    ->withInput()
                    ->withErrors(['matricula' => 'Contraseña erronea!']);
                }
        }
        return redirect('/login');
        
    }


    public function destroy()
    {
        //destruimos la sesion
        session()->flush();
        //se redirige a login
        return redirect('/login');
    }
}
