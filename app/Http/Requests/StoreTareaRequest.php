<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTareaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $proyecto = \App\Models\Proyecto::findOrFail($this->proyecto_id);
        return $this->user()?->activo && $this->user()->id === $proyecto->creado_por_id;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'fecha_vencimiento' => ['required', 'date_format:Y-m-d H:i', 'after:now'],
            'responsable_id' => ['required', 'exists:users,id'],
            'proyecto_id' => ['required', 'exists:proyectos,id'],
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
        ];
    }
}
