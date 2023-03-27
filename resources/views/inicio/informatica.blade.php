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
    
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      <a href="{{route('inicio.index', ['year'=>2020, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2020</a>
      <a href="{{route('inicio.index', ['year'=>2021, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2021</a>
      <a href="{{route('inicio.index', ['year'=>2021, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2021</a>
      <a href="{{route('inicio.index', ['year'=>2022, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2022</a>
      <a href="{{route('inicio.index', ['year'=>2022, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2022</a>
      <a href="{{route('inicio.index', ['year'=>2023, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2023</a>
    </div>
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
                Tabla
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
            <div id="donut-chart1" style="height: 300px;"></div>
            </div>
        </div>
        <!-- /.donut chart -->
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

