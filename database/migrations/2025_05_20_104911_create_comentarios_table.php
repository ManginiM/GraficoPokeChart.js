<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id('id_comentario');
            $table->text('contenido');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamp('ultima_actualizacion')->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_posteo');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_posteo')->references('id_posteo')->on('posteos')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
