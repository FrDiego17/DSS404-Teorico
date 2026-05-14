<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonacionController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\CategoriaController;

// Rutas Publicas

Route::get('/', fn() => view('welcome'))->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/registro/ong', [AuthController::class, 'showRegistroOng'])->name('ong.registro');
Route::post('/registro/ong', [AuthController::class, 'registroOng'])->name('ong.registro.post');

// Rutas Protegidas

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('ong')->name('ong.')->middleware('role:organizacion')->group(function () {
        Route::get('/dashboard',    fn() => view('ong.dashboard'))->name('dashboard');
        Route::get('/historial',    fn() => view('ong.historial'))->name('historial');
        Route::get('/voluntarios',  fn() => view('ong.voluntarios'))->name('voluntarios');
        Route::get('/reservados',   fn() => view('ong.reservados'))->name('reservados');

        Route::get('/donaciones',           [DonacionController::class, 'index'])->name('donaciones.index');
        Route::get('/donaciones/historial', [DonacionController::class, 'historialOng'])->name('donaciones.historial');
        Route::get('/donaciones/reservados',[DonacionController::class, 'reservadosOng'])->name('donaciones.reservados');

        Route::get('/api/voluntarios',      [\App\Http\Controllers\VoluntarioController::class, 'index'])->name('api.voluntarios.index');
        Route::post('/api/voluntarios',     [\App\Http\Controllers\VoluntarioController::class, 'store'])->name('api.voluntarios.store');
        Route::delete('/api/voluntarios/{id}', [\App\Http\Controllers\VoluntarioController::class, 'destroy'])->name('api.voluntarios.destroy');
    });

    Route::prefix('comercio')->name('comercio.')->middleware('role:comercio')->group(function () {
        Route::get('/dashboard', fn() => view('comercio.dashboard'))->name('dashboard');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    });
});
