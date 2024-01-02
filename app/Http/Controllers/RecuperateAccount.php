<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassword;
use App\Http\Requests\RecuperateAccount as recuperateRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RecuperateAccount extends Controller
{
    public function index(){
        return view("forgotPassword");
    }

    public function sendRecoveryLink(recuperateRequest $request){
        return (new Usuario())->sendRecoveryLink($request);
    }

    public function showChangePassword(Request $request,$id){
        //En caso de que le link tenga una firma invalida
        if(!$request->hasValidSignature()){
            session()->put("error","Ha ocurrido un error con la firma del link");
            return redirect(route("error"));
        }
        //si no enviamos el link con la firma correspondiente para hacer una solicitud put para cambiar la contraseña
        $link = URL::temporarySignedRoute("changePasswordPut",now()->addHours(1),["id"=>$id]);
        return view("changePassword",compact("link"));
    }

    public function changePassword(ChangePassword $request,$id){
        return (new Usuario())->changePassword($request,$id);
    }
}
