<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuestoDeTrabajo extends Model
{
    //TABLA DE LA BD
    protected $table = 'puestos_de_trabajos';
    //ATRIBUTOS A SER MODIFICADOS
    protected $fillable = ['nombre', 'nivel_puesto_id', 'departamento_id'];

    /*
     *
     * RELACIONES CON LOS MODELOS
     *
     */

    //RELACION CON EL DEPARTAMENTO
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }

    //RELACION CON EL NIVEL DEL PUESTO DE TRABAJO
    public function nivelPuesto(){
        return $this->belongsTo(NivelPuesto::class);
    }

    //RELACION CON LAS OBLIGACIONES
    public function obligaciones(){
        return $this->hasMany(Obligacion::class);
    }

    //RELACION CON LAS OBLIGACIONES
    public function funciones(){
        return $this->hasMany(Funcion::class);
    }

    //RELACION CON LAS PERSONAS (N a M)
    public function personas(){
        return $this->belongsToMany(Persona::class);
    }

    //PARA EL BUSCADOR USARE UN SCOPE
    public function scopeSearch($query, $buscar){
        return $query->where('nombre', 'LIKE' , '%'. $buscar . '%')
            ->orwhere('id' , $buscar);
    }

}
