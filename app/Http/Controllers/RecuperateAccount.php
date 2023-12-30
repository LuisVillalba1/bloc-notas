<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassword;
use App\Http\Requests\RecuperateAccount as recuperateRequest;
use App\Models\Usuario;
class RecuperateAccount extends Controller
{
    public function forgotPassword(){
        return view("forgotPassword");
    }

    public function recuperateAccount(recuperateRequest $request){
        return (new Usuario())->recuperateAccount($request);
    }

    public function changePassword($id){
        return view("changePassword",compact("id"));
    }

    public function change(ChangePassword $request,$id){
        return (new Usuario())->changePassword($request,$id);
    }
}
