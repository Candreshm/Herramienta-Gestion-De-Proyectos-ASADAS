<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EvaluacionProyectoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ViabilidadController;
use App\Http\Controllers\AprobacionController;
use App\Http\Controllers\HitoController;
use App\Http\Controllers\AvanceProyectoController;
use App\Http\Controllers\IncidenciaController;
use Illuminate\Support\Facades\Route;

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

        Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])
            ->name('proyectos.show');

        // HU-14: Registro y consulta de acuerdos
        Route::get(
            '/proyectos/{proyecto}/aprobaciones',
            [AprobacionController::class, 'index']
            )->name('proyectos.aprobaciones.index');

        Route::get(
            '/proyectos/{proyecto}/aprobaciones/crear',
            [AprobacionController::class, 'create']
            )->name('proyectos.aprobaciones.create');

        Route::post(
            '/proyectos/{proyecto}/aprobaciones',
            [AprobacionController::class, 'store']
            )->name('proyectos.aprobaciones.store');

        
        // HU-17: Gestión de hitos
        Route::get('/proyectos/{proyecto}/hitos', [HitoController::class, 'index'])
            ->name('proyectos.hitos.index');

        Route::get('/proyectos/{proyecto}/hitos/crear', [HitoController::class, 'create'])
            ->name('proyectos.hitos.create');

        Route::post('/proyectos/{proyecto}/hitos', [HitoController::class, 'store'])
            ->name('proyectos.hitos.store');

        Route::get('/proyectos/{proyecto}/hitos/{hito}/editar', [HitoController::class, 'edit'])
            ->name('proyectos.hitos.edit');

        Route::put('/proyectos/{proyecto}/hitos/{hito}', [HitoController::class, 'update'])
            ->name('proyectos.hitos.update');


        // HU-17: Registro de avances
        Route::get('/proyectos/{proyecto}/avances', [AvanceProyectoController::class, 'index'])
            ->name('proyectos.avances.index');

        Route::get('/proyectos/{proyecto}/avances/crear', [AvanceProyectoController::class, 'create'])
            ->name('proyectos.avances.create');

        Route::post('/proyectos/{proyecto}/avances', [AvanceProyectoController::class, 'store'])
            ->name('proyectos.avances.store');

        Route::get('/proyectos/{proyecto}/avances/{avance}/editar', [AvanceProyectoController::class, 'edit'])
            ->name('proyectos.avances.edit');

        Route::put('/proyectos/{proyecto}/avances/{avance}', [AvanceProyectoController::class, 'update'])
            ->name('proyectos.avances.update');


        // HU-17: Gestión de incidencias
        Route::get('/proyectos/{proyecto}/incidencias', [IncidenciaController::class, 'index'])
            ->name('proyectos.incidencias.index');

        Route::get('/proyectos/{proyecto}/incidencias/crear', [IncidenciaController::class, 'create'])
            ->name('proyectos.incidencias.create');

        Route::post('/proyectos/{proyecto}/incidencias', [IncidenciaController::class, 'store'])
            ->name('proyectos.incidencias.store');

        Route::get('/proyectos/{proyecto}/incidencias/{incidencia}/editar', [IncidenciaController::class, 'edit'])
            ->name('proyectos.incidencias.edit');

        Route::put('/proyectos/{proyecto}/incidencias/{incidencia}', [IncidenciaController::class, 'update'])
            ->name('proyectos.incidencias.update');

});

Route::get('/', function () {
    return redirect()->route('login');
});
