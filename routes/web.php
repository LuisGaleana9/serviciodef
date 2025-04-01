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
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [SessionsController::class, 'login_post'])
    ->name('login');

Route::get('/logout', [SessionsController::class, 'destroy'])
    ->name('login.destroy');

//ROOT

// CRUD ROOT
// Route::middleware(['auth'])->group(function () {
    Route::get('/root', [RootController::class, 'index'])->name('root.index');
    Route::get('/root/professor/create', [RootController::class, 'createProfessor'])->name('root.create.professor');
    Route::post('/root/professor', [RootController::class, 'storeProfessor'])->name('root.store.professor');
    Route::get('/root/professor/{id}/edit', [RootController::class, 'editProfessor'])->name('root.edit.professor');
    Route::put('/root/professor/{id}', [RootController::class, 'updateProfessor'])->name('root.update.professor');
    Route::delete('/root/professor/{id}', [RootController::class, 'destroyProfessor'])->name('root.destroy.professor');
// });

//Profesor
Route::get('/profesor', [ProfesorController::class, 'index'])->name('professor.index');
Route::get('/profesor/student/create', [ProfesorController::class, 'createStudent'])->name('professor.create.student');
Route::post('/profesor/student', [ProfesorController::class, 'storeStudent'])->name('professor.store.student');
Route::get('/profesor/student/{id}/edit', [ProfesorController::class, 'editStudent'])->name('professor.edit.student');
Route::put('/profesor/student/{id}', [ProfesorController::class, 'updateStudent'])->name('professor.update.student');
Route::delete('/profesor/student/{id}', [ProfesorController::class, 'destroyStudent'])->name('professor.destroy.student');

//Alumno
Route::get('/student', [StudentController::class, 'index']);
