@extends('plantilla.plantilla',['sidebar'=>10])

@section('titulo', 'Inicio')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>    
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe solicitud en el sistema')</script>
  @endif
@endsection

@section('contenido')
<div class="container row">
<ul class="navbar-nav ml-auto">
  <li class="nav-item dropdown">
    
  </li>
</ul>
</div>


<div class="row">
    <h2 class="m-2">VISTA DE INFORMÁTICA</h2>
    <div class="col-md-12">
        <div class="card card-primary card-outline"> <!-- Donut chart -->
            <div class="card-header">
            <h3 class="card-title">
                <i class="far fa-chart-bar"></i>
                Listado de usuarios
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
              <div class="row my-3">
              <div class="col col-md-2 offset-10">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                  Crear usuario
                </button>
                </div>
              </div>
            <table class="table table-sm table-bordered table-striped">
                <thead>
                  <th>Nombre</th>
                  <th>Username</th>
                  <th>Rol</th>
                  <th>Creado</th>
                  <th>Estado</th>
                  <th></th>
                </thead>
                @foreach($usuarios as $f)
                <tr>
                  <td>{{$f->name}}</td>
                  <td>{{$f->username}}</td>
                  <td>{{$f->rol}}</td>
                  <td>{{date('d/m/Y h:m', strtotime($f->created_at))}}</td>
                  <td>
                  @if($f->activo)                  
                    <span class="badge badge-success">Activo</span>
                  @else
                    <span class="badge badge-danger">Inactivo</span>
                  @endif
                  <td>
                  @if($f->activo)                  
                  <a href="{{route('usuario.deshabilitar', $f->id)}}" type="button" class="btn btn-secondary btn-xs">Deshabilitar</a>
                  @else
                  <a href="{{route('usuario.habilitar', $f->id)}}" type="button" class="btn btn-primary btn-xs">Habilitar</a>
                  @endif
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
        </div>
        <!-- /.donut chart -->
    </div>

      <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear un nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
        
      <form method="POST" action="{{route('usuario.crear')}}"  enctype="multipart/form-data">
      @csrf 
      <div class="modal-body">        
          <div class="form-row">   
              <div class="form-group">
                <label for="exampleFormControlInput1">Nombre</label>
                <input type="text" class="form-control" name="name">
              </div>
              <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="form-control" name="username">
              </div>
              <div class="form-group">
                <label for="">Clave</label>
                <input type="password" class="form-control" name="clave">
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Rol</label>
                <select class="form-control" name="rol" >
                  @foreach($roles as $r)
                  <option value="{{$r->id}}">{{$r->nombre}}</option>
                  @endforeach
                </select>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div> 


</div>
    
    
@endsection

@section('page_script')
<!-- page script -->
<script>
   
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

<script>
     /*
     * DONUT CHART
     * -----------
     */

    var donutData1 = [
      {
        label: 'Aprobados',
        data : $('#aprobados').val(),
        color: '#b36af7'
      },
      {
        label: 'No aprobados',
        data : $('#no_aprobados').val(),
        color: '#f5ee67'
      }
    ]

    var donutData2 = [
      {
        label: 'Revisados',
        data : $('#revisados').val(),
        color: '#53ed58'
      },
      {
        label: 'No revisados',
        data : $('#no_revisados').val(),
        color: '#88cfc5'
      },
      {
        label: 'Rechazados',
        data : $('#rechazados').val(),
        color: '#f28f74'
      }
    ]

    $.plot('#donut-chart1', donutData1, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.4,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    })

    /*
     * END DONUT CHART
     */

    /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #000; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }

  //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Revisados', 
          'No revisados',
          'Rechazados', 
      ],
      datasets: [
        {
          data: [$('#revisados').val(),$('#no_revisados').val(),$('#rechazados').val()],
          backgroundColor : ['#53ed58', '#88cfc5', '#f28f74'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

</script>

@endsection

