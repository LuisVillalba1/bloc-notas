<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\Http\Requests\Register;
use App\Models\Usuario;

class Ingresar extends Controller
{
    public function index(){
        return view("main");
    }

    public function login(Login $request){
        return (new Usuario())->login($request);
    }

    public function register(){
        return view("register");
    }

    public function registerCreate(Register $request){
        return (new Usuario())->createUser($request);
    }

    public function forgotPassword(){
        return view("forgotPassword");
    }

}
