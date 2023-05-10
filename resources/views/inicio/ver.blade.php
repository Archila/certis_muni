@extends('plantilla.plantilla',['sidebar'=>10])

@section('titulo', 'Ver Certificación')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('inicio.index')}}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('certi.index', $certi->id_paquete)}}">Certificaciones</a></li>
    <li class="breadcrumb-item active" aria-current="page">Detalle</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe solicitud en el sistema')</script>
  @endif
@endsection

@section('contenido')


<div class="row">
    <h2 class="m-2">Detalle de certificación</h2>
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
                  @if($certi->estado == 1)
                  <h3>ESTADO: <span class="badge badge-success">APROBADA</span></h3>
                  @elseif($certi->estado == 2)
                  <h3>ESTADO: <span class="badge badge-danger">RECHAZADA</span></h3>
                  @else
                  <h3>ESTADO: <span class="badge badge-warning">NO APROBADA</span></h3>
                  @endif
                </div>
                
                <div class="col col-md-2 offset-5">
                @if($certi->estado == 0 && $user->rol->id ==1)
                  <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#exampleModal">
                    APROBAR
                  </button>
                @endif
                </div>
                <div class="col col-md-2">
                  <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rechazarModal">
                    RECHAZAR
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
                      <span class="info-box-text text-center text-muted">Razonamiento</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$certi->razonamiento}}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Fecha Vencimiento</span>
                      <span class="info-box-number text-center mb-0 text-danger">{{date('d/m/Y', strtotime($certi->fecha_vencimiento))}}</span>
                    </div>
                  </div>
                </div>
              </div>

            <div class="row m-3" style="font-size: 1.3em;">
              <div class="col col-sm-12">
                <b>Propietario: </b>{{$certi->nombre_propietario}}
              </div>
              <div class="col col-sm-12">
                <b>Código inmueble: </b>{{$certi->codigo_inmueble}}
              </div>
              <div class="col col-sm-12">
                <b>Dirección inmueble: </b>{{$certi->direccion_inmueble}}
              </div>
              <div class="col col-sm-12">
                <b>Zona: </b>{{$certi->zona}}
              </div>
              <div class="col col-sm-4">
                <b>Fecha extensión: </b>{{date('d/m/Y', strtotime($certi->fecha_extension))}}
              </div>
              <div class="col col-sm-4">
                <b>Fecha vencimiento: </b>{{date('d/m/Y', strtotime($certi->fecha_vencimiento))}}
              </div>           
              <div class="col col-sm-4">
                <b>Área autorizada: </b>{{$certi->area_construccion_autorizada}} (m2)
              </div>            
              <div class="col col-sm-6">
                <b>Destino autorizado: </b>{{$certi->destino_autorizado}}
              </div>
              <div class="col col-sm-2">
                <b>Niveles: </b>{{$certi->cantidad_niveles}}
              </div>
              <div class="col col-sm-3">
                <b>Costo obra: </b>{{$certi->costo_obra}}
              </div>         
              <div class="col col-sm-6">
                <b>Unidades funcionales existentes: </b>{{$certi->unidades_funcionales_existentes}}
              </div>
              <div class="col col-sm-6">
                <b>Unidades funcionales autorizadas: </b>{{$certi->unidades_funcionales_autorizadas}}
              </div>
            </div>          
          </div>
        </div>

        <p>{{$certi_min}} - {{$certi_max}}</p>

        <div class="row">
          <div class="col offset-md-10 col-md-2">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                @if($certi_min < $certi->id)
                <li class="page-item"><a class="page-link" href="{{route('certi.ver', $certi->id-1)}}">ANTERIOR</a></li>
                @endif
                @if($certi_max > $certi->id)
                <li class="page-item"><a class="page-link" href="{{route('certi.ver', $certi->id+1)}}">SIGUIENTE</a></li>
                @endif
              </ul>
            </nav>
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
            <form method="POST" action="{{route('certi.aprobar')}}"  enctype="multipart/form-data">
            @csrf 
            <div class="row">
            <input type="hidden" name="id" value="{{$certi->id}}">              
              <div class="col col-sm-12">
                <label for="exampleFormControlTextarea1">Observaciones</label>
                <textarea class="form-control" name="observaciones" rows="6"></textarea>
              </div>
              <div class="col offset-lg-2 col-lg-8 mt-3">
              <button class="btn btn-success btn-block" type="submit">Aprobar</button>
              </div>
            </div>
              
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rechazarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rechazar certificación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <form method="POST" action="{{route('certi.rechazar')}}"  enctype="multipart/form-data">
      @csrf 
        <div class="modal-body">  
            <div class="row">
            <input type="hidden" name="id" value="{{$certi->id}}">              
              <div class="col col-sm-12">
                <div class="alert alert-danger">Está seguro de rechazar esta certificación? <b>Esta acción no se puede deshacer</b></div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger" >Rechazar</button>
        </div>              
      </form>
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

