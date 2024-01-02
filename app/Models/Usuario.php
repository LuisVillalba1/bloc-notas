<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecuparateAccountMail;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Laravel\SerializableClosure\Exceptions\InvalidSignatureException;

class Usuario extends Model implements Authenticatable
{   
    use AuthenticatableTrait;
    use HasFactory;

    protected $primaryKey = "UsuarioID";

    //funcion que nos permite obtener la relacion 1 a 1 con la tabla ContactoUsuario
    public function contactoUsuario()
    {
        return $this->hasOne(ContactoUsuario::class, 'ContactoID', 'ContactoID');
    }

    //creamos un nuevo usuario 
    public function createUser($request){
        try{

            $contactaData = array();
            $contactaData["email"] = $request["email"];
    
            //creamo un nuevo contacto
            $newContact = new ContactoUsuario();
    
            $newContacID = $newContact->createContact($contactaData);
            
            //creamos un nuevo usuario
            $newUser = new Usuario();
    
            $newUser->Nombre = $request["nombre"];
            $newUser->Apellido = $request["apellido"];
            $newUser->NombreUsuario = $request["usuario"];
            $newUser->password = Hash::make($request["password"]);
            $newUser->ContactoID = $newContacID;

            $newUser->save();

            return redirect()->back()->with("success","Registro exitoso");
        }
        //en caso de que exista una vaya lo enviamos a nuestra pagina de error
        catch(\Exception $e){
            return redirect()->route("error");
        }
    }

    //permitimos el login a nuestro usuario
    public function login($request){
        try{
        //obtenemos el usuario
        $usuario = Usuario::whereHas('contactoUsuario', function ($query) use ($request) {
            $query->where('Email', $request->email);
        })->first();


        //en caso de que exista y la contraseña ingresada sea la misma que la de la base de datos
        if($usuario != null && Hash::check($request->password,$usuario["password"])){
            //eliminamos todos los datos de nuestra session y creamos una autenticacion para ese usuario
            session()->flush();
            Auth::login($usuario);
            return redirect()->route("mainBlock");
        }
        else{
            session()->put("error","Contraseña o email incorrectos");
            return redirect()->back();
        }

        }
        catch(\Exception $e){
            session()->put("error","Ha ocurrido un error al iniciar session,por favor intentelo mas tarde");
            return redirect()->route("error");
        }
    }

    //enviamos un correo electronico un link con una firma temporal para recuperar la cuenta
    public function sendRecoveryLink($request){
        try{
            $usuario = Usuario::whereHas("contactoUsuario",function($query) use($request){
                $query->where("email",$request["email"]);
            })->first();


            Mail::to($request["email"])
            ->send(new RecuparateAccountMail($usuario["UsuarioID"]));

            return redirect()->back()->with("success","Se ha enviado un correo electronico a su cuenta");
        }
        catch(\Exception $e){
            session()->put("error","Ha ocurrido un error al enviar el email.Por favor intentelo mas tarde");
            return redirect()->route("error");
        }
    }

    //cambiamos la contraseña del usuario
    public function changePassword($request,$id){
        try{
            if(!$request->hasValidSignature()){
                return redirect()->back()->with("Ha ocurrido un error con al firma del link");
            }
            //desencriptamos la contraseña
            $usuarioID = Crypt::decryptString($id);
    
            $usuario = Usuario::where("UsuarioID",$usuarioID)->first();
    
            $usuario->password = Hash::make($request->password);
    
            $usuario->save();
    
            return redirect()->route("main");
           }
           catch(\Exception $e){
            return redirect()->back()->with("Ha ocurrido un error inesperado");
           }
    }
}
