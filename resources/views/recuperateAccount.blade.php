@extends('layouts.plantilla')

@section('head')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<script src="https://kit.fontawesome.com/ba9bd7b863.js" crossorigin="anonymous"></script>
<title>Block-notas login</title>
@endsection

@section('content')
<h2>Cambiar contraseña</h2>
<b>No compartas este link con nadie.</b>
<p>Para recuperar tu cuenta has click <a href="{{$link}}">aqui</a></p>
@endsection