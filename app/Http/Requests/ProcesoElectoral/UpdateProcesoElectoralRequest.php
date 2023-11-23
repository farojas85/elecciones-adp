<?php

namespace App\Http\Requests\ProcesoElectoral;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcesoElectoralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'periodo_junta_id' => 'required',
            'junta_directiva_id' => 'required',
            'cargo_directivo_id' => 'required',
            'vuelta_proceso_id' => 'required'
        ];
    }

    /**
     * Get the messages rules that apply to the request
     * @return array<string,
     */
    public function messages(): array
    {
        return [
            'required' => '* Campo oblogatorio'
        ];
    }
}
