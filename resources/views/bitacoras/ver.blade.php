@extends('plantilla.plantilla',['sidebar'=>62])

@section('titulo', 'Ver bitácora')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.index')}}">Bitácora</a></li>
    <li class="breadcrumb-item active">Editar bitácora</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe una carrera con ese código.')</script>
  @endif  
@endsection

@section('contenido')
<div class="card card-primary card-outline">
        <div class="card-header">
        @if($bitacora->semestre==1) @php $semestre='Primer semestre'; @endphp @else @php $semestre='Segundo semestre'; @endphp @endif
        <h4 class="">
            Ver bitácora - {{$semestre}} - {{$bitacora->year}}
        </h4>
        </div>
        <div class="card-body">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <h4>Horas acumuladas: {{$bitacora->horas}}</h4>
            </div>
            <div class="col-md-3 col-sm-12">
                <a class="btn btn-block btn-success btn-sm" href="{{route('bitacora.crear_folio', $bitacora->id)}}">Agregar folio</a>
            </div>
        </div>
        <h4>Folios</h4>    
          <div class="col-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title">Folios</h3></li>
                    @php $activo='active'; @endphp
                    @foreach ($folios as $f)
                    <li class="nav-item">
                    <a class="nav-link {{$activo}}" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-{{$f->id}}" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">#{{$f->numero}}</a>
                    </li>    
                    @php $activo=''; @endphp
                    @endforeach
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    @php $activo='show active'; @endphp
                    @foreach ($folios as $f)
                    <div class="tab-pane fade {{$activo}}" id="custom-tabs-two-{{$f->id}}" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                        <div class="row">
                            <div class="col-12 col-sm-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Fecha inicial</span>
                                <span class="info-box-number text-center text-muted mb-0">{{date('d-m-Y', strtotime($f->fecha_inicial))}}</span>
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-sm-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Fecha final</span>
                                <span class="info-box-number text-center text-muted mb-0">{{date('d-m-Y', strtotime($f->fecha_final))}}</span>
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-sm-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Horas </span>
                                <span class="info-box-number text-center text-muted mb-0">{{$f->horas}}<span>
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-sm-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Revisado </span>
                                <span class="info-box-number text-center text-muted mb-0">
                                @if($f->revisado) <span class="badge bg-success">SI</span> @else <span class="badge bg-danger">NO</span> @endif
                                <span>
                                </div>
                            </div>
                            </div>
                        </div> 
                        <div class="row">
                            <h4>Descripción</h4>
                            <div class="post">                        
                            <p> {{$f->descripcion}} </p>                       
                            </div>
                        </div>     
                    </div>
                    @php $activo=''; @endphp
                    @endforeach  
                </div>
              </div>
              <!-- /.card -->
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
@endsection


