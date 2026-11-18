<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModeloViabilidadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->activo === true
            && $this->user()?->role?->nombre === 'Administrador';
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
            ],
            'peso_tecnico' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'peso_financiero' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'peso_operativo' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'peso_normativo' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'umbral_viable' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' =>
                'El nombre del modelo es obligatorio.',

            'peso_tecnico.required' =>
                'El peso técnico es obligatorio.',

            'peso_financiero.required' =>
                'El peso financiero es obligatorio.',

            'peso_operativo.required' =>
                'El peso operativo es obligatorio.',

            'peso_normativo.required' =>
                'El peso normativo es obligatorio.',

            'umbral_viable.required' =>
                'El umbral de viabilidad es obligatorio.',

            '*.numeric' =>
                'Los pesos y el umbral deben ser valores numéricos.',

            '*.min' =>
                'Los valores no pueden ser menores que 0.',

            '*.max' =>
                'Los valores no pueden superar 100.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $suma =
                (float) $this->peso_tecnico +
                (float) $this->peso_financiero +
                (float) $this->peso_operativo +
                (float) $this->peso_normativo;

            if (abs($suma - 100) > 0.01) {
                $validator->errors()->add(
                    'ponderaciones',
                    'La suma de las ponderaciones debe ser exactamente 100 %.'
                );
            }
        });
    }
}