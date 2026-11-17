<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateModeloViabilidadRequest;
use App\Models\ModeloViabilidad;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ModeloViabilidadController extends Controller
{
    public function edit(): View
    {
        $modelo = ModeloViabilidad::where(
            'activo',
            true
        )
            ->latest('id')
            ->firstOrFail();

        return view(
            'configuracion.viabilidad',
            compact('modelo')
        );
    }

    public function update(
        UpdateModeloViabilidadRequest $request
    ): RedirectResponse {
        $modelo = ModeloViabilidad::where(
            'activo',
            true
        )
            ->latest('id')
            ->firstOrFail();

        $datos = $request->validated();

        $modelo->update([
            'nombre' => $datos['nombre'],
            'peso_tecnico' => $datos['peso_tecnico'],
            'peso_financiero' => $datos['peso_financiero'],
            'peso_operativo' => $datos['peso_operativo'],
            'peso_normativo' => $datos['peso_normativo'],
            'umbral_viable' => $datos['umbral_viable'],
            'configurado_por_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('modelo-viabilidad.edit')
            ->with(
                'success',
                'El modelo de viabilidad se actualizó correctamente.'
            );
    }
}