<?php

use App\Asignacion;
use App\Departamento;
use App\NivelDepartamento;
use App\NivelPuesto;
use App\Organizacion;
use App\Persona;
use App\PuestoDeTrabajo;
use Illuminate\Database\Seeder;


class SistemaTableSeeder extends Seeder
{
    public function run()
    {
        //Creo los niveles Departamentales
        $nivel = new NivelDepartamento;
        $nivel->nombre = "Primer Nivel";
        $nivel->jerarquia = 1;
        $nivel->save();

        $nivel = new NivelDepartamento;
        $nivel->nombre = "Segundo Nivel";
        $nivel->jerarquia = 2;
        $nivel->save();

        $nivel = new NivelDepartamento;
        $nivel->nombre = "Tercer Nivel";
        $nivel->jerarquia = 3;
        $nivel->save();

        $nivel = new NivelDepartamento;
        $nivel->nombre = "Cuarto Nivel";
        $nivel->jerarquia = 4;
        $nivel->save();

        $nivel = new NivelDepartamento;
        $nivel->nombre = "Quinto Nivel";
        $nivel->jerarquia = 5;
        $nivel->save();

        //Nivel de los puestos de trabajos
        $nivelPuesto = new NivelPuesto;
        $nivelPuesto->nombre = "1N";
        $nivelPuesto->jerarquia = 1;
        $nivelPuesto->save();

        $nivelPuesto = new NivelPuesto;
        $nivelPuesto->nombre = "2N";
        $nivelPuesto->jerarquia = 2;
        $nivelPuesto->save();

        $nivelPuesto = new NivelPuesto;
        $nivelPuesto->nombre = "3N";
        $nivelPuesto->jerarquia = 3;
        $nivelPuesto->save();

        $nivelPuesto = new NivelPuesto;
        $nivelPuesto->nombre = "4N";
        $nivelPuesto->jerarquia = 4;
        $nivelPuesto->save();

        $nivelPuesto = new NivelPuesto;
        $nivelPuesto->nombre = "5N";
        $nivelPuesto->jerarquia = 5;
        $nivelPuesto->save();

        //Organizacion
        $organizacion = new Organizacion;
        $organizacion->nombre = "UTN FRT";
        $organizacion->save();

        $organizacion = new Organizacion;
        $organizacion->nombre = "Coca Cola";
        $organizacion->save();

        //Departamentos de las organizaciones
        $depto = new Departamento;
        $depto->nombre = "CEO de 4° Año";
        $depto->depende_departamento_id = null;
        $depto->nivel_departamento_id = 1;
        $depto->organizacion_id = 1;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Administración de Recursos";
        $depto->depende_departamento_id = 1;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 1;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Redes de Información";
        $depto->depende_departamento_id = 1;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 1;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Investigación Operativa";
        $depto->depende_departamento_id = 1;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 1;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Teoria de Control";
        $depto->depende_departamento_id = 1;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 1;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Simulación";
        $depto->depende_departamento_id = 1;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 1;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Legislación";
        $depto->depende_departamento_id = 1;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 1;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Ingenieria del Software";
        $depto->depende_departamento_id = 1;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 1;
        $depto->save();

        //Departamentos de la organizacion 2
        $depto = new Departamento;
        $depto->nombre = "Presidente";
        $depto->depende_departamento_id = null;
        $depto->nivel_departamento_id = 1;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Vicepresidente General";
        $depto->depende_departamento_id = 9;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Jefe de Producción";
        $depto->depende_departamento_id = 9;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Jefe Financiero";
        $depto->depende_departamento_id = 9;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Jefe de Marqueting";
        $depto->depende_departamento_id = 9;
        $depto->nivel_departamento_id = 2;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Gerente Industrial"; //14
        $depto->depende_departamento_id = 11;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Gerente de Ingenieria"; //15
        $depto->depende_departamento_id = 11;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Gerente de Calidad"; //16
        $depto->depende_departamento_id = 11;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Contador";
        $depto->depende_departamento_id = 12;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Tesorería";
        $depto->depende_departamento_id = 12;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Auditoría";
        $depto->depende_departamento_id = 12;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Contador";
        $depto->depende_departamento_id = 13;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Tesorería";
        $depto->depende_departamento_id = 13;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Auditoría";
        $depto->depende_departamento_id = 13;
        $depto->nivel_departamento_id = 3;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Inspector";
        $depto->depende_departamento_id = 14;
        $depto->nivel_departamento_id = 4;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Compras";
        $depto->depende_departamento_id = 15;
        $depto->nivel_departamento_id = 4;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Mantenimiento";
        $depto->depende_departamento_id = 15;
        $depto->nivel_departamento_id = 4;
        $depto->organizacion_id = 2;
        $depto->save();

        $depto = new Departamento;
        $depto->nombre = "Auxiliar de Calidad";
        $depto->depende_departamento_id = 16;
        $depto->nivel_departamento_id = 4;
        $depto->organizacion_id = 2;
        $depto->save();

        //Personas para la organizacion 1
        $persona = new Persona;
        $persona->nombre = "Fernando Daniel";
        $persona->apellido = "Romano";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1992/03/05";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Daniel Jorge Luis";
        $persona->apellido = "Coñequir";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1990/11/07";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Stefania Anabel";
        $persona->apellido = "Romero";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1992/06/22";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Jorge Maximiliano";
        $persona->apellido = "Ruiz";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1990/05/19";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Juan";
        $persona->apellido = "Torrez";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1980/01/01";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Pablo";
        $persona->apellido = "Figueroa";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1980/01/01";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Jose";
        $persona->apellido = "Nasrala";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1980/01/01";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Lucas";
        $persona->apellido = "Cordero";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1980/01/01";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Daniel";
        $persona->apellido = "Ibarra";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1980/01/01";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Cristina";
        $persona->apellido = "Rojas";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1980/01/01";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Javier";
        $persona->apellido = "Canto";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1980/01/01";
        $persona->organizacion_id = 1;
        $persona->save();

        $persona = new Persona;
        $persona->nombre = "Maria Eugenia";
        $persona->apellido = "Teri";
        $persona->dni = 35548988;
        $persona->direccion = "Casa 1";
        $persona->fechaNacimiento = "1980/01/01";
        $persona->organizacion_id = 1;
        $persona->save();

        //Puestos de Trabajos Administracion de recursos
        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Profesor";
        $puesto->nivel_puesto_id = 1;
        $puesto->departamento_id = 2;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "JTP";
        $puesto->nivel_puesto_id = 2;
        $puesto->departamento_id = 2;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Auxiliar";
        $puesto->nivel_puesto_id = 3;
        $puesto->departamento_id = 2;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Alumno";
        $puesto->nivel_puesto_id = 4;
        $puesto->departamento_id = 2;
        $puesto->save();

        //Puestos de Trabajos Simulacion
        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Profesor";
        $puesto->nivel_puesto_id = 1;
        $puesto->departamento_id = 6;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "JTP";
        $puesto->nivel_puesto_id = 2;
        $puesto->departamento_id = 6;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Auxiliar";
        $puesto->nivel_puesto_id = 3;
        $puesto->departamento_id = 6;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Alumno";
        $puesto->nivel_puesto_id = 4;
        $puesto->departamento_id = 6;
        $puesto->save();

        //Puestos de Trabajos Teoria de Control
        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Profesor";
        $puesto->nivel_puesto_id = 1;
        $puesto->departamento_id = 5;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "JTP";
        $puesto->nivel_puesto_id = 2;
        $puesto->departamento_id = 5;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Auxiliar";
        $puesto->nivel_puesto_id = 3;
        $puesto->departamento_id = 5;
        $puesto->save();

        $puesto = new PuestoDeTrabajo;
        $puesto->nombre = "Alumno";
        $puesto->nivel_puesto_id = 4;
        $puesto->departamento_id = 5;
        $puesto->save();

        //Asignaciones
        $asignacion = new Asignacion;
        $asignacion->persona_id = "Poner valor id";
        $asignacion->puesto_de_trabajo_id = "poner valor id";
        $asignacion->save();

    }
}
