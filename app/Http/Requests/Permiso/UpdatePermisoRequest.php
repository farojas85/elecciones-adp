<?php

namespace App\Http\Requests\Permiso;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermisoRequest extends FormRequest
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
            'nombre'     => 'required|string|max:191',
            'slug'       => 'required|string|max:191|unique:permisos,slug,'.$this->id
        ];
    }
    public function messages()
    {
        return [
            'required'  => '* Dato Obligatorio',
            'unique'    => '* Ya existe el mismo dato',
            'max'       => '* Ingrese Máximo :max caracteres',
            'string'    => '* Ingrese caracteres alfanuméricos',
            'number'    => '* Ingrese solo numeros'
        ];
    }
}
