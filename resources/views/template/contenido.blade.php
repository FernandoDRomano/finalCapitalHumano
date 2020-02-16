
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><strong><i class="fas fa-list"></i> <span class="mx-2 h4">Gestión de Organizaciones</span></strong></h3>
              <a type="button" class="btn btn-primary float-right" href="#" data-toggle="modal" data-target="#modalAgregar">
                <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
            </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive ">

                <div class="form-group row my-3 px-3">
                    <div class="col-md-6">
                        <form method="get" action="#">
                            <div class="input-group">
                                <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Buscar ...">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>


              <table class="table table-hover text-nowrap px-3">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="tag tag-success">Approved</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken.</td>
                    <td>
                        <a name="" id="" class="btn btn-warning text-white" href="#" role="button"  data-toggle="modal" data-target="#modalEditar"><i class="fas fa-edit"></i></a>
                        <a name="" id="" class="btn btn-danger text-white" href="#" role="button" data-toggle="modal" data-target="#modalEliminar"><i class="fas fa-trash-alt"></i></a>
                        <a name="" id="" class="btn btn-success text-white" href="#" role="button"><i class="fas fa-info-circle"></i></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td>219</td>
                    <td>Alexander Pierce</td>
                    <td>11-7-2014</td>
                    <td><span class="tag tag-warning">Pending</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken.</td>
                    <td><a name="" id="" class="btn btn-primary" href="#" role="button" data-toggle="modal" data-target="#modalEditar">Ver</a></td>
                  </tr>
                  <tr>
                    <td>657</td>
                    <td>Bob Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="tag tag-primary">Approved</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken.</td>
                    <td><a name="" id="" class="btn btn-primary" href="#" role="button" data-toggle="modal" data-target="#modalEliminar">Ver</a></td>
                  </tr>
                  <tr>
                    <td>175</td>
                    <td>Mike Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="tag tag-danger">Denied</span></td>
                    <td>Bacon ipsum dolor sit amet salami venison chicken.</td>
                    <td><a name="" id="" class="btn btn-primary" href="#" role="button">Ver</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->


  <!-- CONTENIDO PRINCIPAL DE LA PAGINA -->
