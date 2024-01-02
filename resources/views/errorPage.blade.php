@extends('layouts.plantilla')

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/errorPage.css">
    <script src="https://kit.fontawesome.com/ba9bd7b863.js" crossorigin="anonymous"></script>
    <title>Block-notas login</title>
@endsection

@section('content')
<div class="error-container">
    @if (session("error"))
        <h1>Oops! Something went wrong.</h1>
        <p>{{session("error")}}</p>
        <button onclick="goBack()">Go Back</button>
    @else
        <h1>Oops! Something went wrong.</h1>
        <p>We're sorry, but the page you are looking for cannot be found.</p>
        <button onclick="goBack()">Go Back</button>
    @endif
</div>
@endsection

@section('scripts')
    <script>
    function goBack() {
    window.history.back();
  }
    </script>
@endsection