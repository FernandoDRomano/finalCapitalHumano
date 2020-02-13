<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaPuestoTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona_puesto_trabajo', function (Blueprint $table) {
            $table->bigIncrements('id');

            //RELACION CON LA PERSONA
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('id')->on('personas')
                ->onDelete('cascade')->onUpdate('cascade');

            //RELACION CON EL PUESTO DE TRABAJO
            $table->unsignedBigInteger('puesto_de_trabajo_id');
            $table->foreign('puesto_de_trabajo_id')->references('id')->on('puestos_de_trabajos')
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
        Schema::dropIfExists('persona_puesto_trabajo');
    }
}
