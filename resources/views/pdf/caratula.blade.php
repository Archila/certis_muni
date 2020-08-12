<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <style>
        h1{
        text-align: center;
        text-transform: uppercase;
        }
        .contenido{
        font-size: 20px;
        }
        #primero{
        background-color: #ccc;
        }
        #segundo{
        color:#44a359;
        }
        #tercero{
        text-decoration:line-through;
        }
        .encabezado{
            display: block;
        }
        .logo{
            height: 3cm;
            weight: 3cm;     
            margin-left: 1cm;
            float: left;
        }
        .encabezado-texto{
            margin-top: 0;    
            font-size: 10; 
            margin-left: 0.2cm;
        }
        .linea-encabezado{
            padding: -0.15cm 0.5cm;
            margin-left: 0.5cm;
        }
        .caja{
            display: block;
            border: 2px solid black;
            margin: 0.5cm 1cm;
            font-size: 10;  
            width: 100%;
            overflow: auto;
        }    
        .caja p{
            margin: 0.1cm 0 0.2cm 0.2cm;
        }
        .caja .tipo{
            width: 100%;
            border: 1px solid;
            border-style: none none solid none;
            padding: 0 0 0cm 0;
            margin-bottom: 0.2cm;
        }  
        .caja .variable {
            border: 1px solid;
            border-style: none none solid none;
            padding: 0 0 0cm 0;
            margin-bottom: 0.2cm;
            overflow: auto;
            
        } 
        .final{
            float: right;
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
    </head>
    <body>
        <!--ENCABEZADO -->
        <div class="encabezado">
            <img class="logo" src="dist/img/logo_cunoc.png" > 
            <div class="encabezado-texto">
            <p class="linea-encabezado">UNIVERSIDAD DE SAN CARLOS DE GUATEMALA</p>
            <p class="linea-encabezado">CENTRO UNIVERSITARIO DE OCCIDENTE</p>
            <p class="linea-encabezado">DIVISIÓN DE CIENCIAS DE LA INGENIERÍA</p>
            <p class="linea-encabezado">DEPARTAMENTO DE EPS</p>
            <p class="linea-encabezado">PRÁCTICAS FINALES</p>
            </div>
        </div>

        <div class="caja">
            <p>Tipo de docencia a desarrollar: </p>
            <p>
                <span>En docencia </span> 
                <span class="tipo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if($oficio->tipo == 1) X @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>En investigación</span>
                <span class="tipo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if($oficio->tipo == 2) X @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>Aplicada</span>
                <span class="tipo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; @if($oficio->tipo == 3) X @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </p>
        </div>

        <div class="caja">

            <div class="content__left">Ubicación</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$empresa->ubicacion}}</span></div>

            <div class="content__left">Contraparte institucional</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$empresa->nombre}}</span></div>

            <div class="content__left">Dirección</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$empresa->direccion}}</span></div>

            <div class="content__left">Correo electrónico</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$empresa->correo}}</span></div>

            <div class="content__left">Nombre del responsable del practicante</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$encargado->nombre}}{{' '}}{{$encargado->apellido}}</span></div>

            <div class="content__left">Puesto que ocupa</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$encargado->puesto}}</span></div>
            
        </div>

        <div class="caja">
        
            <div class="content__left">Nombre del practicante</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$estudiante->nombre}}{{' '}}{{$estudiante->apellido}}</span></div>

            <div class="content__left">Número de carné (CUI/DPI)</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$estudiante->carne}}</span></div>

            <div class="content__left">Registro académico</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$estudiante->registro}}</span></div>

            <div class="content__left">Carrera</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$estudiante->carrera}}</span></div>

            <div class="content__left">Dirección</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$estudiante->direccion}}</span></div>

            <div class="content__left">Correo electrónico</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$encargado->correo}}</span></div>            
        </div>

        <div class="caja">        
            <div class="content__left">Número de bitácora</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$bitacora->codigo}}</span></div>

            <div class="content__left">Fecha de extensión de la bitácora</div>
            <div class="content__right">&nbsp;</div>
            <div class="content__middle"><span class="">&nbsp;{{$bitacora->f_aprovacion}}</span></div>     
        </div>
   
    </body>
</html>



