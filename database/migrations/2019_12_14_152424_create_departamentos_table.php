<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 45);

            //RELACION CON LOS NIVELES DE DEPARTAMENTO
            $table->unsignedBigInteger('nivel_departamento_id');
            $table->foreign('nivel_departamento_id')->references('id')->on('nivel_departamentos')
                ->onDelete('cascade')->onUpdate('cascade');

            //RELACION CON LA ORGANIZACION
            $table->unsignedBigInteger('organizacion_id');
            $table->foreign('organizacion_id')->references('id')->on('organizaciones')
                ->onDelete('cascade')->onUpdate('cascade');

            //RELACION DE DEPENDENCIA DE LOS DEPARTAMENTOS (PARA SABER QUE DEPARTAMENTO DEPENDE DE OTRO)
            $table->unsignedBigInteger('depende_departamento_id');
            $table->foreign('depende_departamento_id')->references('id')->on('departamentos')
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
        Schema::dropIfExists('departamentos');
    }
}
