<?php

namespace App\Http\Controllers;

use App\Models\AvanceProyecto;
use App\Models\HitoProyecto;
use App\Models\IncidenciaProyecto;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeguimientoProyectoController extends Controller
{
    public function index(Proyecto $proyecto): View
    {
        $proyecto->load([
            'hitos.responsable',
            'avances.registradoPor',
            'incidencias.responsable',
            'incidencias.registradoPor',
        ]);

        $usuarios = User::where('activo', true)
            ->orderBy('name')
            ->get();

        return view(
            'seguimiento.index',
            compact('proyecto', 'usuarios')
        );
    }

    public function storeHito(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string', 'max:5000'],
            'fecha_planificada' => ['required', 'date'],
            'responsable_id' => ['nullable', 'exists:users,id'],
        ]);

        HitoProyecto::create([
            'proyecto_id' => $proyecto->id,
            'nombre' => $datos['nombre'],
            'descripcion' => $datos['descripcion'] ?? null,
            'fecha_planificada' => $datos['fecha_planificada'],
            'responsable_id' => $datos['responsable_id'] ?? null,
            'estado' => 'Pendiente',
        ]);

        return back()->with('success', 'El hito se registró correctamente.');
    }

    public function updateHito(
        Request $request,
        Proyecto $proyecto,
        HitoProyecto $hito
    ): RedirectResponse {
        abort_unless((int) $hito->proyecto_id === (int) $proyecto->id, 404);

        $datos = $request->validate([
            'estado' => [
                'required',
                'in:Pendiente,En progreso,Cumplido,Atrasado',
            ],
            'fecha_cumplimiento' => ['nullable', 'date'],
        ]);

        $hito->update($datos);

        return back()->with('success', 'El hito se actualizó correctamente.');
    }

    public function storeAvance(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $datos = $request->validate([
            'porcentaje_avance' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'descripcion' => ['required', 'string', 'max:5000'],
            'fecha' => ['required', 'date'],
        ]);

        AvanceProyecto::create([
            'proyecto_id' => $proyecto->id,
            'porcentaje_avance' => $datos['porcentaje_avance'],
            'descripcion' => $datos['descripcion'],
            'fecha' => $datos['fecha'],
            'registrado_por_id' => $request->user()->id,
        ]);

        return back()->with('success', 'El avance se registró correctamente.');
    }

    public function storeIncidencia(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:5000'],
            'nivel_severidad' => [
                'required',
                'in:Baja,Media,Alta,Crítica',
            ],
            'responsable_id' => ['nullable', 'exists:users,id'],
            'fecha_registro' => ['required', 'date'],
        ]);

        IncidenciaProyecto::create([
            'proyecto_id' => $proyecto->id,
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'nivel_severidad' => $datos['nivel_severidad'],
            'estado' => 'Abierta',
            'fecha_registro' => $datos['fecha_registro'],
            'responsable_id' => $datos['responsable_id'] ?? null,
            'registrado_por_id' => $request->user()->id,
        ]);

        return back()->with('success', 'La incidencia se registró correctamente.');
    }

    public function updateIncidencia(
        Request $request,
        Proyecto $proyecto,
        IncidenciaProyecto $incidencia
    ): RedirectResponse {
        abort_unless(
            (int) $incidencia->proyecto_id === (int) $proyecto->id,
            404
        );

        $datos = $request->validate([
            'estado' => [
                'required',
                'in:Abierta,En atención,Resuelta',
            ],
            'fecha_resolucion' => ['nullable', 'date'],
        ]);

        $incidencia->update($datos);

        return back()->with(
            'success',
            'La incidencia se actualizó correctamente.'
        );
    }
}
