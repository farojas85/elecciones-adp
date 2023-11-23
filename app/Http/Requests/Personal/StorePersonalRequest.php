<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalRequest extends FormRequest
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
            'name' => 'required|string|max:191|unique:users,name',
            'email' => 'string|max:191|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required|numeric',
            'nombres' => 'required|string|max:191',
            'apellido_paterno' => 'string|max:191',
            'apellido_materno' => ' string|max:191',
            'sexo_id' => 'required',
            'roles' => 'required|array',
            'roles.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo obligatorio',
            'confirmed' => 'Debe confirmar contraseña',
            'string' => 'Ingrese caracteres alfanuméricos',
            'max' => 'Ingrese máximo :max caracteres',
            'min' => 'Ingrese mínimo :min caracteres',
            'number' => 'Ingrese solo números',
            'unique' => 'El campo ya existe'
        ];
    }
}
