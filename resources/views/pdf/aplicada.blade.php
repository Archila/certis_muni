

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
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
            margin: 0cm 1cm 0cm 0.8cm;            
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
            <p class="linea-destinatario">{{$oficio->destinatario}}</p>
            <p class="linea-destinatario">{{$oficio->puesto}}</p>
            <p class="linea-destinatario">{{$oficio->empresa}}</p>
            <p class="linea-destinatario">{{$oficio->direccion}}</p>
            <p class="linea-destinatario">{{$oficio->ubicacion}}{{$punto}}</p>
        </div>   

        <div class="cuerpo">
            <p>{{$oficio->encabezado}}: </p>
            <p class="parrafo_cuerpo"> De la manera más atenta me dirijo a usted para Solicitarle: que el estudiante 
            <b>{{ mb_strtoupper($oficio->estudiante, 'utf-8')}}</b>,  Número de Registro Académico <b>{{$oficio->registro}} </b> 
            y Número de Carné <b>{{$oficio->carne}}</b>, de la  CARRERA DE <b>{{mb_strtoupper($carrera, 'utf-8')}}</b> pueda realizar su 
            PRÁCTICA FINAL APLICADA con una duración de 400 horas, en la empresa que usted dirige. 
            Le agradeceré la confirmación por escrito, si es aceptado, indicando el nombre de la persona 
            ({{$oficio->cargo_encargado}}) que tendrá a su cargo supervisar las actividades que desarrollará el 
            estudiante mencionando, fecha de inicio y el horario. Además, le solicito indicarme si en el área de 
            trabajo, donde se encontrará el estudiante, se cumple con lo establecido en el acuerdo Gubernativo 
            79-2020 y sus modificaciones, con respecto a la pandemia del COVID 19.  En el caso de no ser aceptado,
             por favor, notificarme por escrito.</p>

            <p>En espera de una respuesta favorable, me suscribo de usted.</p>
            <p>Atentamente,</p>
        </div>      
        
        <div class="firma">
            <p><b>"Id Y Enseñad A Todos"</b></p>
            <br><br><br><br><br><br>
            <p><b>{{$supervisor}}</b></p>
            <p><b>Supervisor de Prácticas Finales</b></p>
            <p><b>{{$carrera}}</b></p>
        </div>

        <div class="fin">
            <p>Re/archivo</p>
        </div>

    </body>
</html>

