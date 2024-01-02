<?php

namespace Tests\Feature;

use App\Mail\RecuparateAccountMail;
use App\Models\ContactoUsuario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Tests\TestCase;

class RecuperateAccountTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_forgotPasswordShow(){
        $response = $this->get(route("forgotPassword"));

        $response->assertViewIs("forgotPassword");

    }

    //enviamos un mail al usuario para recuperar su cuenta
    public function test_forgotPassword(){
        //Con mail fake simulamos el envio de correos electronicos, no lo hacemos de verdad
        Mail::fake();
        
        $usuario = Usuario::factory()->create();

        $response = $this->post(route("recuperateAccount"),[
            "email"=>$usuario->contactoUsuario->Email
        ]);

        //verificamos que se envie un mail a la cuenta correspondiente
        Mail::assertSent(RecuparateAccountMail::class,function($mail) use ($usuario){
            return $mail->hasTo($usuario->contactoUsuario->Email)&&
            $mail->hasSubject("Recuparate Account Mail")&&
            $mail->assertSeeInHtml("Cambiar contraseña");
        });

        //verificamos que el usuario reciba el mensaje correspondiente
        $response->assertSessionHas("success","Se ha enviado un correo electronico a su cuenta")
        ->assertRedirect();

        ContactoUsuario::where("Email",$usuario->contactoUsuario->Email)->delete();
    }

    //simulamos que no existe un email correspondiente registrado en la base de datos
    public function test_forgotPasswordFail(){
        $usuario = Usuario::factory()->create();

        $response = $this->post(route("recuperateAccount"),[
            "email"=>"pepito"
        ]);

        $response->assertRedirect()
        ->assertSessionHasErrors(["email"]);

        ContactoUsuario::where("Email",$usuario->contactoUsuario->Email)->delete();
    }

    //verificamos que se pueda ingresar a la url con la firma
    public function test_changePasswordShow(){
        //creamos un usuario y encriptamos su id
        $usuario = Usuario::factory()->create();

        $idEnctyp = Crypt::encryptString($usuario->UsuarioID);

        //firmamos la url
        $url = URL::temporarySignedRoute("changePassword",now()->addHours(1),["id"=>$idEnctyp]);

        //hacemos la peticion get
        $response = $this->get($url);

        $response->assertViewIs("changePassword");

        ContactoUsuario::where("Email",$usuario->contactoUsuario->Email);
    }

    public function test_changePassword(){
        //creamos un usuario y encriptamos su id
        $usuario = Usuario::factory()->create();

        $idEnctyp = Crypt::encryptString($usuario->UsuarioID);

        $link = URL::temporarySignedRoute("changePasswordPut",now()->addHours(1),["id"=>$idEnctyp]);
        
        $response = $this->put($link,[
            "password"=>"Pepito",
            "password_repeat"=>"Pepito"
        ]);

        $response->assertStatus(302)
        ->assertRedirect(route("main"));

        ContactoUsuario::where("Email",$usuario->contactoUsuario->Email);
    }

    //en caso de que la contraseña repetida no sea igual a la otra
    public function test_changePasswordFail(){
        //creamos un usuario y encriptamos su id
        $usuario = Usuario::factory()->create();

        $idEnctyp = Crypt::encryptString($usuario->UsuarioID);

        $link = URL::temporarySignedRoute("changePasswordPut",now()->addHours(1),["id"=>$idEnctyp]);
        
        $response = $this->put($link,[
            "password"=>"Pepito",
            "password_repeat"=>"Pepitooo"
        ]);

        $response->assertSessionHasErrors(["password_repeat"]);

        ContactoUsuario::where("Email",$usuario->contactoUsuario->Email); 
    }
}
