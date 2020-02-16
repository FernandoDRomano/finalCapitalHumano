<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelPuesto extends Model
{
    //TABLA DE LA BD
    protected $table = 'nivel_puestos';
    //ATRIBUTOS A SER MODIFICADOS
    protected $fillable = ['nombre'];

    /*
     *
     * RELACIONES CON LOS MODELOS
     *
     */

    //RELACION CON LOS PUESTOS DE TRABAJO
    public function puestosDeTrabajos(){
        return $this->hasMany(PuestoDeTrabajo::class);
    }

    //PARA EL BUSCADOR USARE UN SCOPE
    public function scopeSearch($query, $buscar){
        return $query->where('nombre', 'LIKE' , '%'. $buscar . '%')
            ->orwhere('id' , $buscar);
    }

}
