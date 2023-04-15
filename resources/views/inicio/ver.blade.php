@extends('plantilla.plantilla',['sidebar'=>10])

@section('titulo', 'Ver Certificación')

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
    <h2 class="m-2">Detalle de certifiación</h2>
    <div class="col-md-12">
        <div class="card card-primary card-outline"> <!-- Donut chart -->
            <div class="card-header">
            <h3 class="card-title">
                <i class="far fa-chart-eye"></i>
                
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
            </div>
            <div class="card-body"> 
              <div class="row mb-3">
                <div class="col col-md-3">
                </div>
                <div class="col col-md-2 offset-7">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                  APROBAR
                </button>
                </div>
              </div>  

              <div class="row">
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted"># Certificación</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$certi->numero}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted"># Expediente</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$certi->no_expediente}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Licencia</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$certi->no_licencia}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Propietario</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$certi->nombre_propietario}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Fecha Extensión</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$certi->fecha_extension}}</span>
                    </div>
                  </div>
                </div>
              </div>

            <div class="row m-3" style="font-size: 1.3em;">
              <div class="col col-sm-12">
                <b>Dirección inmueble: </b>{{$certi->direccion_inmueble}}
              </div>
              <div class="col col-sm-4">
                <b>Fecha extensión: </b>{{$certi->fecha_extension}}
              </div>
              <div class="col col-sm-4">
                <b>Fecha vencimiento: </b>{{$certi->fecha_vencimiento}}
              </div>
              <div class="col col-sm-4">
                <b>Fecha pago: </b>{{$certi->fecha_pago_licencia}}
              </div>
              <div class="col col-sm-6">
                <b>Autorización: </b>{{$certi->autorizacion_construccion}}
              </div>
              <div class="col col-sm-6">
                <b>Area autorizada: </b>{{$certi->area_construccion_autorizada}}
              </div>
              <div class="col col-sm-3">
                <b>Niveles: </b>{{$certi->cantidad_niveles}}
              </div>
              <div class="col col-sm-6">
                <b>Código inmueble: </b>{{$certi->codigo_inmueble}}
              </div>
              <div class="col col-sm-3">
                <b>Muro perimetral: </b>{{$certi->m_cuadrados_muro_perimetral}} m2
              </div>
              <div class="col col-sm-4">
                <b>Costo obra: </b>Q. {{$certi->costo_obra}}
              </div>
              <div class="col col-sm-4">
                <b>Tasa alineación: </b>{{$certi->tasa_alineacion}}
              </div>
              <div class="col col-sm-4">
              </div>
              <div class="col col-sm-4">
                <b>Factura Licencia: </b>{{$certi->factura_tesoreria_licencia}}
              </div>
              <div class="col col-sm-4">
                <b>Factura Uso suelo: </b>{{$certi->factura_tesoreria_uso_suelo}}
              </div>
              <div class="col col-sm-4">
                <b>Factura Certificación: </b>{{$certi->factura_tesoreria_certificacion}}
              </div>
            </div>          
          </div>
        </div>

    </div>
        


</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aprobar certificación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div class="modal-body">        
          <div class="form-row">     
            <form method="POST" action="{{route('certi.subir_archivo')}}"  enctype="multipart/form-data">
            @csrf 
              <div class="input-group">
                <div class="">
                  <input type="file" name="file">
                </div>
                <input type="hidden" name="tipo" value=1>
                <div class="input-group-append ml-3">
                  <button class="btn btn-outline-warning" type="submit">Guardar</button>
                </div>
              </div>
            </form>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

    
    
@endsection

@section('page_script')
<!-- page script -->
<script>

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
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


@endsection

