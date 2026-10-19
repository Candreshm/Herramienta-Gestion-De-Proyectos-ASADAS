<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProyectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->activo;
    }

    public function rules(): array
    {
        $proyecto = $this->route('proyecto');

        return [
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('proyectos', 'codigo')
                    ->ignore($proyecto?->id),
            ],

            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'descripcion' => [
                'required',
                'string',
            ],

            'objetivo' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.max' => 'El código no puede superar los 50 caracteres.',
            'codigo.unique' => 'El código ya está registrado.',
            'nombre.required' => 'El nombre de la iniciativa es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'objetivo.required' => 'El objetivo es obligatorio.',
        ];
    }
}
