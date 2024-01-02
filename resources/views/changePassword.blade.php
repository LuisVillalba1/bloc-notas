@extends('layouts.plantilla')

@section('head')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="../css/changePassword.css">
<script src="https://kit.fontawesome.com/ba9bd7b863.js" crossorigin="anonymous"></script>
<title>Block-notas login</title>
@endsection

@section('content')
    <div class="main_container">
        <form action="{{$link}}" method="POST">
            <h2>Nueva contraseña</h2>
            <div class="text_content_container">
                <p>Por favor ingrese una nueva contraseña que no uses en otro sitio</p>
            </div>
            @csrf
            @method("Put")

            <input type="text"placeholder="Escriba la contraseña nueva" name="password">
            @error('password')
                <p>{{$message}}</p>
            @enderror
            <input type="text" placeholder="Repita la contraseña" name="password_repeat">
            @error('password_repeat')
                <p>{{$message}}</p>
            @enderror
            <input type="submit" value="Cambiar" id="btn_submit">

        </form>
    </div>
@endsection