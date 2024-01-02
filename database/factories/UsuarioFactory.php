<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContactoUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Usuario::class;
    public function definition(): array
    {
        $contacto = ContactoUsuario::factory()->create();
        return [
            'Nombre' => $this->faker->name(),
            'Apellido' => $this->faker->lastName(),
            'NombreUsuario' => $this->faker->userName(),
            'password' => Hash::make($this->faker->password()),
            "ContactoID" => $contacto
        ];
    }
}
