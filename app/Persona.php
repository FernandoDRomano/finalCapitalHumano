<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //TABLA DE LA BD
    protected $table = 'personas';
    //ATRIBUTOS A SER MODIFICADOS
    protected $fillable = ['nombre', 'apellido', 'dni', 'fechaNacimiento', 'direccion', 'organizacion_id'];

    /*
    *
    * RELACIONES CON LOS MODELOS
    *
    */

    //RELACION CON LOS PUESTOS DE TRABAJO
    public function puestosDeTrabajos(){
        return $this->belongsToMany(PuestoDeTrabajo::class);
    }

    //RELACION CON LA ORGANIZACION
    public function organizacion(){
        return $this->belongsTo(Organizacion::class);
    }

    //PARA EL BUSCADOR USARE UN SCOPE
    public function scopeSearch($query, $buscar){
        return $query->where('nombre', 'LIKE' , '%'. $buscar . '%')
            ->orwhere('apellido', $buscar)
            ->orwhere('dni', $buscar)
            ->orwhere('id' , $buscar);
    }

}
