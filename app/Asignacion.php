<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{

        //TABLA DE LA BD
        protected $table = 'persona_puesto_trabajo';
        //ATRIBUTOS A SER MODIFICADOS
        protected $fillable = ['nombre', 'persona_id', 'puesto_de_trabajo_id'];

        /*
         *
         * RELACIONES CON LOS MODELOS
         *
         */

        //RELACION CON LOS PUESTOS DE TRABAJO
        public function persona(){
            return $this->belongsTo(Persona::class);
        }

        //RELACION CON LOS DEPARTAMENTOS QUE TIENE A SU CARGO
        public function puesto(){
            return $this->belongsTo(PuestoDeTrabajo::class, 'puesto_de_trabajo_id');
        }

}
