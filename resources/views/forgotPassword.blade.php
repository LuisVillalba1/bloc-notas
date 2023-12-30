@extends('layouts.plantilla')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/recuperateAccount.css">
    <script src="https://kit.fontawesome.com/ba9bd7b863.js" crossorigin="anonymous"></script>
    <title>Block-notas login</title>
@endsection

@section('content')
    <div class="main_container">
        @if (session("success"))
            <p class="success">{{session("success")}}</p>
        @else
        <div class="form_container">
            <div class="text_content">
                <h2>Recuperar cuenta</h2>
                <p>Ingresa el mail con el cual tenias vinculado tu cuenta</p>
            </div>
            <form action="{{route("recuperateAccount")}}" method="POST">
                @csrf
                <div class="input_container">
                    <input type="email" required placeholder="Email" name="email" id="email" autocomplete="email">
                    <i class="fa-solid fa-envelope"></i>
                    @error('email')
                        <p>{{$message}}</p>
                    @enderror
                </div>
                <input type="submit" value="Enviar" class="send_btn">
            </form>
        </div>
        @endif
    </div>
@endsection