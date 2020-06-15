@extends('plantilla.plantilla',['sidebar'=>41])

@section('titulo', 'Editar empresa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('empresa.index')}}">Empresas</a></li>
    <li class="breadcrumb-item active">{{$empresa->nombre}}</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe empresa con ese nombre')</script>
  @endif  
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Detalle: {{$empresa->nombre}}</h3> 
  </div>
  <div class="card-body">

    
  <form class="needs-validation" method="POST" novalidate >   
    
    <div class="form-row">
      <div class="col-md-5 mb-3">
        <label for="validationCustom03">Nombre de la empresa</label>
        <input type="text" class="form-control" id="validationCustom03"  name="nombre" value="{{$empresa->nombre}}" disabled>
        
      </div>    
      <div class="col-md-7 mb-3">
        <label for="validationCustom04">Direccion</label>
        <input type="text" class="form-control" id="validationCustom04" required name="direccion" value="{{$empresa->direccion}}" disabled>
        
      </div>
    </div>

    <div class="form-row">
      <div class="col-md-3 mb-3">
        <label for="validationCustom05">Alias</label>
        <input type="text" class="form-control" id="validationCustom05" name="alias" value="{{$empresa->alias}}" disabled>       
      </div>    
      <div class="col-md-3 mb-3">
        <label for="validationCustom06">Correo</label>
        <input type="email" class="form-control" id="validationCustom06" required name="correo" value="{{$empresa->correo}}" disabled>
        
      </div>
      <div class="col-md-2 mb-3">
        <label for="validationCustom07">Teléfono</label>
        <input type="text" class="form-control" id="validationCustom07" minlength="8" required name="telefono" value="{{$empresa->telefono}}" disabled>
        
      </div>
      <div class="col-md-4">
          <table class="table table-sm table-bordered table-hover">
              <tr>
                  <th> Público</th>
                  <td>
                  @if($empresa->publico==1) 
                    <span class="badge bg-success">SI</span>  
                    @else
                    <span class="badge bg-danger">NO</span>  
                    @endif
                  </td>
              </tr>
              <tr>
                  <th> Validado</th>
                  <td>
                    @if($empresa->valido==1) 
                    <span class="badge bg-success">SI</span>  
                    @else
                    <span class="badge bg-danger">NO</span>  
                    @endif
                  </td>
              </tr>
              <tr>
                  <th> Calificación</th>
                  <td>
                        @if($empresa->calificacion=="Bien")
                    <span class="badge bg-success">BIEN</span>                    
                    @endif
                    @if($empresa->calificacion=="Regular")
                    <span class="badge bg-warning">REGULAR</span>    
                    @endif                
                    @if($empresa->calificacion=="Mala")
                    <span class="badge bg-danger">MALA</span>
                    @endif      
                  </td>
              </tr>
          </table>
      </div>      
    </div>

    <div class="form-row">
      <div class="col-md-3 mb-3">
        <label for="validationCustom08">Persona de contacto</label>
        <input type="text" class="form-control" id="validationCustom08" name="contacto" value="{{$empresa->activo}}" disabled>       
      </div>    
      <div class="col-md-2 mb-3">
        <label for="validationCustom09">Teléfono contacto</label>
        <input type="text" class="form-control" id="validationCustom09" name="tel_contacto" value="{{$empresa->tel_contacto}}" disabled>
        
      </div>
      <div class="col-md-3 mb-3">
        <label for="validationCustom10">Correo contacto</label>
        <input type="email" class="form-control" id="validationCustom10" name="correo_contacto" value="{{$empresa->correo_contacto}}" disabled>
        
      </div>
      <div class="col-md-4 mb-3">
        <label for="select_tipo">Tipo empresa</label>                  
        <input type="text" class="form-control" id="validationCustom09" name="tipo" value="{{$empresa->tipo}}" disabled>
      </div>
    </div>

    <div class="float-sm-right">
    <a class="btn btn-warning" href="{{route('empresa.editar', $empresa->empresa_id)}}" >Editar</a>
      <a class="btn btn-secondary" href="{{route('empresa.index')}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>
@endsection

@section('page_script')
<!-- page script -->
<script>
  $(function () {    
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
  })
</script>
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
