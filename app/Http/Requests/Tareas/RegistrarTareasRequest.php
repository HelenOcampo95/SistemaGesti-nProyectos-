<?php

namespace App\Http\Requests\Tareas;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarTareasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_proyecto'       => 'required|exists:proyecto,id_proyecto',
            'titulo_tarea'      => 'required|string|min:7|max:70',
            'descripcion_tarea' => 'nullable|string|max:250',
            'fecha_entrega'     => 'required|date',
            'porcentaje_avance' => 'nullable|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo_tarea.required' => 'El título es obligatorio.',
            'titulo_tarea.max'      => 'El título no puede exceder los 150 caracteres.',
            'id_proyecto.required'  => 'Debes seleccionar un proyecto válido.',
            'fecha_entrega.required'=> 'La fecha de entrega es necesaria.',
            'porcentaje_avance.max' => 'El avance no puede ser mayor al 100%.',
        ];
    }
}
