@extends('../layouts/plantilla')

@section('head')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="./css/bloc/main.css">
<script src="https://kit.fontawesome.com/ba9bd7b863.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Block-notas</title>
@endsection

@section('content')
    <div class="main_content">

        <div class="form_container">
            <form action="{{route("createNote")}}" id="form_add_note" method="POST">
                @csrf
                <div class="head_form">
                    <h2>Añade una nueva nota</h2>
                    <i class="fa-solid fa-circle-xmark" id="close_form_icon"></i>
                </div>
                <div class="form_content">
                    <h4>Titulo</h4>
                    <input type="text" name="titulo">
                    <h4>Descripcion</h4>
                    <textarea name="descripcion"></textarea>
                </div>
                <div class="reponse_server">
                    
                </div>
                <input type="submit" value="Agregar" class="btn_submit">
            </form>
        </div>
        <div class="form_container_edit">
            <form id="form_edit_note" method="POST">
                @csrf
                @method("put")
                <div class="head_form">
                    <h2>Modifica la nota</h2>
                    <i class="fa-solid fa-circle-xmark" id="close_form_edit"></i>
                </div>
                <div class="form_content">
                    <h4>Titulo</h4>
                    <input type="text" name="titulo">
                    <h4>Descripcion</h4>
                    <textarea name="descripcion"></textarea>
                </div>
                <div class="reponse_server" id="response_server_put">
                    
                </div>
                <input type="submit" value="Modificar" class="btn_submit">
            </form>
        </div>

        <div class="main_bloc">
            <div class="add_note_container">
                <div class="add_note_circle">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="add_note_text">
                    <p>Añade una nueva nota</p>
                </div>
            </div>
            @if ($notas)
                @for($i = 0; $i < count($notas);$i++)
                <div class="note" id={{$encrypts[$i]}}>
                    <h4 class="note_title">{{$notas[$i]->Titulo}}</h4>
                    <p class="note_content">{{$notas[$i]->Descripcion}}</p>
                    <div class="information_note">
                        <div class="date_content">
                            <p>
                                <?php
                                    $fecha = new DateTime($notas[$i]->Fecha);
                                    echo $fecha->format("M d,Y");    
                                ?>
                            </p>
                            <i class="fa-solid fa-ellipsis-vertical edit_note_icon"></i>
                            <div class="edit_note_unselected">
                                <div class="edit_note_container_edit">
                                    <i class="fa-solid fa-pen"></i>
                                    <p>Editar</p>
                                </div>
                                <form action="{{route("deleteNote",["id"=>$encrypts[$i]])}}" method="POST" class="edit_note_container_delete">
                                    @csrf
                                    @method("delete")
                                    <i class="fa-solid fa-trash"></i>
                                    <p>Eliminar</p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/bloc/main.js"></script>
@endsection