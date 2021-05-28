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
            'typography' => 'required|string',
            'colors' => 'required|string',
            'logo' => 'required|file',
            'date' => 'required|date',
            'is_in_progress' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'team_name.required' => 'El nombre del equipo es obligatorio',
            'typography.required' => 'La tipografía es obligatoria',
            'colors.required' => 'Los colores son obligatorios',
            'logo.required' => 'El logotipo es obligatorio',
            'date.required' => 'La fecha es obligatoria',
            'is_in_progress.required' => 'El estatus (is_in_progress) del equipo es obligatorio'
        ];
    }
}
