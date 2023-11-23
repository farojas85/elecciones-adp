<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;

class NumeroDocumentoRequest extends FormRequest
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
            'tipo_documento_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo obligatorio'
        ];
    }
}
