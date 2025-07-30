<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadisticasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadisticas', function (Blueprint $table) {
            $table->id('id_estadistica');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('total_accesos')->default(0);
            $table->integer('total_posteos')->default(0);
            $table->integer('total_comentarios')->default(0);
            $table->timestamp('ultima_actividad')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estadisticas');
    }
}
