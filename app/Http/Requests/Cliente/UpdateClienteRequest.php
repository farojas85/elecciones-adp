<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
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
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required|numeric',
            'nombres' => 'required|string|max:191',
            'sexo_id' => 'required',
            'user_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo obligatorio',
            'string' => 'Ingrese solo caracteres alfanuméricos',
            'max' => 'Ingrese :max caracteres',
            'numeric' => 'Ingrese solo números',
            'unique' => 'Número Documento Ya registrado'
        ];
    }
}
