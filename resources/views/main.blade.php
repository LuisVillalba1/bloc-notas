@extends('layouts.plantilla')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/login.css">
    <script src="https://kit.fontawesome.com/ba9bd7b863.js" crossorigin="anonymous"></script>
    <title>Block-notas login</title>
@endsection

@section('content')
<div class="form_container">
    <form action="{{route("login")}}" method="POST">
        @csrf
        <h2>Ingresar</h2>
        <div class="input_container">
            <input type="email" placeholder="Email" autocomplete="email" name="email" id="email">
            <i class="fa-solid fa-envelope"></i>
        </div>
        @error('email')
            <p class="error_message">{{$message}}</p>
        @enderror
        <div class="input_container">
            <input type="password" placeholder="Contraseña" autocomplete="current-password" name="password" id="password">
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="check_password_container">
            <input type="checkbox" class="checkbox_password">
            <p>Mostrar contraseña</p>
        </div>
        @error('password')
            <p class="error_message">{{$message}}</p>
        @enderror

        @if (session()->has("error"))
            <p class="error_message">{{session()->get("error")}}</p>
        @endif
        <a href="{{route("forgotPassword")}}" class="forgot_password">¿Olvidaste tu contraseña?</a>
        <input type="submit" value="Ingresar" class="submit_btn">
        <div class="register_container">
            <p>¿Aun no tiene una cuenta?</p>
            <a href="{{route("register")}}">Registrarse</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script src="./js/main.js"></script>
@endsection