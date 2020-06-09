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


          @if($sidebar<=39 && $sidebar>=30) @php $est='active'; $menu3='menu-open' @endphp  @endif
          <li class="nav-item has-treeview {{$menu3 ?? ''}}">            
            <a href="#" class="nav-link {{$est ?? ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Estudiantes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                @if($sidebar==30) @php $est1='active'; @endphp  @endif
                <a href="{{route('estudiante.index')}}" class="nav-link {{$est1 ?? ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado estudiantes</p>
                </a>
              </li>
              <li class="nav-item">
                @if($sidebar==31) @php $est2='active'; @endphp  @endif
                <a href="{{route('estudiante.crear')}}" class="nav-link {{$est2 ?? ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear nuevo estudiante</p>
                </a>
              </li>              
            </ul>
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
          <li class="nav-item has-treeview {{$menu7 ?? ''}}">            
            <a href="#" class="nav-link {{$car ?? ''}}">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Carreras
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                @if($sidebar==70) @php $car1='active'; @endphp  @endif
                <a href="{{route('carrera.index')}}" class="nav-link {{$car1 ?? ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado carreras</p>
                </a>
              </li>
              <li class="nav-item">
                @if($sidebar==71) @php $car2='active'; @endphp  @endif
                <a href="{{route('carrera.crear')}}" class="nav-link {{$car2 ?? ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear nueva carrera</p>
                </a>
              </li>              
            </ul>
          </li>         


          @if($sidebar<=89 && $sidebar>=80) @php $sup='active'; $menu8='menu-open' @endphp  @endif
          <li class="nav-item has-treeview {{$menu8 ?? ''}}">            
            <a href="#" class="nav-link {{$sup ?? ''}}">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                Supervisores
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if($sidebar==80) @php $sup1='active'; @endphp  @endif
              <li class="nav-item">
                <a href="{{route('supervisor.index')}}" class="nav-link {{$sup1 ?? ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado Supervisores</p>
                </a>
              </li>
              @if($sidebar==81) @php $sup2='active'; @endphp  @endif
              <li class="nav-item">
                <a href="{{route('supervisor.index')}}" class="nav-link {{$sup2 ?? ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear nuevo supervisor</p>
                </a>
              </li>              
            </ul>
          </li>


          @if($sidebar<=99 && $sidebar>=90) @php $rol='active'; $menu9='menu-open' @endphp  @endif
          <li class="nav-item has-treeview {{$menu9 ?? ''}}">            
            <a href="#" class="nav-link {{$rol ?? ''}}">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Roles
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if($sidebar==90) @php $rol1='active'; @endphp  @endif
              <li class="nav-item">
                <a href="{{route('rol.index')}}" class="nav-link {{$rol1 ?? ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Listado Supervisores</p>
                </a>
              </li>
              @if($sidebar==91) @php $rol2='active'; @endphp  @endif
              <li class="nav-item">
                <a href="{{route('rol.index')}}" class="nav-link {{$rol2 ?? ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Crear nuevo supervisor</p>
                </a>
              </li>              
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->