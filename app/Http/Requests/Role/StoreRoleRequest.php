<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:191',
            'slug' =>'required|string|max:191|unique:tipo_accesos,slug',
            'tipo_acceso_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo Obligatorio',
            'string' => 'Ingrese solo alfanuméricos',
            'max' => 'Máximo :max caracteres',
            'unique' => 'El slug ya existe'
        ];
    }
}
