<?php

namespace App\Http\Requests\PeriodoJunta;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodoJuntaRequest extends FormRequest
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
            'anio_inicio' => 'required|numeric',
            'anio_fin' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo obligatorio',
            'numeric' => 'Ingrese solo números'
        ];
    }
}