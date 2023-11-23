<?php

namespace App\Http\Requests\Ministro;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMinistroRequest extends FormRequest
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
            'nombres' => 'required|string|max:191',
            'apellido_paterno' => 'required|string|max:191',
            'apellido_materno' => 'required|string|max:191',
            'sexo_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo obligatorio',
            'string' => 'Ingrese caracteres alfanuméricos',
            'max' => 'Ingrese máximo :max caracteres',
        ];
    }
}
