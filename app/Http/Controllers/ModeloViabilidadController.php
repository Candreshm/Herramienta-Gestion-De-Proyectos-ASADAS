<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateModeloViabilidadRequest;
use App\Models\ModeloViabilidad;
use App\Models\Proyecto;
use App\Services\ViabilidadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ModeloViabilidadController extends Controller
{
    public function edit(): View
    {
        $modelo = ModeloViabilidad::where('activo', true)->latest('id')->first();

        return view('viabilidad.edit', compact('modelo'));
    }

    public function update(UpdateModeloViabilidadRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            ModeloViabilidad::where('activo', true)->update(['activo' => false]);
            ModeloViabilidad::create([
                'nombre' => 'Modelo de viabilidad',
                'criterios' => $this->criteriosDesde($request),
                'umbral_minimo' => $request->umbral_minimo,
                'activo' => true,
                'actualizado_por_id' => $request->user()->id,
            ]);
        });

        return back()->with('success', 'La configuración del modelo se guardó correctamente.');
    }

    public function evaluar(Proyecto $proyecto, ViabilidadService $service): RedirectResponse
    {
        $modelo = ModeloViabilidad::where('activo', true)->latest('id')->first();
        abort_if(!$modelo, 422, 'El modelo de viabilidad no está configurado.');

        if (!$proyecto->nivel_riesgo || !$proyecto->criticidad || !$proyecto->prioridad || $proyecto->costo_estimado === null) {
            return back()->withErrors(['viabilidad' => 'Complete la información de HU-05 antes de aplicar el modelo.']);
        }

        $service->evaluar($proyecto, $modelo);

        return back()->with('success', 'El modelo de viabilidad se aplicó correctamente.');
    }

    private function criteriosDesde(UpdateModeloViabilidadRequest $request): array
    {
        return [
            'nivel_riesgo' => ['peso' => (float) $request->peso_riesgo, 'valores' => ['Bajo' => (float) $request->riesgo_bajo, 'Medio' => (float) $request->riesgo_medio, 'Alto' => (float) $request->riesgo_alto]],
            'criticidad' => ['peso' => (float) $request->peso_criticidad, 'valores' => ['Baja' => (float) $request->criticidad_baja, 'Media' => (float) $request->criticidad_media, 'Alta' => (float) $request->criticidad_alta]],
            'prioridad' => ['peso' => (float) $request->peso_prioridad, 'valores' => ['Baja' => (float) $request->prioridad_baja, 'Media' => (float) $request->prioridad_media, 'Alta' => (float) $request->prioridad_alta]],
            'costo_estimado' => ['peso' => (float) $request->peso_costo, 'maximo' => (float) $request->maximo_costo],
        ];
    }
}
