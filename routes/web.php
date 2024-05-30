<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RecursoController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\RaitingController;

Route::get('/home', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

// Route::get('/home', function () {
//     return Inertia::render('Home');
// });

Route::get('/adminpanel', function () {
    return Inertia::render('AdminPanel');
});

Route::get('/restaurante', function () {
    return Inertia::render('restaurante');
})->name('restaurante');

Route::get('/buscarrestaurantes', function () {
    return Inertia::render('BuscarRestaurantes');
})->name('buscarrestaurantes');


Route::get('/getusersession', [UserController::class, 'getUserSession']);
Route::get('/buscarusuarios', [UserController::class, 'getUsers']);
Route::post('/usuarios/{id}', [UserController::class, 'actualizar']);
Route::delete('/usuarios/{id}', [UserController::class, 'eliminar']);

Route::get('/restaurantes', [RestaurantController::class, 'index']);
Route::post('/crearrestaurante', [RestaurantController::class, 'store']);
Route::get('/inforestaurante/{id}', [RestaurantController::class, 'edit'])->name('inforestaurante');
Route::delete('/deleterestaurante/{id}', [RestaurantController::class, 'delete'])->name('restaurante.delete');
Route::put('/updaterestaurants/{id}', [RestaurantController::class, 'update'])->name('restaurante.delete');
Route::get('/restaurant', [RestaurantController::class, 'index2']);
Route::post('/api/restaurants', [RestaurantController::class, 'store']);


Route::get('/comentarios', [RaitingController::class, 'index']);
Route::post('/ratings', [RaitingController::class, 'store'])->name('ratings.store');
Route::put('/editcomentarios/{id}', [RaitingController::class, 'update'])->name('ratings.update');
Route::delete('/deletecomentarios/{id}', [RaitingController::class, 'delete'])->name('ratings.delete');
Route::get('/comentarios_restaurante/{restaurante_id}', [RaitingController::class, 'obtenerComentariosRestaurante'])->name('obtenerComentariosRestaurante');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
})->name('login-google');

Route::get('/google-callback', function () {
    $user = Socialite::driver('google')->user();

    $userExsist = User::where('external_id', $user->id)->where('external_auth', 'google')->first();

    if ($userExsist) {
        Auth::login($userExsist);
    } else {
        $userNew = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'google',
        ]);

        Auth::login($userNew);
    }

    return redirect('/home');

    // $user->token
});

require __DIR__ . '/auth.php';
