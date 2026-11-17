<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ValidacionPresupuestaria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ValidacionPresupuestariaController extends Controller
{
    public function edit(
        Proyecto $proyecto
    ): View {
        $proyecto->load('validacionPresupuestaria');

        return view(
            'presupuesto.validacion',
            compact('proyecto')
        );
    }

    public function update(
        Request $request,
        Proyecto $proyecto
    ): RedirectResponse {
        $datos = $request->validate([
            'monto_disponible' => [
                'required',
                'numeric',
                'min:0',
            ],
            'fecha_validacion' => [
                'required',
                'date',
            ],
            'observaciones' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        ValidacionPresupuestaria::updateOrCreate(
            [
                'proyecto_id' => $proyecto->id,
            ],
            [
                'monto_disponible' =>
                    $datos['monto_disponible'],

                'fecha_validacion' =>
                    $datos['fecha_validacion'],

                'observaciones' =>
                    $datos['observaciones'] ?? null,

                'validado_por_id' =>
                    $request->user()->id,
            ]
        );

        return redirect()
            ->route(
                'presupuesto.validacion.edit',
                $proyecto
            )
            ->with(
                'success',
                'La disponibilidad presupuestaria se validó correctamente.'
            );
    }
}