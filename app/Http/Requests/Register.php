<?php

namespace App\Http\Requests;

use App\Models\ContactoUsuario;
use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
            "nombre" => ["required","max:50"],
            "apellido"=>["required","max:50"],
            "usuario"=>["required"],
            "email"=>["required",
            "email",
            function($attribute,$value,$fail){
                $emailFound = ContactoUsuario::where("email",$value)->first();

                if($emailFound != null){
                    $fail("Ya hay una cuentra registrada con ese email");
                }
            }],
            "password"=>["required",
            function($attribute,$value,$fail){
                if(!preg_match('/[A-Z]/', $value)){
                    $fail("La contraseña tiene que tener al menos una letra en mayuscula");
                }
            },
            "max:50"
            ]
        ];
    }
    public function messages()
    {
        return [
            "required" => "El campo es requerido",
            "nombre.max"=>"El nombre no puede tener mas de 50 caracteres",
            "apellido.max"=>"El apellido no puede tener mas de 50 caracteres",
            "email.email"=>"El email ingresado no es valido",
            "password.max"=>"La contraseña no puede tener mas de 50 caracteres"
        ];
    }
}
