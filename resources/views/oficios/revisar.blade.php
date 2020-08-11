@extends('plantilla.plantilla',['sidebar'=>65])

@section('css')
<style>       

    #vista_previa{
        font-size: 0.4em;
    }
        .encabezado::after {
            content: "";
            clear: both;
            display: table;
        }
        .encabezado{
            overflow:auto;
            margin-left: 1%;
            margin-right: 6%;
            
        }
        .linea-encabezado{
            margin-bottom: -0.1%; 
        }
        .encabezado_derecha{
            display: block;
            float: right;
            font-size: 11.5px;
            font-style: bold;
            width: 100%;
            text-align: right;
        }
        .destinatario{
            display: block;
            font-size: 12px;
            font-style: bold;
            margin: 1.8cm 0 0 1cm;
        }     
        .linea-destinatario{
            padding: -0.18cm 0;
            margin-bottom: -0.1%; 
        }
        .cuerpo{
            display: block;
            font-size: 12px;
            margin: 1cm 1cm 1.5cm 1cm;
            text-align: justify;
        }    
        .firma{
            display: block;
            font-size: 14px;
            margin: 0cm 1cm 0cm 0.8cm;            
            text-align: center;
        }   
        .firma p{
            padding: -0.5cm 1cm 0cm 0.8cm; 
            margin-bottom: -0.1%; 
        }
        .fin{
            display: block;
            font-size: 14px;
            margin: 1cm 1cm 0cm 0.8cm;
            text-align: justify;
        }   

    .content { 
        width: 100%; 
    }
    .content__left { 
        max-width: 370px;  
        min-width: 35px;  
        float: left; /* [1] */
        background-color: #fff; 
        padding: 0.2cm 0.5cm 0.1cm 0.2cm;
     }
    .content__middle { 
        overflow: auto; /* [2] */
        border: 1px solid;
        border-style: none none solid none;       
        margin: 0.2cm 0;      
    }
    .content__right {        
        max-width: 10px; 
        min-width: 5px; 
        float: right; /* [3] */
    }
    </style>
@endsection


@section('titulo', 'Prácticas finales')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('practica.index')}}">Prácticas finales</a></li>
    <li class="breadcrumb-item active">Revisión</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe solicitud en el sistema')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
    <div class="card-header">
        <h3>Revisión de solicitud de prácticas finales</h3> 
    </div>

    <div class="card-body">

        <dl class="row">
            <dd class="col-sm-12 mb-n1"> <b>Empresa: </b> {{$oficio->empresa}}</dd>
            <dd class="col-sm-6 "> <b>Dirección: </b> {{$oficio->direccion}}</dd>
            <dd class="col-sm-6 "> <b>Ubicación: </b> {{$oficio->ubicacion}}</dd>
            <dd class="col-sm-4 "> <b>Estudiante: </b> {{$oficio->estudiante}}</dd>
            <dd class="col-sm-3 "> <b>Carne: </b> {{$oficio->carne}}</dd>
            <dd class="col-sm-3 "> <b>Registro: </b> {{$oficio->registro}}</dd>       

            <dd class="col-sm-6 mb-n1"> <b>Destinatario: </b> {{$oficio->destinatario}}</dd>      
            <dd class="col-sm-6 mb-n1"> <b>Saludo: </b> {{$oficio->encabezado}}</dd>     
            @if($oficio->tipo == 1) 
            <dd class="col-sm-10 mb-n1"> <b>Curso: </b> {{$oficio->curso}}</dd>
            <dd class="col-sm-2 mb-n1"> <b>Código: </b> {{$oficio->codigo_curso}}</dd>
            @elseif($oficio->tipo == 2) 
            <dd class="col-sm-10 mb-n1"> <b>Tema o investigación: </b>"{{$oficio->curso}}"</dd>
            @else
            <dd class="col-sm-10 mb-n1"> <b>Puesto: </b>{{$oficio->puesto}}</dd>
            @endif
        </dl>                  

        <div class="row">
            <div class="col-md-6">
            <form method="POST" action="{{route('oficio.rechazar')}}" enctype="multipart/form-data">
            @csrf 
                <input type="hidden" value="{{$oficio->id}}" name="oficio_id">
                <input type="hidden" value="0" name="rechazado">
                <button type="submit" class="btn btn-info btn-sm btn-block">Aprobar inicio de prácticas finales</button>            
            </form>                  
            </div>
            <div class="col-md-6">
            <form method="POST" action="{{route('oficio.rechazar')}}" enctype="multipart/form-data">
            @csrf 
                <input type="hidden" value="{{$oficio->id}}" name="oficio_id">
                <input type="hidden" value="1" name="rechazado">
                <button type="submit" class="btn btn-danger btn-sm btn-block">Respuesta negativa, no aprobar prácticas finales.</button>            
            </form>      
            </div>
        </div> 
        <hr>

        <div class="row">
            
            <div class="col-md-6 pr-3" style="height:25em;"><!--Formulario-->
            <iframe src="http://localhost:8000/oficio/1/pdf" 
            width="100%" height="100%">

            This browser does not support PDFs. Please download the PDF to view it: Download PDF

            </iframe>
            </div>            
            <!--Formulario-->
            @if($oficio->ruta_pdf)
            <div class="col-md-6 pr-3" style="height:25em;"><!--Formulario-->
            <iframe src="{{route('oficio.respuesta', $oficio->id)}}" 
            width="100%" height="100%">

            This browser does not support PDFs. Please download the PDF to view it: Download PDF

            </iframe>
            </div>            
            @else
            <div class="col-md-6">
                <div class="callout callout-warning">
                  <h5> <i class="icon fas fa-exclamation-triangle"></i>No hay documento de respuesta subido por el estudiante.</h5>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Subir respuesta pdf
                </button>
                </div>
            </div>
            @endif            
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 offset-md-9 p-3">
        @if($oficio->ruta_pdf)
            <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#exampleModal">
            Cambiar respuesta pdf
            </button>
        @endif
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subir archivo pdf</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('practica.respuesta')}}" enctype="multipart/form-data">
        @csrf 
        <input type="hidden" name="oficio_id" value="{{$oficio->id}}">
            <div class="">
                <label for="exampleInputFile">Respuesta contraparte institucional</label>
                <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFileLang" lang="es" name="file">
                <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                </div>
            </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Subir archivo</button>
      </div>
      </form>
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

