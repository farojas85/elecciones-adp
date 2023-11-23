<?php

namespace App\Http\Requests\MenuRole;

use Illuminate\Foundation\Http\FormRequest;

class MostrarMenuRoleRequest extends FormRequest
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
            'role_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => '* Campo obligatorio'
        ];
    }
}
