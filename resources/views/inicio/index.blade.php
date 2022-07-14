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
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Semestre @php echo $semestre; @endphp - Año @php echo $year; @endphp
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      <a href="{{route('inicio.index', ['year'=>2020, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2020</a>
      <a href="{{route('inicio.index', ['year'=>2021, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2021</a>
      <a href="{{route('inicio.index', ['year'=>2021, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2021</a>
      <a href="{{route('inicio.index', ['year'=>2022, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2022</a>
      <a href="{{route('inicio.index', ['year'=>2022, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2022</a>
    </div>
  </li>
</ul>
</div>


<!-- Variables -->
<input type="hidden" value="{{$aprobados}}" id="aprobados">
<input type="hidden" value="{{$no_aprobados}}" id="no_aprobados">
<input type="hidden" value="{{$revisados}}" id="revisados">
<input type="hidden" value="{{$no_revisados}}" id="no_revisados">
<input type="hidden" value="{{$rechazados}}" id="rechazados">

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline"> <!-- Donut chart -->
            <div class="card-header">
            <h3 class="card-title">
                <i class="far fa-chart-bar"></i>
                Solicitudes de práctica final Semestre @php echo $semestre; @endphp - Año @php echo $year; @endphp
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
            <div id="donut-chart1" style="height: 300px;"></div>
            </div>
        </div>
        <!-- /.donut chart -->
    </div>
        
    <div class="col-md-6">  
        <!-- DONUT CHART -->
        <div class="card card-danger">
            <div class="card-header">
            <h3 class="card-title">Solicitudes aprobadas Semestre @php echo $semestre; @endphp - Año @php echo $year; @endphp</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
            </div>
            <div class="card-body">
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <div class="col-md-12">
      <div class="card card-success card-outline"> 
          <div class="card-header">
          <h3 class="card-title">
              <i class="far fa-chart-bar"></i>
              Datos generales Semestre @php echo $semestre; @endphp - Año @php echo $year; @endphp
          </h3>
          <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
              </button>
          </div>
          </div>
          <div class="card-body">
          <table class="table table-bordered">
          <thead>
            <th>Registro</th>
            <th>Estudiante</th>
            <th>Horas</th>
            <th>Tipo</th>
            <th>Revisión 1</th>
            <th>Revisión 2</th>
            <th>Revisión 3</th>
            <th>Revisión 4</th>
          </thead>
          <tbody>
          @foreach($estudiantes as $e)
          <tr>
            <td>{{$e['registro']}}</td>
            <td>{{$e['nombre']}} {{$e['apellido']}}</td>
            <td> 
              @php $cont =0; @endphp
              @foreach($revisiones as $r)
                @if($e['bitacora_id']==$r['bitacora_id'])
                  @php $cont += $r['horas']; @endphp
                @endif
              @endforeach
              {{$cont}}
            </td>
            <td>@if($e->tipo == 1)                                
            <span class="badge bg-lightblue">Docente</span>                                
            @elseif($e->tipo == 2)
            <span class="badge bg-gray">Investigación</span>  
            @else
            <span class="badge bg-navy">Aplicada</span>  
            @endif</td>
            @foreach($revisiones as $r)
              @php $fecha ='S/F'; $cont =1; @endphp
              @if($e['bitacora_id']==$r['bitacora_id'])
                @php $fecha = date('d-m-Y', strtotime($r['fecha'])); @endphp
                <td>{{$fecha}}</td>               
              @endif              
            @endforeach
          </tr>
          @endforeach
          </tbody>
          </table>
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

