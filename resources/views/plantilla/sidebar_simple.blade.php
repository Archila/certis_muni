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
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->