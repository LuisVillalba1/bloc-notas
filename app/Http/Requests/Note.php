<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Note extends FormRequest
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
            //validamos que la nueva nota tenga un titulo con un maximo de 20 caracteres y descripcion de 340
            "titulo"=>["required","max:20"],
            "descripcion"=>["required","max:340"],
        ];
    }

    public function messages()
    {
        return [
            "titulo.required"=>"Por favor ingrese un titulo",
            "titulo.max"=>"El titulo no debe contener mas de 20 caracteres",
            "descripcion.required"=>"Por favor ingrese una descripcion",
            "descripcion.max"=>"La descripcion no debe contener mas de 100 caracteres",
        ];
    }
}
