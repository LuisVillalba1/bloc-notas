@extends('layouts.plantilla')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/register.css">
    <script src="https://kit.fontawesome.com/ba9bd7b863.js" crossorigin="anonymous"></script>
    <title>Block-notas login</title>
@endsection

@section('content')
    <div class="form_container">
        @if (session("success"))
            <div class="cuenta_registrada_container">
                <h3>{{session("success")}}</h3>
                <p id="redirect">Haz click <a href="{{route("main")}}">aqui</a> para iniciar sesion</p>
            </div>
        @else
        <form action="{{route("register.create")}}" method="POST">
            <h3>Crea una nueva cuenta</h3>
            @csrf
            <div class="personal_data">
                <div class="input_with_error">
                    <div class="input_container">
                        <input type="text" placeholder="Nombre" autocomplete="name" name="nombre">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    @error('nombre')
                        <p class="error_message">{{$message}}</p>
                    @enderror
                </div>
                <div class="input_with_error">
                    <div class="input_container">
                        <input type="text" placeholder="Apellido" autocomplete="family-name" name="apellido">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    @error('apellido')
                        <p class="error_message">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="contact_data">
                <div class="input_with_error">
                    <div class="input_container">
                        <input type="text" placeholder="Nombre de usuario" autocomplete="username" name="usuario">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>
                    @error('usuario')
                        <p class="error_message">{{$message}}</p>
                    @enderror
                </div>
                <div class="input_with_error">
                    <div class="input_container">
                        <input type="email" placeholder="Email" autocomplete="email" name="email">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    @error('email')
                        <p class="error_message">{{$message}}</p>
                    @enderror
                </div>
                <div class="input_with_error">
                    <div class="input_container">
                        <input type="password" placeholder="Contraseña" autocomplete="current-password" name="password">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    @error('password')
                        <p class="error_message">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <input type="submit" value="Registrarse" class="submit_btn">
        </form>
        @endif
    </div>
@endsection