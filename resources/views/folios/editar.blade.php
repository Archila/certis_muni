@extends('plantilla.plantilla',['sidebar'=>65])

@section('titulo', 'Editar folio')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('practica.index')}}">Práctica</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.ver', $bitacora->id)}}">{{$bitacora->nombre}}</a></li>
    <li class="breadcrumb-item active">Editar folio</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe folio con ese número')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Crear nuevo folio</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('folio.actualizar', $folio->id)}}" novalidate>  
    @method('PUT')   
    @csrf 
    <div class="form-row">
      <div class="col-md-2 mb-3">        
      <input type="hidden" name="id" value="{{$folio->id}}">
        <label for="validationCustom03">Número</label>
        <select id="validationCustom07" class="form-control" required name="numero">
            <option disabled>Seleccione un número</option>
            @for ($i = 1; $i < 21 ; $i++)
              @php $mostrar = true; @endphp
              @foreach($folios as $f)              
                @if($f->numero == $i && $f->numero != $folio->numero)
                @php $mostrar=false; @endphp
                @endif
              @endforeach  
              @if($mostrar)
                @if($folio->numero == $i)
                <option value="{{ $i }}" selected>{{ $i }}</option>
                @else
                <option value="{{ $i }}">{{ $i }}</option>
                @endif
              @endif            
            @endfor
        </select>
        <div class="invalid-feedback">
          Por favor seleccione un número de folio
        </div>      
      </div>      
      <div class="col-md-3 mb-3">
        <label for="validationCustom05">Fecha inicial</label>
        <input type="date" class="form-control" id="validationCustom05" required name="fecha_inicial" value="{{$folio->fecha_inicial}}">
        <div class="invalid-feedback">
          Por favor ingrese fecha inicial de folio
        </div>   
      </div>    
      <div class="col-md-3 mb-3">
        <label for="validationCustom06">Fecha final</label>
        <input type="date" class="form-control" id="validationCustom06" required name="fecha_final" value="{{$folio->fecha_final}}">
        <div class="invalid-feedback">
          Por favor ingrese fecha final de folio
        </div>   
      </div>  
      <div class="col-md-3 mb-3">
        <label for="validationCustom06">Horas</label>
        <input type="text" class="form-control" id="validationCustom06" required name="horas" value="{{$folio->horas}}" >
        <div class="invalid-feedback">
          Por favor ingrese cantidad de horas para el folio
        </div>   
      </div>  
    </div>
    <div class="form-row">
    <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Descripción del folio
              </h3>
              <!-- tools box -->
              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fas fa-minus"></i></button>                
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body pad">
              <div class="">
                <textarea class="form-control" id="descripcion" name="descripcion" required
                placeholder="Ingrese las actividades realizadas en su práctica"
                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding:10px;">{{$folio->descripcion}}</textarea>   
                <div class="invalid-feedback">
                  Por favor ingrese descripción del folio.
                </div>   
              </div>              
            </div>
            <div class="card-body pad">
            <h4>Observaciones</h4>
              <div class="mb-3">
                <textarea class="form-control" id="observaciones" name="observaciones" required
                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding:10px;">{{$folio->observaciones}}</textarea> 
              </div>              
            </div>
          </div>
        </div>
        <!-- /.col-->
    </div>
    <div class="float-sm-right">
      <button class="btn btn-success" type="submit">Editar</button>
      <a class="btn btn-secondary" href="{{url()->previous()}}" role="cancelar">Regresar</a>
    </div>    
  </form>
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

