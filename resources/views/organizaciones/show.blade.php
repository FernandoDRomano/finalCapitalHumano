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

@endsection

@section('script')

<script>

/*

(function($) {
  $(function() {
   var ds = {
     'name': 'Fernando',
     'title': 'Presidente',
     'children': [
       { 'name': 'Bo Miao', 'title': 'department manager' ,
       'children': [
           { 'name': 'Tie Hua', 'title': 'senior engineer' },
           { 'name': 'Hei Hei', 'title': 'senior engineer',
             'children': [
               { 'name': 'Pang Pang', 'title': 'engineer' },
               { 'name': 'Xiang Xiang', 'title': 'UE engineer' }
             ]
            }
          ]
       },
       { 'name': 'Su Miao', 'title': 'department manager',
         'children': [
           { 'name': 'Tie Hua', 'title': 'senior engineer' },
           { 'name': 'Hei Hei', 'title': 'senior engineer',
             'children': [
               { 'name': 'Pang Pang', 'title': 'engineer' },
               { 'name': 'Xiang Xiang', 'title': 'UE engineer',
               'children': [
                    { 'name': 'Pang Pang', 'title': 'engineer' },
                    { 'name': 'Xiang Xiang', 'title': 'UE engineer' }
                    ]
               }
             ]
            }
          ]
        },
        { 'name': 'Hong Miao', 'title': 'department manager' },
        { 'name': 'Chun Miao', 'title': 'department manager' }
      ]
    };

    var oc = $('#chart-container').orgchart({
      'data' : ds,
      'nodeContent': 'title'
    });

  });
})(jQuery);


*/

</script>

@endsection
