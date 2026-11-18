<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $tarea = $this->route('tarea');
        return $this->user()?->activo && $this->user()->id === $tarea->creado_por_id;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'fecha_vencimiento' => ['required', 'date_format:Y-m-d H:i', 'after:now'],
            'responsable_id' => ['required', 'exists:users,id'],
            'estado' => ['required', 'in:Pendiente,En progreso,Completado'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la tarea es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser posterior a ahora.',
            'responsable_id.required' => 'Debe asignar un responsable.',
            'responsable_id.exists' => 'El responsable seleccionado no existe.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Pendiente, En progreso o Completado.',
        ];
    }
}
