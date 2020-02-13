<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuestosDeTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestos_de_trabajos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 45);

            //RELACION CON EL NIVEL DEL PUESTO
            $table->unsignedBigInteger('nivel_puesto_id');
            $table->foreign('nivel_puesto_id')->references('id')->on('nivel_puestos')
                ->onDelete('cascade')->onUpdate('cascade');

            //RELACION CON EL DEPARTAMENTO
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos')
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
        Schema::dropIfExists('puestos_de_trabajos');
    }
}
