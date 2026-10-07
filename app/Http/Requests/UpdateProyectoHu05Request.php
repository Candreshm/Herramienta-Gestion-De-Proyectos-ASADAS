<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProyectoHu05Request extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->activo;
    }

    public function rules(): array
    {
        return [
            'justificacion' => [
                'required',
                'string',
            ],

            'costo_estimado' => [
                'required',
                'numeric',
                'min:0',
            ],

            'impacto_esperado' => [
                'required',
                'string',
            ],

            'nivel_riesgo' => [
                'required',
                'string',
                'in:Alto,Medio,Bajo',
            ],

            'criticidad' => [
                'required',
                'string',
                'in:Alta,Media,Baja',
            ],

            'prioridad' => [
                'required',
                'string',
                'in:Alta,Media,Baja',
            ],

            'evidencia' => [
            'nullable',
            'file',
            'max:10240',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'justificacion.required' =>
                'La justificación es obligatoria.',

            'costo_estimado.required' =>
                'El costo estimado es obligatorio.',

            'costo_estimado.numeric' =>
                'El costo estimado debe ser un número.',

            'costo_estimado.min' =>
                'El costo estimado no puede ser negativo.',

            'impacto_esperado.required' =>
                'El impacto esperado es obligatorio.',

            'nivel_riesgo.required' =>
                'El nivel de riesgo es obligatorio.',

            'nivel_riesgo.in' =>
                'El nivel de riesgo seleccionado no es válido.',

            'criticidad.required' =>
                'La criticidad es obligatoria.',

            'criticidad.in' =>
                'La criticidad seleccionada no es válida.',

            'prioridad.required' =>
                'La prioridad es obligatoria.',

            'prioridad.in' =>
                'La prioridad seleccionada no es válida.',
        ];
    }
}
