<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObligacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obligaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 45);

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
        Schema::dropIfExists('obligaciones');
    }
}
