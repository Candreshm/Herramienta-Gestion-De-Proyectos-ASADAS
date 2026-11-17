<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\TareaProyecto;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TareaProyectoController extends Controller
{
    public function index(Proyecto $proyecto): View
    {
        $proyecto->load([
            'tareas.responsable',
            'estado',
        ]);

        $pendientes = $proyecto->tareas
            ->where('estado', 'Pendiente');

        $enProgreso = $proyecto->tareas
            ->where('estado', 'En progreso');

        $completadas = $proyecto->tareas
            ->where('estado', 'Completada');

        $usuarios = User::where('activo', true)
            ->orderBy('name')
            ->get();

        return view(
            'tareas.kanban',
            compact(
                'proyecto',
                'pendientes',
                'enProgreso',
                'completadas',
                'usuarios'
            )
        );
    }

    public function store(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $datos = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:150',
            ],
            'descripcion' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'responsable_id' => [
                'nullable',
                'exists:users,id',
            ],
            'fecha_inicio' => [
                'nullable',
                'date',
            ],
            'fecha_vencimiento' => [
                'nullable',
                'date',
                'after_or_equal:fecha_inicio',
            ],
        ]);

        TareaProyecto::create([
            'proyecto_id' => $proyecto->id,
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'] ?? null,
            'responsable_id' => $datos['responsable_id'] ?? null,
            'fecha_inicio' => $datos['fecha_inicio'] ?? null,
            'fecha_vencimiento' => $datos['fecha_vencimiento'] ?? null,
            'estado' => 'Pendiente',
        ]);

        return back()->with(
            'success',
            'La tarea se registró correctamente.'
        );
    }

    public function cambiarEstado(
        Request $request,
        Proyecto $proyecto,
        TareaProyecto $tarea
    ): RedirectResponse {
        if ((int) $tarea->proyecto_id !== (int) $proyecto->id) {
            abort(404);
        }

        $datos = $request->validate([
            'estado' => [
                'required',
                'in:Pendiente,En progreso,Completada',
            ],
        ]);

        $tarea->update([
            'estado' => $datos['estado'],
        ]);

        return back()->with(
            'success',
            'El estado de la tarea se actualizó correctamente.'
        );
    }

    public function destroy(
        Proyecto $proyecto,
        TareaProyecto $tarea
    ): RedirectResponse {
        if ((int) $tarea->proyecto_id !== (int) $proyecto->id) {
            abort(404);
        }

        $tarea->delete();

        return back()->with(
            'success',
            'La tarea se eliminó correctamente.'
        );
    }
}