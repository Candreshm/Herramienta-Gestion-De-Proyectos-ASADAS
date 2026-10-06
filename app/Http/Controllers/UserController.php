<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::with('role')->orderBy('name')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::where('activo', true)->orderBy('nombre')->get();

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['activo'] = $request->boolean('activo', true);

        User::create($data);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario registrado exitosamente.');
    }

    public function edit(User $usuario): View
    {
        $roles = Role::where('activo', true)->orderBy('nombre')->get();

        return view('users.edit', [
            'user' => $usuario,
            'roles' => $roles,
        ]);
    }

    public function update(UpdateUserRequest $request, User $usuario): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['activo'] = $request->boolean('activo', $usuario->activo);

        $usuario->update($data);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function activar(User $usuario): RedirectResponse
    {
        $usuario->update(['activo' => true]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', "El usuario {$usuario->name} fue activado.");
    }

    public function desactivar(User $usuario): RedirectResponse
    {
        if ($usuario->id === auth()->id()) {
            return redirect()
                ->route('usuarios.index')
                ->with('error', 'No puede desactivar su propia cuenta.');
        }

        $usuario->update(['activo' => false]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', "El usuario {$usuario->name} fue desactivado.");
    }
}

