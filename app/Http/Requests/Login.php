<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
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
            //validamos que se ingrese un email y contraseña
            "email" => ["required","email"],
            "password" => ["required"]
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Por favor ingrese un Email",
            "email.email" => "Email ingresado invalido",
            "password.required" =>"Por favor ingrese una contraseña",
        ];
    }
}
