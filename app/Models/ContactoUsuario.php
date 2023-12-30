<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoUsuario extends Model
{
    use HasFactory;

    protected $primaryKey = "ContactoID";


    public function createContact($data){
        try{
            //creamos un nuevo contacto y devolvemos el id del mismo
            $NewContact = new ContactoUsuario();

            $NewContact->Email = $data["email"];

            $NewContact->save();

            return $NewContact->ContactoID;
        }
        catch(\Exception $e){
            return "error createContact";
        }
    }
}
