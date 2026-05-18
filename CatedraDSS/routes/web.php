<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\OrganizacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonacionController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\CategoriaController;


// ─── Rutas Públicas ───────────────────────────────────────────────────────────

Route::get('/', fn() => view('welcome'))->name('home');

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/registro/ong',  [AuthController::class, 'showRegistroOng'])->name('ong.registro');
Route::post('/registro/ong', [AuthController::class, 'registroOng'])->name('ong.registro.post');

Route::get('/registro/comercio',  [AuthController::class, 'showRegistroCom'])->name('comercio.registro');
Route::post('/registro/comercio', [AuthController::class, 'registroCom'])->name('comercio.registro.post');

// ─── Rutas Protegidas ─────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ── ONG ────────────────────────────────────────────────────────────────────
    Route::prefix('ong')->name('ong.')->middleware('role:organizacion')->group(function () {

        Route::get('/dashboard',      fn() => view('ong.dashboard'))->name('dashboard');
        Route::get('/historial',      fn() => view('ong.historial'))->name('historial');
        Route::get('/voluntarios',    fn() => view('ong.voluntarios'))->name('voluntarios');
        Route::get('/reservados',     fn() => view('ong.reservados'))->name('reservados');
        Route::get('/perfil',         fn() => view('ong.perfil'))->name('perfil');
        Route::get('/documentos',     fn() => view('ong.documentos'))->name('documentos');
        Route::get('/calificaciones', fn() => view('ong.calificaciones'))->name('calificaciones');
        Route::get('/reservas/{id}',  fn() => view('ong.reserva-detalle'))->name('reserva.detalle');
        Route::get('/entregas',       fn() => view('ong.entregas'))->name('entregas');

        Route::get('/donaciones',            [DonacionController::class, 'index'])->name('donaciones.index');
        Route::get('/donaciones/historial',  [DonacionController::class, 'historialOng'])->name('donaciones.historial');
        Route::get('/donaciones/reservados', [DonacionController::class, 'reservadosOng'])->name('donaciones.reservados');

        Route::get('/api/voluntarios',           [\App\Http\Controllers\VoluntarioController::class, 'index'])->name('api.voluntarios.index');
        Route::post('/api/voluntarios',          [\App\Http\Controllers\VoluntarioController::class, 'store'])->name('api.voluntarios.store');
        Route::delete('/api/voluntarios/{id}',   [\App\Http\Controllers\VoluntarioController::class, 'destroy'])->name('api.voluntarios.destroy');

        Route::get('/api/perfil', [OrganizacionController::class, 'perfil'])->name('api.perfil');
        Route::put('/api/perfil', [OrganizacionController::class, 'actualizar'])->name('api.perfil.update');

        Route::middleware('organizacion.verificada')->group(function () {
            // Documentos
            Route::get('/documentos',          [DocumentoController::class, 'index'])->name('documentos.index');
            Route::post('/documentos/subir',   [DocumentoController::class, 'store'])->name('documentos.store');
            Route::delete('/documentos/{id}',  [DocumentoController::class, 'destroy'])->name('documentos.destroy');

            // Reservas
            Route::get('/api/reservas',                   [ReservaController::class, 'index'])->name('api.reservas.index');
            Route::get('/api/reservas/{id}',              [ReservaController::class, 'show'])->name('api.reserva.show');
            Route::post('/reservas/crear/{donacion_id}',  [ReservaController::class, 'store'])->name('reservas.store');
            Route::post('/reservas/{id}/cancelar',        [ReservaController::class, 'cancelar'])->name('reservas.cancelar');

            // Entregas
            Route::get('/api/entregas',        [EntregaController::class, 'index'])->name('api.entregas.index');
            Route::post('/entregas/confirmar', [EntregaController::class, 'store'])->name('entregas.store');

            // Calificaciones
            Route::get('/api/calificaciones',      [CalificacionController::class, 'index'])->name('api.calificaciones.index');
            Route::post('/calificaciones/guardar', [CalificacionController::class, 'store'])->name('calificaciones.store');
        });
    });

    // ── COMERCIO ───────────────────────────────────────────────────────────────
    Route::prefix('comercio')->name('comercio.')->middleware('role:comercio')->group(function () {

        Route::get('/dashboard',        [ComercioController::class, 'dashboard'])->name('dashboard');
        Route::get('/donaciones',       [ComercioController::class, 'donaciones'])->name('donaciones');
        Route::post('/donaciones',      [ComercioController::class, 'storeDonacion'])->name('donaciones.store');
        Route::get('/estadisticas',     [ComercioController::class, 'estadisticas'])->name('estadisticas');
        Route::get('/impacto',          [ComercioController::class, 'impacto'])->name('impacto');
        Route::get('/organizaciones',   [ComercioController::class, 'organizaciones'])->name('organizaciones');

        Route::get('/api/perfil',  [ComercioController::class, 'perfil'])->name('api.perfil');
        Route::put('/api/perfil',  [ComercioController::class, 'actualizar'])->name('api.perfil.update');
    });

    // ── ADMIN ──────────────────────────────────────────────────────────────────
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        Route::get('/dashboard',                    [AdminController::class, 'dashboard'])->name('dashboard');

        // Organizaciones (vistas web)
        Route::get('/ongs',                         [AdminController::class, 'index'])->name('ongs.index');
        Route::get('/ongs/pendientes',              [AdminController::class, 'ongsPendientes'])->name('ongs.pendientes');
        Route::get('/ongs/{id}',                    [AdminController::class, 'show'])->name('ongs.show');
        Route::post('/ongs/{id}/verificar',         [AdminController::class, 'verificarOng'])->name('ongs.verificar');

        // Comercios (vistas web)
        Route::get('/comercios',                    [AdminController::class, 'comerciosIndex'])->name('comercios.index');

        // Publicaciones (vistas web)
        Route::get('/publicaciones',                [AdminController::class, 'publicacionesIndex'])->name('publicaciones.index');

        // Reportes
        Route::get('/reportes',         [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/periodo', [ReporteController::class, 'porPeriodo'])->name('reportes.periodo');
        Route::get('/reportes/exportar',[ReporteController::class, 'exportar'])->name('reportes.exportar');
    });
});
