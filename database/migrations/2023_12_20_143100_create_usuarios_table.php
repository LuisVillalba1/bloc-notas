<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id("UsuarioID");
            $table->unsignedBigInteger("ContactoID");
            $table->foreign("ContactoID")
            ->references("ContactoID")
            ->on("contacto_usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");
            
            $table->string("Nombre");
            $table->string("Apellido");
            $table->string("NombreUsuario",100);
            $table->string("password",200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
