<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use App\Http\Requests\UpdateTareaEstadoRequest;
use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TareaController extends Controller
{
    public function index(Proyecto $proyecto): View
    {
        if (auth()->user()->id !== $proyecto->creado_por_id) {
            abort(403, 'No tienes permiso para ver las tareas de este proyecto.');
        }

        $proyecto->load(['tareas' => function ($query) {
            $query->orderBy('estado')->orderBy('fecha_vencimiento');
        }, 'tareas.responsable']);

        $usuarios = User::where('activo', true)->get();
        $estados = ['Pendiente', 'En progreso', 'Completado'];

        return view('tareas.index', compact('proyecto', 'usuarios', 'estados'));
    }

    public function create(Proyecto $proyecto): View
    {
        if (auth()->user()->id !== $proyecto->creado_por_id) {
            abort(403, 'No tienes permiso para crear tareas en este proyecto.');
        }

        $usuarios = User::where('activo', true)->get();

        return view('tareas.create', compact('proyecto', 'usuarios'));
    }

    public function store(StoreTareaRequest $request, Proyecto $proyecto): RedirectResponse
    {
        Tarea::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'estado' => 'Pendiente',
            'proyecto_id' => $proyecto->id,
            'responsable_id' => $request->responsable_id,
            'creado_por_id' => auth()->id(),
        ]);

        return redirect()
            ->route('tareas.index', $proyecto)
            ->with('success', 'La tarea se registró correctamente.');
    }

    public function edit(Proyecto $proyecto, Tarea $tarea): View
    {
        if (auth()->user()->id !== $proyecto->creado_por_id || $tarea->proyecto_id !== $proyecto->id) {
            abort(403, 'No tienes permiso para editar esta tarea.');
        }

        $usuarios = User::where('activo', true)->get();
        $estados = ['Pendiente', 'En progreso', 'Completado'];

        return view('tareas.edit', compact('proyecto', 'tarea', 'usuarios', 'estados'));
    }

    public function update(UpdateTareaRequest $request, Proyecto $proyecto, Tarea $tarea): RedirectResponse
    {
        if ($tarea->proyecto_id !== $proyecto->id) {
            abort(403, 'Esta tarea no pertenece al proyecto.');
        }

        $tarea->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'responsable_id' => $request->responsable_id,
            'estado' => $request->estado,
        ]);

        return redirect()
            ->route('tareas.index', $proyecto)
            ->with('success', 'La tarea se actualizó correctamente.');
    }

    public function destroy(Proyecto $proyecto, Tarea $tarea): RedirectResponse
    {
        if (auth()->user()->id !== $proyecto->creado_por_id || $tarea->proyecto_id !== $proyecto->id) {
            abort(403, 'No tienes permiso para eliminar esta tarea.');
        }

        $tarea->delete();

        return redirect()
            ->route('tareas.index', $proyecto)
            ->with('success', 'La tarea se eliminó correctamente.');
    }

    public function updateEstado(UpdateTareaEstadoRequest $request, Proyecto $proyecto, Tarea $tarea): Response
    {
        if ($tarea->proyecto_id !== $proyecto->id) {
            return response()->json(['error' => 'Esta tarea no pertenece al proyecto.'], 403);
        }

        $tarea->update(['estado' => $request->estado]);

        return response()->json(['success' => true, 'estado' => $tarea->estado]);
    }
}
