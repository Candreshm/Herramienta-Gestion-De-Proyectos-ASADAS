<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTareaEstadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->activo;
    }

    public function rules(): array
    {
        return [
            'estado' => ['required', 'in:Pendiente,En progreso,Completado'],
        ];
    }

    public function messages(): array
    {
        return [
            'estado.in' => 'El estado debe ser Pendiente, En progreso o Completado.',
        ];
    }
}
