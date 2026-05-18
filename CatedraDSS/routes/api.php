<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReporteController;

// Organizaciones
Route::middleware('auth')->prefix('organizaciones')->group(function () {
    Route::get('/', [OrganizacionController::class, 'index']);
    Route::get('/perfil', [OrganizacionController::class, 'perfil']);
    Route::get('/{id}', [OrganizacionController::class, 'show']);
    Route::put('/perfil', [OrganizacionController::class, 'actualizar']);
});

// Documentos
Route::middleware(['auth', 'organizacion.verificada'])->prefix('documentos')->group(function () {
    Route::get('/', [DocumentoController::class, 'index']);
    Route::post('/subir', [DocumentoController::class, 'store']);
    Route::delete('/{id}', [DocumentoController::class, 'destroy']);
});

// Reservas
Route::middleware(['auth', 'organizacion.verificada'])->prefix('reservas')->group(function () {
    Route::get('/', [ReservaController::class, 'index']);
    Route::get('/{id}', [ReservaController::class, 'show']);
    Route::post('/crear/{donacion_id}', [ReservaController::class, 'store']);
    Route::post('/{id}/cancelar', [ReservaController::class, 'cancelar']);
});

// Entregas
Route::middleware(['auth', 'organizacion.verificada'])->prefix('entregas')->group(function () {
    Route::get('/', [EntregaController::class, 'index']);
    Route::post('/confirmar', [EntregaController::class, 'store']);
});

// Calificaciones
Route::middleware(['auth', 'organizacion.verificada'])->prefix('calificaciones')->group(function () {
    Route::get('/', [CalificacionController::class, 'index']);
    Route::post('/guardar', [CalificacionController::class, 'store']);
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/ongs', [AdminController::class, 'index']);
    Route::get('/ongs/pendientes', [AdminController::class, 'ongsPendientes']);
    Route::get('/ongs/{id}', [AdminController::class, 'show']);
    Route::post('/ongs/{id}/verificar', [AdminController::class, 'verificarOng']);
    Route::get('/reportes', [ReporteController::class, 'index']);
    Route::get('/reportes/periodo', [ReporteController::class, 'porPeriodo']);
    Route::get('/reportes/exportar', [ReporteController::class, 'exportar']);
});