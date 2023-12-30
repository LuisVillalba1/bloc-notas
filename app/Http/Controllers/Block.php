<?php

namespace App\Http\Controllers;

use App\Http\Requests\Note;
use App\Models\Bloc;
use Illuminate\Support\Facades\Crypt;

class Block extends Controller
{

    public function index(){
        //obtenemos todos los blocks del usuario
        $notas = (new Bloc())->show();
        $encrypts = array();
        foreach($notas as $nota){
            //encryptamos el id de cada nota 
            $encryptedID = Crypt::encryptString($nota->NoteID);
            array_push($encrypts,$encryptedID);
        }
        return view("./bloc/main",compact("notas","encrypts"));
    }

    public function create(Note $request){
        return (new Bloc())->create($request);
    }

    public function delete($id){
        return (new Bloc())->deleteNote($id);
    }

    public function edit(Note $request,$id){
        return (new Bloc())->editNote($request,$id);
    }
}
