<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
    //TABLA DE LA BD
    protected $table = 'organizaciones';
    //ATRIBUTOS A SER MODIFICADOS
    protected $fillable = ['nombre'];

    /*
     *
     * RELACIONES CON LOS MODELOS
     *
     */

    //RELACION CON LOS DEPARTAMENTOS
    public function departamentos(){
        return $this->hasMany(Departamento::class);
    }

    //RELACION CON LOS DEPARTAMENTOS
    public function personas(){
        return $this->hasMany(Persona::class);
    }

    //PARA ACCEDER A LOS PUESTOS DE TRABAJOS A TRAVES DE LOS DEPATAMENTOS
    public function puestosDeTrabajos(){
        return $this->hasManyThrough(PuestoDeTrabajo::class, Departamento::class);
    }

    //PARA EL BUSCADOR USARE UN SCOPE
    public function scopeSearch($query, $buscar){
        return $query->where('nombre', 'LIKE' , '%'. $buscar . '%')
            ->orwhere('id' , $buscar);
    }


}
