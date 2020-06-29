

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
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
            margin-top: 0;   
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
            margin: -0.2cm 0;
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
                <p class="linea-encabezado">Of. EPS-IM No. 001-2020</p>
                <p class="linea-encabezado">Quetzaltenango, 20 de enero de 2020</p>
            </div>        
        </div>      

        <div class="destinatario">
            <p class="linea-destinatario">Ing. Carlos Sandoval</p>
            <p class="linea-destinatario">Gerente de Relaciones Laborales</p>
            <p class="linea-destinatario">Cervecería Centroamericana</p>
            <p class="linea-destinatario">3a Av. Norte final, Finca el Zapote zona 2</p>
            <p class="linea-destinatario">Guatemala</p>
        </div>   

        <div class="cuerpo">
            <p>Respetable Ingenierio: </p>
            <p class="parrafo_cuerpo"> De la manera más atenta me dirijo a usted para <b>Solicitarle</b>: que el estudiante 
            <b>{{$estudiante->nombre}}{{' '}}{{$estudiante->apellido}}</b>,  Número de Registro Académico 
            <b>{{$estudiante->registro}} </b> y Número de Carné <b>{{$estudiante->carne}}</b>, de la  Carrera de 
            <b>{{$estudiante->carrera}}</b> pueda realizar su Práctica Final con una duración de 400 horas, 
            en la empresa que usted dignamente dirige.  Agradeciendo se me informe por escrito si es aceptado o no, 
            indicando el nombre de la persona (Ing. mecánico) que tendrá a su cargo supervisar las actividades que 
            desarrollará el estudiante mencionado, fecha de inicio y el horario.</p>

            <p>En espera de una respuesta favorable, me suscribo de usted.</p>
            <p>Atentamente,</p>
        </div>      
        
        <div class="firma">
            <p><b>"Id Y Enseñad A Todos"</b></p>
            <br><br><br><br><br><br>
            <p><b>Ing. Luís Efraín Aballí</b></p>
            <p><b>Supervisor E.P.S. Ingeniería Mecánica</b></p>
        </div>

        <div class="fin">
            <p>Re/archivo</p>
        </div>

    </body>
</html>

