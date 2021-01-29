

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Oficio</title>
        <style>       
        .encabezado::after {
            content: "";
            clear: both;
            display: table;
        }
        .encabezado{
            overflow:auto;
            margin-left: -0.7cm;
        }
        .encabezado_izquierda{
            display: inline-block;
            float: left;
            font-size: 9px;
            max-width: 6cm;
            width: 6cm;
            text-align: center;
        }
        .encabezado-texto{
            margin-top: -0.5em;   
        }
        .linea-encabezado{
            padding: -0.2cm 0.5cm;
        }
        .encabezado_derecha{
            display: block;
            float: right;
            font-size: 13px;
            font-style: bold;
            width: 100%;
            text-align: right;
        }
        .logo{
            height: 2cm;
            weight: 2cm;     
            margin: 0.6em 0 -0.7em 0;
        }   
        .destinatario{
            display: block;
            font-size: 14px;
            font-style: bold;
            margin: 1.8cm 0 2cm 0.8cm;
        }     
        .linea-destinatario{
            padding: -0.18cm 0;
        }
        .cuerpo{
            display: block;
            font-size: 14px;
            margin: 1.8cm 1cm 1.5cm 0.8cm;
            text-align: justify;
        }    
        .firma{
            display: block;
            font-size: 14px;
            margin: -1cm 1cm 0cm 0.8cm;            
            text-align: center;
        }   
        .firma p{
            padding: -0.5cm 1cm 0cm 0.8cm; 
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
    
    .firmas{
        display: block;           
        margin: 1.4cm 0cm 0 0cm;
        font-size: 9;  
        width: 100%;
        overflow: auto;
    }
    .firmas p{
        padding-top: -0.4cm;
    }
    .c1{
        width: 40%;
        float:left;
        text-align: center;
    }
    .c2{
        width: 20%;
        float:left;
        text-align: center;
        padding-left:1cm;            
    }
    .c3{
        width: 25%;
        float:left;
        text-align: right;     
    }
    .fin{
        margin-top: 2cm;
    }
    </style>
    </head>
    <body>

        <div class="encabezado">
            <!--ENCABEZADO -->
            <div class="encabezado_izquierda">
                <p class="linea-encabezado">UNIVERSIDAD DE SAN CARLOS DE GUATEMALA</p>
                <img class="logo" src="dist/img/logo_cunoc.png" > 
                <div class="encabezado-texto">
                <p class="linea-encabezado">División de ciencias de la ingeniería</p>
                <p class="linea-encabezado">Centro Universitario de Occidente</p>
                <p class="linea-encabezado">Quetzaltenango</p>
                </div>
            </div>

            <div class="encabezado_derecha">
                <br><br> <br><br>                  
                <p class="linea-encabezado">Of. {{$oficio->no_oficio}}</p>
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
            PRÁCTICA FINAL EN INVESTIGACIÓN con una duración de {{$oficio->horas}} horas, en el proyecto de investigación "{{$oficio->curso}}",
            de acuerdo a la solicitud que realizó con fecha {{$fecha_solicitud}}. Agradeciendo pueda indicar en este oficio si es 
            aceptado o no, la fecha de inicio y el horario en el que él apoyará como Auxiliar de Investigación.</p>

            <p>En espera de una respuesta favorable, me suscribo de usted.</p>
            <p>Atentamente,</p>
        </div>      
        
        <div class="firma">
            <p><b>"Id Y Enseñad A Todos"</b></p>
            <br><br><br><br><br>
            <p><b>{{$supervisor}}</b></p>
            <p><b>Supervisor de Prácticas Finales</b></p>
            <p><b>{{$carrera}}</b></p>
        </div>

        <div class="firmas">
            <div class="c1">
                <p style="">________________________________</p>
                <p>Firma y sello</p>
                <p>{{$oficio->destinatario}}</p>
            </div>            
            <div class="c2">
                <p>SI____&nbsp;&nbsp;&nbsp;&nbsp;NO____</p>
                <p style="font-size:6px;">&nbsp;</p>
                <p>ACEPTADO</p>
            </div>     
            <div class="c3">
                <p>Fecha inicio ____/____/______</p>
                <p style="font-size:6px;">&nbsp;</p>
                <p>Horario: _______________</p>
            </div>             
        </div>
        <br>
        <div class="fin">
            <p>Re/archivo</p>
        </div>

    </body>
</html>

