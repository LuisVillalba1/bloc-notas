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
        Schema::create('blocs', function (Blueprint $table) {
            $table->id("NoteID");
            $table->unsignedBigInteger("UsuarioID");

            $table->foreign("UsuarioID")
            ->references("UsuarioID")
            ->on("usuarios")
            ->onDelete("cascade")
            ->onUpdate("cascade");

            $table->dateTime("Fecha");
            $table->string("Titulo")->max(20);
            $table->string("Descripcion")->max("340");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocs');
    }
};
