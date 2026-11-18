<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EvaluacionProyectoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ViabilidadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModeloViabilidadController;
use App\Http\Controllers\ValidacionPresupuestariaController;
use App\Http\Controllers\AprobacionProyectoController;
use App\Http\Controllers\TareaProyectoController;
use App\Http\Controllers\SeguimientoProyectoController;
use App\Http\Controllers\DocumentoProyectoController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'show'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.authenticate');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    // HU-02 y HU-03: Gestión de usuarios (solo Administrador)
    Route::middleware('admin')->group(function () {
// HU-13: Validación presupuestaria
Route::get(
    '/proyectos/{proyecto}/presupuesto',
    [ValidacionPresupuestariaController::class, 'edit']
)->name('presupuesto.validacion.edit');

Route::put(
    '/proyectos/{proyecto}/presupuesto',
    [ValidacionPresupuestariaController::class, 'update']
)->name('presupuesto.validacion.update');

// HU-12, HU-14 y HU-15
Route::get(
    '/proyectos/{proyecto}/aprobacion',
    [AprobacionProyectoController::class, 'edit']
)->name('proyectos.aprobacion.edit');

Route::put(
    '/proyectos/{proyecto}/aprobacion',
    [AprobacionProyectoController::class, 'update']
)->name('proyectos.aprobacion.update');
    // HU-11: Configuración del modelo de viabilidad
Route::get(
    '/configuracion/modelo-viabilidad',
    [ModeloViabilidadController::class, 'edit']
)->name('modelo-viabilidad.edit');

Route::put(
    '/configuracion/modelo-viabilidad',
    [ModeloViabilidadController::class, 'update']
)->name('modelo-viabilidad.update');

        Route::get('/usuarios', [UserController::class, 'index'])
            ->name('usuarios.index');

        Route::get('/usuarios/crear', [UserController::class, 'create'])
            ->name('usuarios.create');

        Route::post('/usuarios', [UserController::class, 'store'])
            ->name('usuarios.store');

        Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])
            ->name('usuarios.edit');

        Route::put('/usuarios/{usuario}', [UserController::class, 'update'])
            ->name('usuarios.update');

        Route::patch('/usuarios/{usuario}/activar', [UserController::class, 'activar'])
            ->name('usuarios.activar');

        Route::patch('/usuarios/{usuario}/desactivar', [UserController::class, 'desactivar'])
            ->name('usuarios.desactivar');

        // HU-04: Registro y visualización de iniciativas
        Route::get('/proyectos', [ProyectoController::class, 'index'])
            ->name('proyectos.index');

        Route::get('/proyectos/crear', [ProyectoController::class, 'create'])
            ->name('proyectos.create');

        Route::post('/proyectos', [ProyectoController::class, 'store'])
            ->name('proyectos.store');
// HU-16: Gestión de tareas Kanban
Route::get(
    '/proyectos/{proyecto}/tareas',
    [TareaProyectoController::class, 'index']
)->name('proyectos.tareas.index');

Route::post(
    '/proyectos/{proyecto}/tareas',
    [TareaProyectoController::class, 'store']
)->name('proyectos.tareas.store');

Route::patch(
    '/proyectos/{proyecto}/tareas/{tarea}/estado',
    [TareaProyectoController::class, 'cambiarEstado']
)->name('proyectos.tareas.estado');

Route::delete(
    '/proyectos/{proyecto}/tareas/{tarea}',
    [TareaProyectoController::class, 'destroy']
)->name('proyectos.tareas.destroy');

// HU-17: Seguimiento de ejecución
Route::get(
    '/proyectos/{proyecto}/seguimiento',
    [SeguimientoProyectoController::class, 'index']
)->name('proyectos.seguimiento.index');

Route::post(
    '/proyectos/{proyecto}/seguimiento/hitos',
    [SeguimientoProyectoController::class, 'storeHito']
)->name('proyectos.seguimiento.hitos.store');

Route::patch(
    '/proyectos/{proyecto}/seguimiento/hitos/{hito}',
    [SeguimientoProyectoController::class, 'updateHito']
)->name('proyectos.seguimiento.hitos.update');

Route::post(
    '/proyectos/{proyecto}/seguimiento/avances',
    [SeguimientoProyectoController::class, 'storeAvance']
)->name('proyectos.seguimiento.avances.store');

Route::post(
    '/proyectos/{proyecto}/seguimiento/incidencias',
    [SeguimientoProyectoController::class, 'storeIncidencia']
)->name('proyectos.seguimiento.incidencias.store');

Route::patch(
    '/proyectos/{proyecto}/seguimiento/incidencias/{incidencia}',
    [SeguimientoProyectoController::class, 'updateIncidencia']
)->name('proyectos.seguimiento.incidencias.update');


// HU-18: Expediente documental
Route::get(
    '/proyectos/{proyecto}/documentos',
    [DocumentoProyectoController::class, 'index']
)->name('proyectos.documentos.index');

Route::post(
    '/proyectos/{proyecto}/documentos',
    [DocumentoProyectoController::class, 'store']
)->name('proyectos.documentos.store');

Route::get(
    '/proyectos/{proyecto}/documentos/{documento}/download',
    [DocumentoProyectoController::class, 'download']
)->name('proyectos.documentos.download');

Route::delete(
    '/proyectos/{proyecto}/documentos/{documento}',
    [DocumentoProyectoController::class, 'destroy']
)->name('proyectos.documentos.destroy');
        // HU-05: Información complementaria de la iniciativa
        Route::get('/proyectos/{proyecto}/hu05', [ProyectoController::class, 'editHu05'])
            ->name('proyectos.hu05.edit');

        Route::put('/proyectos/{proyecto}/hu05', [ProyectoController::class, 'updateHu05'])
            ->name('proyectos.hu05.update');

        // HU-07: Edición de proyectos
        Route::get(
            '/proyectos/{proyecto}/editar',
            [ProyectoController::class, 'edit']
        )->name('proyectos.edit');

        Route::put(
            '/proyectos/{proyecto}',
            [ProyectoController::class, 'update']
        )->name('proyectos.update');

        // HU-08: Evaluación de proyectos
        Route::get(
            '/proyectos/{proyecto}/evaluaciones',
            [EvaluacionProyectoController::class, 'index']
        )->name('proyectos.evaluacion.index');

        Route::get(
            '/proyectos/{proyecto}/evaluacion/crear',
            [EvaluacionProyectoController::class, 'create']
        )->name('proyectos.evaluacion.create');

        Route::post(
            '/proyectos/{proyecto}/evaluacion',
            [EvaluacionProyectoController::class, 'store']
        )->name('proyectos.evaluacion.store');

        Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])
            ->name('proyectos.show');

        // HU-09 y HU-10: Viabilidad y ranking
        Route::get(
            '/ranking',
            [ViabilidadController::class, 'ranking']
        )->name('viabilidad.ranking');

        Route::post(
            '/viabilidad/calcular/{id}',
            [ViabilidadController::class, 'calcular']
        )->name('viabilidad.calcular');
    });
});

Route::get('/', function () {
    return redirect()->route('login');
});
