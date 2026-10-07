<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;

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

        Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])
            ->name('proyectos.show');
    });
});

Route::get('/', function () {
    return redirect(config('app.url') . '/login');
});
