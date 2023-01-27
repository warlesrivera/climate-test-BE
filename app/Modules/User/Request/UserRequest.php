<?php

namespace App\Modules\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

        $rules = [
            'name'          => 'required|string|max:30|min:3|regex:/^[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+$/',
            'email'            => 'required|unique:users',
        ];

        if (filled($this->password)) {

            $rules['password']          = 'required|max:20|min:8|regex:/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])\S{8,20}$/';
        }

        //  if (Request::is('*/update')) {
        //
        // }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'             => 'Nombre(s) requerido',
            'name.max'                  => 'Nombre(s) máximo 60 caracteres',
            'name.min'                  => 'Nombre(s) mínimo 3 caracteres',
            'name.regex'                => 'Nombre(s) sólo se permiten letras',
            'email.required'            => 'Email requerido',
            'email.unique'              => 'El email ya fue usado en una cuenta',
            'email.in'                  =>  $this->email,
            'password.required'         => 'Contraseña requerida',
            'password.min'              => 'Contraseña mínimo 8 caracteres',
            'password.max'              => 'Contraseña máximo 20 caracteres',
        ];
    }
}
