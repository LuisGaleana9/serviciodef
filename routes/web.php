<?php

use App\Http\Controllers\RootController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rutas Públicas ---
// Cualquiera puede acceder a estas, no requieren inicio de sesión.
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [SessionsController::class, 'login_post']);

Route::get('/logout', [SessionsController::class, 'destroy'])
    ->name('login.destroy');


// --- Rutas Protegidas ---
// Todas las rutas aquí dentro requieren que el usuario haya iniciado sesión.
Route::middleware(['auth'])->group(function () {

    // == ROOT ==
    Route::get('/root', [RootController::class, 'index'])->name('root.index');
    Route::get('/root/professor/create', [RootController::class, 'createProfessor'])->name('root.create.professor');
    Route::post('/root/professor', [RootController::class, 'storeProfessor'])->name('root.store.professor');
    Route::get('/root/professor/{id}/edit', [RootController::class, 'editProfessor'])->name('root.edit.professor');
    Route::put('/root/professor/{id}', [RootController::class, 'updateProfessor'])->name('root.update.professor');
    Route::delete('/root/professor/{id}', [RootController::class, 'destroyProfessor'])->name('root.destroy.professor');

    // == PROFESOR ==
    Route::get('/profesor', [ProfesorController::class, 'index'])->name('professor.index');
    Route::get('/profesor/student/create', [ProfesorController::class, 'createStudent'])->name('profesor.create.student');
    Route::post('/profesor/student', [ProfesorController::class, 'storeStudent'])->name('profesor.store.student');
    Route::get('/profesor/student/{id}/edit', [ProfesorController::class, 'editStudent'])->name('profesor.edit.student');
    Route::put('/profesor/student/{id}', [ProfesorController::class, 'updateStudent'])->name('profesor.update.student');
    Route::delete('/profesor/student/{id}', [ProfesorController::class, 'destroyStudent'])->name('profesor.destroy.student');
    // Rutas para el horario
    Route::post('/profesor/students/{student_user_id}/schedule', [ProfesorController::class, 'addSchedule'])->name('profesor.schedule.add');
    Route::delete('/profesor/schedule/{schedule}', [ProfesorController::class, 'removeSchedule'])->name('profesor.schedule.remove');

    // == ALUMNO ==
    Route::get('/alumno/panel', [StudentController::class, 'panel'])->name('alumno.panel');

});