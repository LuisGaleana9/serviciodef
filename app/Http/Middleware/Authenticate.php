<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('id') || !session()->has('role')) {
            return redirect('/login');
        }

        // Verificar acceso a rutas de root
        if ($request->is('root*') && session('role') !== 'root') {
            return redirect('/login');
        }

        // Verificar acceso a rutas de profesor
        if ($request->is('profesor*') && session('role') !== 'profesor') {
            return redirect('/login');
        }

        // Verificar acceso a rutas de alumno
        if ($request->is('alumno*') && session('role') !== 'alumno') {
            return redirect('/login');
        }

        return $next($request);
    }
}