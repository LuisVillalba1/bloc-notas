<?php

namespace Database\Factories;

use App\Models\ContactoUsuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactoUsuario>
 */
class ContactoUsuarioFactory extends Factory
{
    protected $model = ContactoUsuario::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "Email"=>$this->faker->email(),
        ];
    }
}
