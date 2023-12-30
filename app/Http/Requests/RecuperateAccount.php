<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;

class RecuperateAccount extends FormRequest
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
            //validamos que el email ingresado para recuperar la cuenta se encuentre en nuestra base de datos
            "email"=>["required",
            "email",
            function($attribute,$value,$fail){
                $usuario = Usuario::whereHas("contactoUsuario",function($query) use($value){
                    $query->where("email",$value);
                })->first();

                if(!$usuario){
                    $fail("No se ha encontrado ninguna cuenta con el mail correspondiente");
                }
            }]
        ];
    }

    public function messages()
    {
        return[
            "required"=>"Por favor ingrese un email",
            "email.email"=>"Ingrese un mail valido"
        ];
    }
}
