<?php

namespace App\Http\Requests\Prestamo;

use Illuminate\Foundation\Http\FormRequest;

class StorePrestamoRequest extends FormRequest
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
            'cliente_id' => 'required',
            'cliente' => 'required',
            'cobrador' => 'required',
            'user_id' => 'required',
            'fecha_prestamo' => 'required',
            'moneda_id' => 'required',
            'tipo_cambio' => 'required',
            'tasa_interes_id' => 'required',
            'monto' => 'required',
            'interes' => 'required',
            'tipo_cuota_id' => 'required',
            'numero_cuotas' => 'required',
            'forma_pago_id' => 'required',
            'periodo_gracia' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo obligatorio'
        ];
    }
}
