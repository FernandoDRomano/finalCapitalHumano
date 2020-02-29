<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //TABLA DE LA BD
    protected $table = 'departamentos';
    //ATRIBUTOS A SER MODIFICADOS
    protected $fillable = ['nombre', 'depende_departamento_id', 'nivel_departamento_id', 'organizacion_id'];

    /*
     *
     * RELACIONES CON LOS MODELOS
     *
     */

    //RELACION CON LA ORGANIZACION
    public function organizacion(){
        return $this->belongsTo(Organizacion::class);
    }

    //RELACION CON LOS NIVELES DE DEPARTAMENTOS
    public function nivelDepartamento(){
        return $this->belongsTo(NivelDepartamento::class);
    }

    //RELACION CON LOS PUESTOS DE TRABAJO
    public function puestos(){
        return $this->hasMany(PuestoDeTrabajo::class);
    }

    //RELACION CON LOS DEPARTAMENTOS QUE TIENE A SU CARGO
    public function departamentos(){
        return $this->hasMany(Departamento::class, 'depende_departamento_id');
    }

    public function dependeDepartamento(){
        return $this->belongsTo(Departamento::class);
    }

    public function personas(){
        return $this->hasManyThrough(Persona::class, PuestoDeTrabajo::class);
    }

    //PARA EL BUSCADOR USARE UN SCOPE
    public function scopeSearch($query, $buscar){
        return $query->where('nombre', 'LIKE' , '%'. $buscar . '%')
            ->orwhere('id' , $buscar);
    }

}
