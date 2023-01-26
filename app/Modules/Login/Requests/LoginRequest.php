<?php

namespace App\Modules\Login\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user' => 'required|email',
            'pass' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'El campo email es obligatorio.',
            'user.email' => 'El campo email debe ser un email válido.',
            'pass.required' => 'El campo password es obligatorio.',
        ];
    }
}
