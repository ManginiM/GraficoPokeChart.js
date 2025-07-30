<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreatePosteosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posteos', function (Blueprint $table) {
            $table->id('id_posteo');
            $table->string('titulo');
            $table->text('contenido');
            $table->unsignedBigInteger('id_pagina');
            $table->timestamps();
        
            $table->foreign('id_pagina')->references('id_pagina')->on('paginas')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posteos');
    }
}