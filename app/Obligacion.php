<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obligacion extends Model
{
    //TABLA DE LA BD
    protected $table = 'obligaciones';
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
