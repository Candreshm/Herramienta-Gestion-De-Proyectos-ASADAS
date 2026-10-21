<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateModeloViabilidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) ($this->user()?->activo && $this->user()->role?->nombre === 'Administrador');
    }

    public function rules(): array
    {
        return [
            'umbral_minimo' => ['required', 'numeric', 'between:0,100'],
            'peso_riesgo' => ['required', 'numeric', 'min:0', 'max:100'],
            'peso_criticidad' => ['required', 'numeric', 'min:0', 'max:100'],
            'peso_prioridad' => ['required', 'numeric', 'min:0', 'max:100'],
            'peso_costo' => ['required', 'numeric', 'min:0', 'max:100'],
            'maximo_costo' => ['required', 'numeric', 'gt:0'],
            'riesgo_bajo' => ['required', 'numeric', 'between:0,100'],
            'riesgo_medio' => ['required', 'numeric', 'between:0,100'],
            'riesgo_alto' => ['required', 'numeric', 'between:0,100'],
            'criticidad_baja' => ['required', 'numeric', 'between:0,100'],
            'criticidad_media' => ['required', 'numeric', 'between:0,100'],
            'criticidad_alta' => ['required', 'numeric', 'between:0,100'],
            'prioridad_baja' => ['required', 'numeric', 'between:0,100'],
            'prioridad_media' => ['required', 'numeric', 'between:0,100'],
            'prioridad_alta' => ['required', 'numeric', 'between:0,100'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $total = collect(['peso_riesgo', 'peso_criticidad', 'peso_prioridad', 'peso_costo'])
                ->sum(fn (string $campo) => (float) $this->input($campo, 0));

            if (abs($total - 100) > 0.01) {
                $validator->errors()->add('pesos', 'La suma de las ponderaciones debe ser exactamente 100.');
            }
        });
    }
}
