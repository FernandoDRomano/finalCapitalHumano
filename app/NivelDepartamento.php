<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelDepartamento extends Model
{
    //TABLA DE LA BD
    protected $table = 'nivel_departamentos';
    //ATRIBUTOS A SER MODIFICADOS
    protected $fillable = ['nombre', 'jerarquia'];

    /*
     *
     * RELACIONES CON LOS MODELOS
     *
     */

    //RELACION CON LOS DEPARTAMENTOS
    public function departamentos(){
        return $this->hasMany(Departamento::class);
    }

    //PARA EL BUSCADOR USARE UN SCOPE
    public function scopeSearch($query, $buscar){
        return $query->where('nombre', 'LIKE' , '%'. $buscar . '%')
            ->orwhere('id' , $buscar);
    }

}
