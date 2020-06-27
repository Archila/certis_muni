<!-- Sidebar Menu 
    INICIO
    10) Index   11) Otro

    USUARIOS
    20) Index   21) Crear   22) Editar  23) Ver    

    ESTUDIANTES
    30) Index   31) Crear   32) Editar  33) Ver     

    EMPRESAS
    40) Index   41) Crear   42) Editar  43) Ver 

    ENCARGADOS
    50) Index   51) Crear   52) Editar  53) Ver 

    Bitacora
    60) Index   61) Crear   62) Editar  63) Ver 

    CARRERAS
    70) Index   71) Crear   72) Editar  73) Ver 

    SUPERVISORES
    80) Index   81) Crear   82) Editar  83) Ver 

    ROLES
    90) Index   91) Crear   92) Editar  93) Ver 

-->
   
<!-- Sidebar Menu -->
<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            @if($sidebar==10) @php $index='active'; @endphp  @endif
            <a href="/" class="nav-link {{$index ?? ''}}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Inicio                
              </p>
            </a>
          </li>

          @if($sidebar<=69 && $sidebar>=60) @php $bit='active'; $menu6='menu-open' @endphp  @endif
          <li class="nav-item">            
            <a href="{{route('bitacora.index')}}" class="nav-link {{$bit ?? ''}}">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>
                Bitacora
              </p>
            </a>            
          </li>     


          @if($sidebar<=39 && $sidebar>=30) @php $est='active'; $menu3='menu-open' @endphp  @endif
          <li class="nav-item">            
            <a href="{{route('estudiante.index')}}" class="nav-link {{$est ?? ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Estudiantes
              </p>
            </a>            
          </li>     

          @if($sidebar<=49 && $sidebar>=40) @php $emp='active'; $menu4='menu-open' @endphp  @endif
          <li class="nav-item">            
            <a href="{{route('empresa.index')}}" class="nav-link {{$emp ?? ''}}">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Empresas
              </p>
            </a>            
          </li>        
          
          @if($sidebar<=59 && $sidebar>=50) @php $enc='active'; $menu5='menu-open' @endphp  @endif
          <li class="nav-item">            
            <a href="{{route('encargado.index')}}" class="nav-link {{$enc ?? ''}}">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Encargados
              </p>
            </a>            
          </li>     
          
          <li class="nav-header">Administración</li>

          <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Notificaciones
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>          

          @if($sidebar<=79 && $sidebar>=70) @php $car='active'; $menu7='menu-open' @endphp  @endif
          <li class="nav-item">            
            <a href="{{route('carrera.index')}}" class="nav-link {{$car ?? ''}}">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Carreras
              </p>
            </a>            
          </li>         


          @if($sidebar<=89 && $sidebar>=80) @php $sup='active'; $menu8='menu-open' @endphp  @endif
          <li class="nav-item">            
            <a href="{{route('supervisor.index')}}" class="nav-link {{$sup ?? ''}}">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                Supervisores
              </p>
            </a>            
          </li>


          @if($sidebar<=99 && $sidebar>=90) @php $rol='active'; $menu9='menu-open' @endphp  @endif
          <li class="nav-item">            
            <a href="{{route('rol.index')}}" class="nav-link {{$rol ?? ''}}">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Roles
              </p>
            </a>            
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->