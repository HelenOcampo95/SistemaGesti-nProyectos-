<?php

namespace App\Http\Requests\Proyectos;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarProyectoRequest extends FormRequest
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
            'id_proyecto'           => 'required',
            'nombre_proyecto'       => 'required',
            'descripcion_proyecto'  => 'required',
            'fecha_inicio'          => 'required',
            'fecha_entrega'         => 'required',
            'estado_proyecto'       => 'required',
            'id_usuario'            => 'required|exists:users,id',
            'id_categoria'          => 'required|exists:categorias,id',
        ];
    }
}
