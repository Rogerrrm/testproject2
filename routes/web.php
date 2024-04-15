<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\RecursoController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Home');
});

Route::get('/adminpanel', function () {
    return Inertia::render('AdminPanel');
});

Route::get('/cursos', function () {
    return Inertia::render('Cursos');
});

Route::get('/getusersession', [UserController::class, 'getUserSession']);
Route::get('/buscarusuarios', [UserController::class, 'getUsers']);
Route::post('/usuarios/{id}', [UserController::class, 'actualizar']);
Route::delete('/usuarios/{id}', [UserController::class, 'eliminar']);

Route::post('/guardarcurso', [CursoController::class, 'store']);
Route::get('/buscarcursos', [CursoController::class, 'buscar']);
Route::delete('/cursos/{id}', [CursoController::class, 'eliminarCurso']);
Route::put('/cursos/{id}', [CursoController::class, 'update']);

Route::post('/recursos', [RecursoController::class, 'guardar'])->name('recursos.guardar');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
