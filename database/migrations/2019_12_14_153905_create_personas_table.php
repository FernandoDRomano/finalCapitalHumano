<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 45);
            $table->string('apellido', 45);
            $table->integer('dni', 11);
            $table->date('fechaNacimiento');
            $table->string('direccion', 100);

             //RELACION CON EL PUESTO DE TRABAJO
             $table->unsignedBigInteger('organizacion_id');
             $table->foreign('organizacion_id')->references('id')->on('organizaciones')
                 ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
