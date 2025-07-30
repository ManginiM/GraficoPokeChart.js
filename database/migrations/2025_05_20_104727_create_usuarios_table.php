<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario'); // clave primaria personalizada
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->string('contraseña');
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->enum('rol', ['posteador', 'comentador', 'admin']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
