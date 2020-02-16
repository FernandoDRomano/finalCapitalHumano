<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
    //TABLA DE LA BD
    protected $table = 'funciones';
    //ATRIBUTOS A SER MODIFICADOS
    protected $fillable = ['nombre', 'puesto_de_trabajo_id'];

    /*
    *
    * RELACIONES CON LOS MODELOS
    *
    */

    //RELACION CON EL PUESTO DE TRABAJO
    public function puestoDeTrabajo(){
        return $this->belongsTo(PuestoDeTrabajo::class);
    }

}
