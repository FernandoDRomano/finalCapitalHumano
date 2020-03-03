@extends('template.plantilla')

@section('menu')

<li class="nav-item">
    <a href="{{url('organizaciones')}}" class="nav-link text-white">
        <i class="nav-icon fas fa-building"></i>
        <p>
          Organizaciones
        </p>
    </a>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link text-white">
        <i class="fas fa-layer-group nav-icon"></i>
      <p>
        Niveles
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{url('nivelesDepartamentales')}}" class="nav-link text-white">
            <i class="fas fa-boxes nav-icon"></i>
          <p>Nivel de Departamentos</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('nivelesPuestos')}}" class="nav-link text-white">
            <i class="fas fa-sort-amount-up-alt nav-icon"></i>
            <p>Nivel de Puestos</p>
        </a>
      </li>
    </ul>
</li>

@endsection

@section('contenido')

<h1 class="text-center display-4 text-dark font-weight-bold">Final de Gestión de Capital Humano</h1>

<section id="team">
    <div class="container my-3 py-5 text-center">

        <div class="row mb-5 pb-3">
            <div class="col mb-5">
                <h1 class="text-dark">Nuestro Equipo</h1>
            </div>
        </div>

        <div class="row my-5">

            <div class="col-md-6 col-lg-3 my-5 py-5 my-md-5 py-md-5 my-lg-0 py-lg-0">
                <div class="card shadow">
                    <div class="imagen d-flex justify-content-center">
                        <img src="{{asset('imagenes/daniel.jpeg')}}" class="img-fluid"
                        style="width: 180px;
                        height: 180px;
                        border-radius: 50%;
                        margin-top: -90px;">
                    </div>
                    <div class="card-body text-dark text-center">
                        <h3 class="card-title text-center font-weight-bold">Coñequir Daniel Jorge Luis </h3>
                        <p class="card-text text-left font-weight-bold">Legago: 34769</p>
                        <a href="https://www.facebook.com/profile.php?id=100008141859795" target="_blank" class="px-1" style="font-size: 30px; color:#4267B2;"><i class="fab fa-facebook"></i></a>
                        <a href="#" target="_blank" class="px-1" style="font-size: 30px; color:black;"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 my-5 py-5 my-md-5 py-md-5 my-lg-0 py-lg-0 ">
                <div class="card shadow">
                    <div class="imagen d-flex justify-content-center">
                        <img src="{{asset('imagenes/fernando.jpg')}}" class="img-fluid"
                        style="width: 180px;
                        height: 180px;
                        border-radius: 50%;
                        margin-top: -90px;">
                    </div>
                    <div class="card-body text-dark text-center">
                        <h3 class="card-title text-center font-weight-bold">Romano Fernando Daniel</h3>
                        <p class="card-text text-left font-weight-bold">Legago: 35852</p>
                        <a href="https://www.facebook.com/fernandodaniel.romano" target="_blank" class="px-1" style="font-size: 30px; color:#4267B2;"><i class="fab fa-facebook"></i></a>
                        <a href="https://github.com/fer35548988" target="_blank" class="px-1" style="font-size: 30px; color:black;"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 my-5 py-5 my-md-5 py-md-5 my-lg-0 py-lg-0">
                <div class="card shadow">
                    <div class="imagen d-flex justify-content-center">
                        <img src="{{asset('imagenes/anabel.jpeg')}}" class="img-fluid"
                        style="width: 180px;
                        height: 180px;
                        border-radius: 50%;
                        margin-top: -90px;">
                    </div>
                    <div class="card-body text-dark text-center">
                        <h3 class="card-title text-center font-weight-bold">Romero Stefania Anabel</h3>
                        <p class="card-text text-left font-weight-bold">Legago: 34785</p>
                        <a href="https://www.facebook.com/anabel.romero3" target="_blank" class="px-1" style="font-size: 30px; color:#4267B2;"><i class="fab fa-facebook"></i></a>
                        <a href="#" target="_blank" class="px-1" style="font-size: 30px; color:black;"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 my-5 py-5 my-md-5 py-md-5 my-lg-0 py-lg-0">
                <div class="card shadow">
                    <div class="imagen d-flex justify-content-center">
                        <img src="{{asset('imagenes/maxi.jpeg')}}" class="img-fluid"
                        style="width: 180px;
                        height: 180px;
                        border-radius: 50%;
                        margin-top: -90px;">
                    </div>
                    <div class="card-body text-dark text-center">
                        <h3 class="card-title text-center font-weight-bold">Ruiz Jorge Maximiliano</h3>
                        <p class="card-text text-left font-weight-bold">Legago: 34546</p>
                        <a href="https://www.facebook.com/maxi.ruiz.79" target="_blank" class="px-1" style="font-size: 30px; color:#4267B2;"><i class="fab fa-facebook"></i></a>
                        <a href="#" target="_blank" class="px-1" style="font-size: 30px; color:black;"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection

@section('script')


@endsection
