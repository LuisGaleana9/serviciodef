<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Password;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
    public function panel()
    {
        return view('alumno.panel');
    }

}