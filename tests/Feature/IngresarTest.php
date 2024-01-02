<?php

namespace Tests\Feature;

use App\Models\ContactoUsuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class IngresarTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_errorPage(){
        $response = $this->get(route("error"));

        $response->assertViewIs("errorPage");
    }

    public function test_ingresarShow(){
        $ingresar = $this->get("/");

        $ingresar->assertStatus(200)
        ->assertViewIs("main");
    }

    public function test_login(){
        $usuario = Usuario::factory()->create([
            "password" => Hash::make("pepitoCrack"),
        ]);

        //hacemos la solicitud post con esos valores
        $response = $this->post(route("login"),[
            "email"=>$usuario->contactoUsuario->Email,
            "password"=>"pepitoCrack"
        ]);

        //en caso de que salga todo bien lo enviamos al bloc
        $response->assertStatus(302)
        ->assertRedirect(route("mainBlock"));

        ContactoUsuario::where("Email",$usuario->contactoUsuario->Email)->delete();
    }

    public function test_loginFailPassword(){
        //creamos un usuario con respecto al contacto usuario
        $usuario = Usuario::factory()->create([
            "password" => Hash::make("pepitoCrack")
        ]);

        //Se ingresa una contraseña invalida
        $failResponse = $this->post(route("login"),[
            "email"=>$usuario->contactoUsuario->Email,
            "password"=>"pepito"
        ]);
        
        $failResponse ->assertStatus(302)
        ->assertRedirect()
        ->assertSessionHas("error","Contraseña o email incorrectos");

        ContactoUsuario::where("Email",$usuario->contactoUsuario->Email)->delete();
    }

    public function test_registerShow(){
        $response = $this->get(route("register"));

        $response->assertViewIs("register");
    }

    public function test_register(){
        $response = $this->post(route("register.create"),[
            "nombre"=>"Luis",
            "apellido"=>"Villalba",
            "usuario"=>"Luis1",
            "password"=>"pepitoCrack",
            "email"=>"luis__03@outlook.com",
        ]);

        $response->assertStatus(302)
        ->assertRedirect()
        ->assertSessionHas("success","Registro exitoso");

        ContactoUsuario::where("Email","luis__03@outlook.com")->delete();
    }

    public function test_registerRepeatEmail(){
        $usuario = Usuario::factory()->create([
            "password"=>hash::make("PepitoCrack"),
        ]);

        $repeatEmail = $this->post(route("register.create"),[
            "nombre"=>"Luis",
            "apellido"=>"Villalba",
            "usuario"=>"Luis1",
            "password"=>"pepitoCrack",
            "email"=>$usuario->contactoUsuario->Email,
        ]);

        $repeatEmail->assertSessionHasErrors(["email"]);

        ContactoUsuario::where("Email",$usuario->contactoUsuario->Email)->delete();
    }
}
