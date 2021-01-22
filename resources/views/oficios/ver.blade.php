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
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe solicitud en el sistema')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
    <div class="card-header">
        <h3>Solicitud de prácticas finales</h3> 
    </div>

    <div class="card-body">

        <div class="row">
            
            <div class="col-md-4 pr-3"><!--Formulario-->
                <form class="needs-validation" method="POST" action="{{route('oficio.actualizar', $oficio->id)}}" novalidate>    
                @method('PUT') 
                @csrf 
                <input type="hidden" value="{{$oficio->id}}" name="id">
                    <div class="form-row">
                        <div class="col-12 mb-2">
                            <label for="validationCustom03">Semestre</label>
                            <select id="validationCustom07" class="form-control form-control-sm" required name="semestre">
                                <option disabled>Seleccione un semestre</option>
                                @if($oficio->semestre == 1)
                                <option value="1" selected>Primer semestre</option>
                                <option value="2">Segundo semestre</option>
                                @else
                                <option value="1">Primer semestre</option>
                                <option value="2" selected>Segundo semestre</option>
                                @endif                            
                            </select>
                        </div>      
                        <div class="col-6 mb-2">
                            <label for="validationCustom05">Año</label>
                            <div class="input-group input-group">
                            <select id="validationCustom07" class="form-control form-control-sm" required name="year">
                                <option disabled>Seleccione un semestre</option>
                                @if($oficio->year == 2020)
                                <option value="2020" selected>2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                @elseif($oficio->year == 2021)
                                <option value="2020">2020</option>
                                <option value="2021" selected>2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                @elseif($oficio->year == 2022)
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022" selected>2022</option>
                                <option value="2023">2023</option>
                                @elseif($oficio->year == 2023)
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023 selected</option>
                                @endif                            
                            </select>             
                            </div>
                        </div>         
                        <div class="col-6 mb-2">
                            <label for="select_tipo">Tipo</label>
                            <div class="input-group input-group">
                            <select id="select_tipo" class="form-control form-control-sm" required name="tipo" onchange="tipoPractica()" >
                                <option disabled>Seleccione un tipo</option>
                                @if($oficio->tipo == 1)
                                <option value="1" selected>Docencia</option>
                                <option value="2">Investigación</option>
                                <option value="3">Aplicada</option>
                                @elseif($oficio->tipo == 2)
                                <option value="1">Docencia</option>
                                <option value="2" selected>Investigación</option>
                                <option value="3">Aplicada</option>
                                @else
                                <option value="1">Docencia</option>
                                <option value="2">Investigación</option>
                                <option value="3" selected>Aplicada</option>
                                @endif                            
                            </select>             
                            </div>
                        </div>     
                        <div class="col-12 mb-2">
                            <label for="empresa">Empresa</label>
                            <textarea class="form-control" id="empresa" name="empresa" required>{{$oficio->empresa}}</textarea>                                        
                        </div>   
                        <div class="col-md-12 ">
                            <label for="saludo">Dirección</label>
                            <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" required value="{{$oficio->direccion}}" >                             
                        </div>   
                        <div class="col-md-12 ">
                            <label for="saludo">Ubicación</label>
                            <input type="text" class="form-control form-control-sm" id="ubicacion" name="ubicacion" required value="{{$oficio->ubicacion}}" >                             
                        </div>    
                        <div class="col-md-12 ">
                            <label for="saludo">Saludo</label>
                            <input type="text" class="form-control form-control-sm" id="saludo" name="encabezado" required value="{{$oficio->encabezado}}" >                             
                        </div>   
                        <div class="col-md-12 ">
                            <label for="saludo">Destinatario</label>
                            <input type="text" class="form-control form-control-sm" id="destinatario" name="destinatario" required value="{{$oficio->destinatario}}">                          
                        </div>   
                    </div>
                    
                    <div id="div_docencia" class="my-3" style="display:none;">
                        <h6>Práctica docente</h6>
                        <div class="col-md-12 ">
                            <label for="curso">Curso</label>
                            <input type="text" class="form-control form-control-sm" id="curso" name="curso" required value="{{$oficio->curso}}" >                             
                        </div>   
                        <div class="col-md-12 ">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control form-control-sm" id="codigo" name="codigo" required value="{{$oficio->codigo_curso}}" >                             
                        </div>   
                        <div class="col-md-12 ">
                            <label for="fecha_docencia">Fecha solicitud</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_docencia" name="fecha_docencia" required value="{{$oficio->f_solicitud}}" >                             
                        </div> 
                    </div>

                    <div id="div_investigacion" class="my-3" style="display:none;">
                        <h6>Práctica en investigación</h6>
                        <div class="col-12 mb-2">
                            <label for="tema">Tema de investigación</label>
                            <textarea class="form-control" id="tema" name="tema" required>{{$oficio->curso}}</textarea>                                        
                        </div>   
                        <div class="col-md-12 ">
                            <label for="fecha_investigacion">Fecha solicitud</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_investigacion" name="fecha_investigacion" required value="{{$oficio->f_solicitud}}">                             
                        </div> 
                    </div>

                    <div id="div_aplicada"  class="my-3" style="display:none;">
                        <h6>Práctica aplicada</h6>
                        <div class="col-md-12 ">
                            <label for="puesto">Puesto</label>
                            <input type="text" class="form-control form-control-sm" id="puesto" name="puesto" required value="{{$oficio->puesto}}" >                             
                        </div>   
                        <div class="col-md-12 ">
                            <label for="profesion">Profesión del futuro encargado</label>
                            <input type="text" class="form-control form-control-sm" id="profesion" name="cargo_encargado" required value="{{$oficio->cargo_encargado}}" >                             
                        </div>   
                    </div>   
                    
                    <div class="col-12 my-1">
                    <button class="btn btn-success" type="submit">Guardar cambios</button>
                    <a class="btn btn-secondary" href="{{url()->previous()}}" role="cancelar">Regresar</a>
                    </div>    
                </form>            
            
                <div class="col-12 my-3">
                    <form method="POST" action="{{route('oficio.validar', $oficio->id)}}">
                    @csrf 
                        <input type="hidden" value="{{$oficio->id}}" name="id">
                        <button class="btn btn-info" type="submit" id="btn_validar">Validar oficio</button>
                    </form>
                </div>
            </div>
            
            <!--Formulario-->

            <div class="col-md-8 shadow bg-white rounded" id="vista_previa"><!--Vista previa-->

                <div id="carta_docencia" style="display:none;">
                    <div class="encabezado">
                        <div class="encabezado_derecha">
                        <br>
                            <p class="linea-encabezado">Of. {{$no_oficio}}</p>
                            <p class="linea-encabezado">Quetzaltenango, {{$fecha}}</p>
                        </div>        
                    </div>      

                    <div class="destinatario">
                        <p class="linea-destinatario">Docente</p>
                        <p class="linea-destinatario">{{$oficio->destinatario}}</p>
                        <p class="linea-destinatario">{{$oficio->empresa}}</p>
                        <p class="linea-destinatario">{{$oficio->direccion}}</p>
                        <p class="linea-destinatario">{{$oficio->ubicacion}}{{$punto}}</p>
                    </div>   

                    <div class="cuerpo">
                        <p>{{$oficio->encabezado}}: </p>
                        <p class="parrafo_cuerpo"> De la manera más atenta me dirijo a usted para Solicitarle: que el estudiante 
                        <b>{{ mb_strtoupper($oficio->estudiante, 'utf-8')}}</b>,  Número de Registro Académico <b>{{$oficio->registro}} </b> 
                        y Número de Carné <b>{{$oficio->carne}}</b>, de la  CARRERA DE <b>{{mb_strtoupper($carrera,'utf-8')}}</b> pueda realizar su 
                        PRÁCTICA FINAL <span style="color:red;">EN DOCENCIA </span>con una duración de 400 horas, en el curso de {{$oficio->curso ?? "**Agregue curso en el formulario a la izquierda**"}}
                        con código {{$oficio->codigo_curso ?? '000'}}, el cual usted imparte, de acuerdo a la solicitud que realizó con fecha 
                        {{$fecha_solicitud ?? "**Ingrese fecha de solicitud**"}}. Agradeciendo se me informe por escrito si es aceptado o no, indicando la fecha
                        de inicio y el horario en el que él apoyará como Auxiliar Docente.</p>

                        <p>En espera de una respuesta favorable, me suscribo de usted.</p>
                        <p>Atentamente,</p>
                    </div>      
                    
                    <div class="firma">
                        <p><b>"Id Y Enseñad A Todos"</b></p>
                        <br><br><br><br>
                        <p><b>{{$supervisor}}</b></p>
                        <p><b>Docente de Prácticas Finales</b></p>
                        <p><b>{{$carrera}}</b></p>
                    </div>

                    <div class="fin">
                        <p>Re/archivo</p>
                    </div>

                </div>

                <div id="carta_investigacion" style="display:none;">
                    <div class="encabezado">
                        <div class="encabezado_derecha">
                        <br>
                            <p class="linea-encabezado">Of. {{$no_oficio}}</p>
                            <p class="linea-encabezado">Quetzaltenango, {{$fecha}}</p>
                        </div>        
                    </div>      

                    <div class="destinatario">
                        <p class="linea-destinatario">Docente</p>
                        <p class="linea-destinatario">{{$oficio->destinatario}}</p>
                        <p class="linea-destinatario">{{$oficio->empresa}}</p>
                        <p class="linea-destinatario">{{$oficio->direccion}}</p>
                        <p class="linea-destinatario">{{$oficio->ubicacion}}{{$punto}}</p>
                    </div>   

                    <div class="cuerpo">
                        <p>{{$oficio->encabezado}}: </p>
                        <p class="parrafo_cuerpo"> De la manera más atenta me dirijo a usted para Solicitarle: que el estudiante 
                        <b>{{ mb_strtoupper($oficio->estudiante, 'utf-8')}}</b>,  Número de Registro Académico <b>{{$oficio->registro}} </b> 
                        y Número de Carné <b>{{$oficio->carne}}</b>, de la  CARRERA DE <b>{{mb_strtoupper($carrera, 'utf-8')}}</b> pueda realizar su 
                        PRÁCTICA FINAL <span style="color:red;">EN INVESTIGACIÓN </span>con una duración de 400 horas, en el proyecto de investigación "{{$oficio->curso ?? "**Agregue tema en el formulario a la izquierda**"}}",
                        de acuerdo a la solicitud que realizó con fecha {{$fecha_solicitud ?? "**Ingrese fecha de solicitud**"}}. Agradeciendo se me informe por escrito si 
                        es aceptado o no, indicando la fecha de inicio y el horario en el que él apoyará como Auxiliar de Investigación.</p>

                        <p>En espera de una respuesta favorable, me suscribo de usted.</p>
                        <p>Atentamente,</p>
                    </div>      
                    
                    <div class="firma">
                        <p><b>"Id Y Enseñad A Todos"</b></p>
                        <br><br><br><br>
                        <p><b>{{$supervisor}}</b></p>
                        <p><b>Docente de Prácticas Finales</b></p>
                        <p><b>{{$carrera}}</b></p>
                    </div>

                    <div class="fin">
                        <p>Re/archivo</p>
                    </div>

                </div>

                <div id="carta_aplicada" style="display:none;">
                    <div class="encabezado">
                        <div class="encabezado_derecha">
                        <br>
                            <p class="linea-encabezado">Of. {{$no_oficio}}</p>
                            <p class="linea-encabezado">Quetzaltenango, {{$fecha}}</p>
                        </div>        
                    </div>      

                    <div class="destinatario">            
                        <p class="linea-destinatario">{{$oficio->destinatario}}</p>
                        <p class="linea-destinatario">{{$oficio->puesto ?? '**Ingrese puesto**'}}</p>
                        <p class="linea-destinatario">{{$oficio->empresa}}</p>
                        <p class="linea-destinatario">{{$oficio->direccion}}</p>
                        <p class="linea-destinatario">{{$oficio->ubicacion}}{{$punto}}</p>
                    </div>   

                    <div class="cuerpo">
                        <p>{{$oficio->encabezado}}: </p>
                        <p class="parrafo_cuerpo"> De la manera más atenta me dirijo a usted para Solicitarle: que el estudiante 
                        <b>{{ mb_strtoupper($oficio->estudiante, 'utf-8')}}</b>,  Número de Registro Académico <b>{{$oficio->registro}} </b> 
                        y Número de Carné <b>{{$oficio->carne}}</b>, de la  CARRERA DE <b>{{mb_strtoupper($carrera, 'utf-8')}}</b> pueda realizar su 
                        PRÁCTICA FINAL <span style="color:red;"> APLICADA </span> con una duración de 400 horas, en la empresa que usted dirige. 
                        Le agradeceré la confirmación por escrito, si es aceptado, indicando el nombre de la persona 
                        ({{$oficio->cargo_encargado ?? "**Profesión encargado**"}}) que tendrá a su cargo supervisar 
                        las actividades que desarrollará el estudiante mencionando, fecha de inicio y el 
                        horario. Además, le solicito indicarme si en el área de trabajo, donde se 
                        encontrará el estudiante, se cumple con lo establecido en el acuerdo Gubernativo 
                        79-2020 y sus modificaciones, con respecto a la pandemia del COVID 19.  En el caso de no ser aceptado,
                        por favor, notificarme por escrito.</p>

                        <p>En espera de una respuesta favorable, me suscribo de usted.</p>
                        <p>Atentamente,</p>
                    </div>      
                    
                    <div class="firma">
                        <p><b>"Id Y Enseñad A Todos"</b></p>
                        <br><br><br><br>
                        <p><b>{{$supervisor}}</b></p>
                        <p><b>Docente de Prácticas Finales</b></p>
                        <p><b>{{$carrera}}</b></p>
                    </div>

                    <div class="fin">
                        <p>Re/archivo</p>
                    </div>
                
                </div>

            
            </div>
            <!--Vista previa-->
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

