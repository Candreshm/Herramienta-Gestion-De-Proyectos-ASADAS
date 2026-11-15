<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\EstadoProyecto;
use Illuminate\Http\Request;

class ProyectoEstadoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::with('estado')->get();
        return view('proyectos.estados', compact('proyectos'));
    }

    public function aprobar(Proyecto $proyecto)
    {
        $estadoAprobado = EstadoProyecto::firstOrCreate(['nombre' => 'Aprobado']);
        $proyecto->update(['estado_proyecto_id' => $estadoAprobado->id]);
        return back()->with('success', "El proyecto '{$proyecto->nombre}' ha sido APROBADO.");
    }

    public function rechazar(Proyecto $proyecto)
    {
        $estadoRechazado = EstadoProyecto::firstOrCreate(['nombre' => 'Rechazado']);
        $proyecto->update(['estado_proyecto_id' => $estadoRechazado->id]);
        return back()->with('success', "El proyecto '{$proyecto->nombre}' ha sido RECHAZADO.");
    }

    public function cambiarEstado(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'estado_proyecto_id' => 'required|exists:estado_proyectos,id'
        ]);

        $proyecto->update([
            'estado_proyecto_id' => $request->estado_proyecto_id
        ]);

        return back()->with('success', "El estado del proyecto se ha actualizado correctamente.");
    }
}