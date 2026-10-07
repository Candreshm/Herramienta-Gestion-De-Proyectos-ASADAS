<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\UpdateProyectoHu05Request;
use App\Models\EstadoProyecto;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\EvidenciaProyecto;
use Illuminate\Support\Facades\Storage;

class ProyectoController extends Controller
{
  
    public function index(): View
    {
        $proyectos = Proyecto::with(['estado', 'creador'])
            ->latest()
            ->get();

        return view('proyectos.index', compact('proyectos'));
    }

    
    public function create(): View
    {
        return view('proyectos.create');
    }

    
    public function store(StoreProyectoRequest $request): RedirectResponse
    {
        $estadoRegistrado = EstadoProyecto::where(
            'nombre',
            'Registrado'
        )->firstOrFail();

        $proyecto = Proyecto::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'objetivo' => $request->objetivo,
            'estado_proyecto_id' => $estadoRegistrado->id,
            'creado_por_id' => $request->user()->id,
            'activo' => true,
        ]);

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with(
                'success',
                'La iniciativa se registró correctamente.'
            );
    }

    
    public function show(Proyecto $proyecto): View
    {
        $proyecto->load(['estado', 'creador']);

        return view('proyectos.show', compact('proyecto'));
    }

    public function editHu05(Proyecto $proyecto): View
{
    return view('proyectos.hu05', compact('proyecto'));
}

    public function updateHu05(
    UpdateProyectoHu05Request $request,
    Proyecto $proyecto
):      RedirectResponse {
        $proyecto->update([
        'justificacion' => $request->justificacion,
        'costo_estimado' => $request->costo_estimado,
        'impacto_esperado' => $request->impacto_esperado,
        'nivel_riesgo' => $request->nivel_riesgo,
        'criticidad' => $request->criticidad,
        'prioridad' => $request->prioridad,
    ]);

    if ($request->hasFile('evidencia')) {
        $archivo = $request->file('evidencia');

        $ruta = $archivo->store(
            'evidencias/proyectos',
            'public'
        );

        EvidenciaProyecto::create([
            'proyecto_id' => $proyecto->id,
            'nombre_original' => $archivo->getClientOriginalName(),
            'ruta' => $ruta,
            'tipo_mime' => $archivo->getMimeType(),
            'tamano' => $archivo->getSize(),
            'hash' => hash_file(
                'sha256',
                $archivo->getRealPath()
            ),
        ]);
    }

    return redirect()
        ->route('proyectos.show', $proyecto)
        ->with(
            'success',
            'La información de HU-05 se guardó correctamente.'
        );
}

    return redirect()
        ->route('proyectos.show', $proyecto)
        ->with(
            'success',
            'La información de HU-05 se guardó correctamente.'
        );
}
}
