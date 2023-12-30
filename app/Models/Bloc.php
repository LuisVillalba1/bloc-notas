<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Bloc extends Model
{
    use HasFactory;

    protected $primaryKey = "NoteID";

    public function usuario(){
        //relacion 1 a 1 con la tabla usuario
        return $this->hasOne(usuario::class,"UsuarioID","UsuarioID");
    }

    public function show(){
        //obtenemos todos los blocs del usuario autenticado
        $usuario = Auth::user();
        $bloc = Bloc::whereHas("usuario",function($query) use ($usuario){
            $query->where("UsuarioID",$usuario->UsuarioID);
        })->get();

        return $bloc;
    }

    public function create($request){
        try{
            if(!Auth::user()){
                return response("Por favor inicie sesion nuevamente",401);
            }
            //creamos una nueva nota
            $usuario = Auth::user();
            $bloc = new Bloc();
            $bloc->UsuarioID = $usuario->UsuarioID;
            $bloc->Fecha = now();
            $bloc->Titulo = $request->titulo;
            $bloc->Descripcion = $request->descripcion;

            $bloc->save();

            return response("",200);
        }
        catch(\Exception $e){
            return response("Ha ocurrido un error inesperado, por favor intentelo mas tarde",500);
        }
    }

    public function deleteNote($id){
        try{
            //en caso de que el id encriptado sea correcto y se encuentre la nota, la eliminamos
            $descriptID = Crypt::decryptString($id);
            $note = Bloc::where("NoteID",$descriptID)->first();
            if(!$note){
                return response("No se ha encontrado la nota",404);
            }
            else{
                $note->delete();
                return response("Se ha eliminado con exito la nota",200);
            }
        }
        catch(\Exception $e){
            return response("Error al realizar la solicitud,por favor intentelo mas tarde",500);
        }
    }

    public function editNote($request,$id){
        try{
            //en caso de que el id de la nota y exista la misma, modificamos su titutlo y descripcion
            $idDescrypt = Crypt::decryptString($id);
            $note = Bloc::where("NoteID",$idDescrypt)->first();
    
            if(!$note){
                return response("No se ha encontrado la nota en especifico",404);
            }
            $note->Titulo = $request->titulo;
            $note->Descripcion = $request->descripcion;
    
            $note->save();
    
            return response("Se ha modificado la nota exitosamente",200);
        }   
        catch(\Exception $e){
            return response("Ha ocurrido un error inesperado,por favor intentelo mas tarde",500);
        }
    }
}
