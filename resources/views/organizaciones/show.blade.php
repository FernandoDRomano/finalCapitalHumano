@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

@include('template.menu')

@endsection

@section('contenido')

    <h1 class="text-center display-4 text-dark font-weight-bold">Organización: {{$organizacion->nombre}}</h1>

    <div class="row mt-5 justify-content-center">

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                      <div class="inner">
                        <h3>{{$organizacion->departamentos->count()}}</h3>
                        <p>Departamentos Registrados</p>
                      </div>
                      <div class="icon">
                        <i class="nav-icon fas fa-sitemap"></i>
                      </div>
                      <a href="{{route('departamentos.index', ['id' => $organizacion->id])}}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                      <div class="inner">
                        <h3>{{$organizacion->puestosDeTrabajos->count()}}</h3>
                        <p>Puestos de Trabajos Registrados</p>
                      </div>
                      <div class="icon">
                        <i class="far fa-id-card nav-icon"></i>
                      </div>
                      <a href="{{route('puestosDeTrabajos.index', ['id' => $organizacion->id])}}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <h3 class="text-white">{{$organizacion->personas->count()}}</h3>
                        <p class="text-white">Personas Registradas</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-users"></i>
                      </div>
                      <a href="{{route('personas.index', ['id' => $organizacion->id])}}" class="small-box-footer"><span class="text-white">Más Información</span> <i class="fa fa-arrow-circle-right text-white"></i></a>
                    </div>
                </div>

    </div>

    <div class="row justify-content-center">
            <div class="spinner"></div>
    </div>

    <div class="row mt-5">
        <div class="col">
            <div class="border-danger" style="width:100%; height:800px;" id="orgchart"/>
        </div>
    </div>



@endsection

@section('script')

<script>

function mostrarSpinner(){
	const spinner = document.createElement('img');
	spinner.src = "{{asset('img/spinner.gif')}}";
	document.querySelector('.spinner').appendChild(spinner);
}

//Token
const token = document.querySelector("meta[name='csrf-token']").getAttribute('content');

window.onload = function() {

            const url = {{$organizacion->id}} + `/getHijos/`;
            //LLAMADA A FETCH
            fetch(url, {
                headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": token
                },
                method: 'get',
                credentials: "same-origin",
            })
            .then(response =>{
                console.log(response);
                return response.json();
            })
            .then(datos => {
                mostrarSpinner();
                let data = leerDepartamentos(datos);

                setTimeout(() => {
                    //BUSCO EL SPINNER PARA ELIMINARLO
			        const spinner = document.querySelector('.spinner img');
			        spinner.remove();
                    //GRAFICO EL ORGANIGRAMA
                    OrgChart.templates.ana.field_0 = '<text class="field_0"  style="font-size: 30px;" fill="#ffffff" x="125" y="30" text-anchor="middle">{val}</text>';

                    var chart = new OrgChart(document.getElementById("orgchart"), {
                        scaleInitial: OrgChart.match.height,
                        nodeBinding: {
                            field_0: "name"
                        },
                        template: "mila",
                        menu: {
                            pdf: { text: "Exportar PDF" },
                            png: { text: "Exportar PNG" },
                            svg: { text: "Exportar SVG" },
                        },
                        nodes: datos
                    });
                }, 4000);



            })
            .catch(error => {
                console.log(error);
            });

}


function leerDepartamentos(datos){


    for (let i = 0; i < datos.length; i++) {
        datos[i]['name'] = datos[i].nombre;
        delete datos[i].nombre;

        if(datos[i].depende_departamento_id){
            datos[i]['pid'] = datos[i].depende_departamento_id;
            delete datos[i].depende_departamento_id;
        }else{
            delete datos[i].depende_departamento_id;
        }


    }

    return JSON.stringify(datos);


}




</script>

@endsection
