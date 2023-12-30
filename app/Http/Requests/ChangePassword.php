<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
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
            //validamos que la contraseña contenga una letra en mayuscula y que ambos campos coincidan
            "password"=>["required",
            function($attribute,$value,$fail){
                if(!preg_match('/[A-Z]/', $value)){
                    $fail("La contraseña tiene que tener al menos una letra en mayuscula");
                }
            },
            "max:50"
            ],
            "password_repeat"=>["required","same:password"]
        ];
    }

    public function messages()
    {
        return [
            "required"=>"El campo es requerido",
            "same"=>"Las contraseñas no coinciden"
        ];
    }
}
