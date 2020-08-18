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
        font-size: 10px;
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
            margin-top:2rem;
        }
        .encabezado-texto{
            font-size: 9;
            display: block;
            float:left;
            width: 50%; 
            margin-left: 1rem;
        }
        .folio{
            font-size: 12;
            display: block;
            float:right;
            width: 8%; 
            text-align:center;
            border: 1px solid black;
            margin-right: 4rem;
            margin-top: 1rem;
        }
        .linea-encabezado{
            padding: -0.20cm 0.5cm;
            margin-left: 2rem;
        }
        .descripcion{
            font-size: 9;
            display: block;
            border: 1px solid black;
            margin: 1rem 4rem;
            font-size: 10;  
            width: 100%;
            height: 28rem;
            overflow: auto;
        }
        .observaciones{
            font-size: 9;
            display: block;
            border: 1px solid black;
            margin: 1rem 4rem 0 4rem;
            font-size: 10;  
            width: 100%;
            height: 11rem;
            overflow: auto;
        }
        .firmas{
            font-size: 9;
            display: block;
            border: 1px solid black;
            margin: 1rem 4rem;
            font-size: 10;  
            width: 100%;
            height: 8rem;
            overflow: auto;
        }
        .p1{
            font-size: 9;
            padding: -0.8rem 0.5rem;
            width: 100%;
        }
        .p2{
            font-size: 9;
            padding: 0 0.5rem;
            width: 50%;
            float:left;
        }
        .p3{
            font-size: 9;
            margin-top: 0rem;
            margin-right: 1.5rem;
            width: 50%;
            float:right;
            text-align: right;
        }
        .p4{
            font-size: 9;
            padding: -0.8rem 0.5rem;
            width: 100%;
        }
        .contenido{
            font-size: 10;
            padding: -0.2rem 1.5rem;
            text-align: justify;
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
        .firmas p{
            padding-top: -0.4cm;
        }
        .c1{
            width: 28%;
            float:left;
            text-align: center;
        }
        .c2{
            width: 60%;
            float:right;
            text-align: center;
            padding-left:1cm;            
        }
        .sello{
            width: 15%;
            float:right;
            text-align: center; 
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
    @for ($i = 1; $i <= 20; $i++)
        
        <!--ENCABEZADO -->
        <div class="encabezado">            
            <div class="encabezado-texto">
            <p class="linea-encabezado">Universidad de San Carlos de Guatemala</p>
            <p class="linea-encabezado">Centro Universitario de Occidente</p>
            <p class="linea-encabezado">División de Ciencias de la Ingeniería</p>
            <p class="linea-encabezado">Departamento de EPS, Prácticas Finales</p>
            <p class="linea-encabezado">Bitácora de actividades del Estudiantes</p>
            </div>
            <div class="folio">
            @if($i<=9)
                0{{$i}}/20
            @else
                {{$i}}/20
            @endif
            </div>
        </div>
        <br><br><br><br><br><br> <br>
        <div class="descripcion">
            <p class="p1"><b>Descripción de Actividades</b></p>
            <p class="p2">Actividades efectuadas</p>
            <p class="p3">Fecha:          <span style="text-decoration: underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></p>
            <p class="contenido"></p>
        </div>

        <div class="observaciones">
            <p class="p4">Observaciones:</p>
        </div>
        <div class="firmas">
        <br><br><br>
        <div class="sello">
                sello
        </div>   
        <br><br>
            <div class="c1">
            <p style="text-align: left;">____________________________</p>
            <p>Firma del Estudiante</p>
            </div>            
            <div class="c2">
            <p>____________________________________________________</p>
            <p>Firma y sello del Responsable por la contraparte institucional</p>
            </div>    
                             
        </div>
        <br><br><br><br><br>

    
    @endfor
    </body>
</html>



