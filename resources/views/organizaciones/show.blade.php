@extends('template.plantilla')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('menu')

@include('template.menu')

@endsection

@section('contenido')

    <h1>Organización: {{$organizacion->nombre}}</h1>

    <div id="chart-container"></div>
    <div class="border-danger" style="width:100%; height:900px;" id="orgchart"/>


@endsection

@section('script')

<script>

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
                let data = leerDepartamentos(datos);

                setTimeout(() => {
                    var chart = new OrgChart(document.getElementById("orgchart"), {
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
                }, 3000);



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
