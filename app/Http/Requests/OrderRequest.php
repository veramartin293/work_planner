<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team_name' => 'required|string',
            'contact_name' => 'required|string',
            'contact_phone' => 'required|string',
            'date' => 'required|date',
            'is_in_progress' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'team_name.required' => 'El nombre del equipo es obligatorio',
            'typography.required' => 'La tipografía es obligatoria',
            'colors.required' => 'Los colores son obligatorios',
            'logo.required' => 'El logotipo es obligatorio',
            'logo.file' => 'El logotipo debe ser un archivo válido',
            'date.required' => 'La fecha es obligatoria',
            'is_in_progress.required' => 'El estatus (is_in_progress) del equipo es obligatorio'
        ];
    }
}
