<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluacionProyectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'fecha_evaluacion' => [
                'required',
                'date',
            ],

            'criterios' => [
                'required',
                'array:tecnico,financiero,operativo,normativo',
            ],

            'criterios.tecnico' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'criterios.financiero' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'criterios.operativo' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'criterios.normativo' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_evaluacion.required' =>
                'La fecha de evaluación es obligatoria.',

            'criterios.required' =>
                'Debe completar los cuatro criterios de evaluación.',

            'criterios.array' =>
                'Los criterios enviados no son válidos.',

            'criterios.*.required' =>
                'Debe asignar una puntuación a cada criterio.',

            'criterios.*.integer' =>
                'Cada puntuación debe ser un número entero.',

            'criterios.*.between' =>
                'Cada puntuación debe estar entre 1 y 5.',
        ];
    }
}
