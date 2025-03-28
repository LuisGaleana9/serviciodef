<?php

use App\Http\Controllers\RootController;
use App\Http\Controllers\SessionsController;
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
Route::get('/root', function () {
    return view('root.panel');
});

// CRUD ROOT
// Route::middleware(['auth'])->group(function () {
    Route::get('/root', [RootController::class, 'index'])->name('root.index');
    Route::get('/root/professor/create', [RootController::class, 'createProfessor'])->name('root.create.professor');
    Route::post('/root/professor', [RootController::class, 'storeProfessor'])->name('root.store.professor');
    Route::get('/root/professor/{id}/edit', [RootController::class, 'editProfessor'])->name('root.edit.professor');
    Route::put('/root/professor/{id}', [RootController::class, 'updateProfessor'])->name('root.update.professor');
    Route::delete('/root/professor/{id}', [RootController::class, 'destroyProfessor'])->name('root.destroy.professor');
/// }); lol

//Profesor
Route::get('/profesor', function () {
    return view('profesor.panel');
});

//Alumno
Route::get('/alumno', function () {
    return view('alumno.panel');
});
