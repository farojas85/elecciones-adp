<?php

namespace App\Http\Requests\AmbitoJunta;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAmbitoJuntaRequest extends FormRequest
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
            'nombre' => 'required|string|max:191|unique:ambito_juntas,nombre,'.$this->id
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo obligatorio',
            'string' => 'Ingrese solo caracteres alfanuméricos',
            'max' => 'Ingrese máximo :max caracteres',
            'unique' => 'Ya existe el grado ministerial'
        ];
    }
}