document.getElementById("btn_validar").addEventListener("click", function(event){
    var form = document.getElementsByClassName('needs-validation');
    if (form[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        form[0].classList.add('was-validated');
        alerta_error('Por favor guardar cambios antes de validar');
    }
});

function tipoPractica(){
    var forms = document.getElementsByClassName('needs-validation');
    forms[0].classList.remove('was-validated');
    // Get the checkbox
    var tipo = $("#select_tipo").val();    
    console.log("TIPO: ", tipo);
    // If the checkbox is checked, display the output
    if(tipo == 1){
      $('#div_aplicada').hide(200);
      $('#div_investigacion').hide(200);
      $('#div_docencia').show(600);
      $('#carta_aplicada').hide(200);
      $('#carta_investigacion').hide(200);
      $('#carta_docencia').show(1500);
      $('#curso').attr('required',true);
      $('#codigo').attr('required',true);
      $('#fecha_docencia').attr('required',true);
      $('#fecha_investigacion').removeAttr('required');
      $('#profesion').removeAttr('required');
      $('#puesto').removeAttr('required');
      $('#tema').removeAttr('required');
    }
    else if(tipo == 2){
      $('#div_aplicada').hide(200);
      $('#div_docencia').hide(200);
      $('#div_investigacion').show(600);
      $('#carta_docencia').hide(200);
      $('#carta_aplicada').hide(200);
      $('#carta_investigacion').show(1500);
      $('#tema').attr('required',true);
      $('#curso').removeAttr('required');
      $('#codigo').removeAttr('required');
      $('#puesto').removeAttr('required');
      $('#fecha_investigacion').attr('required',true);
      $('#fecha_docencia').removeAttr('required');
      $('#profesion').removeAttr('required');
    }
    else{
      $('#div_docencia').hide(200);
      $('#div_investigacion').hide(200);
      $('#div_aplicada').show(600);
      $('#carta_docencia').hide(200);
      $('#carta_investigacion').hide(200);
      $('#carta_aplicada').show(1500);
      $('#puesto').attr('required',true);
      $('#curso').removeAttr('required');
      $('#codigo').removeAttr('required');
      $('#tema').removeAttr('required');
      $('#fecha_docencia').removeAttr('required');
      $('#fecha_investigacion').removeAttr('required');
      $('#profesion').attr('required',true);
    }
}


$( document ).ready(function() {
    tipoPractica();

});

</script>

@endsection

