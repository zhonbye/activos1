@extends('layout')
@section('contenido')
    <style>
.sidebar-col.card-minimized {
        min-height: 50px;
        max-height: 50px !important;
        /* altura para mostrar solo header */
        overflow: hidden;
        padding: 0 !important;
        /* elimina padding */
        margin: 0 !important;
        /* elimina margen si hay */
    }

    /* Ocultar título cuando minimizado */
    .sidebar-col.card-minimized .sidebar-title {
        display: none;
    }

    /* Botón ocupa todo el espacio del sidebar minimizado, sin padding ni margen */
    .sidebar-col.card-minimized .toggleSidebar {
        width: 100%;
        height: 50px;
        padding: 0;
        margin: 0;
        font-size: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #contenifdo {
        /* display: flex; */
        /* display: block; mantiene el grid de bootstrap */

        /* height: 100vh; toda la pantalla */
        /* overflow: hidden; */
    }

    .sidebar-wrapper {
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE 10+ */
        /* width: 20%; */
        max-height: 100vh;
        overflow-y: auto;
        /* background: #eee; */
        /* flex-shrink: 0; */
        height: 100vh;
    }

    .main-col {
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE 10+ */
        /* toma todo el resto */
        max-height: 100vh;
        height: 100vh;

        overflow-y: auto;
        /* background: #ccc; */
    }

    /* Transiciones */
    .transition {
        transition: all 0.3s ease;
    }

    .resultado {
        overflow: auto;
        /* permite desplazamiento */
        scrollbar-width: none;
        /* oculta scrollbar en Firefox */
        -ms-overflow-style: none;
        /* IE y Edge antiguos */
    }

    .resultado::-webkit-scrollbar {
        display: none;
        /* oculta scrollbar en Chrome, Safari, Edge nuevos */
    }
    /* para la barra de dezlizamiento */

  .scroll-card-sm {
    max-height: 50vh;       /* Altura más pequeña */
    overflow-y: auto;       /* Scroll vertical */
    position: relative;
}

/* Chrome, Edge, Safari */
.scroll-card-sm::-webkit-scrollbar {
    width: 4px;             /* Scroll más delgado */
}

.scroll-card-sm::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);  /* Color de fondo muy claro */
}

.scroll-card-sm::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);  /* Scroll gris claro */
    border-radius: 2px;
}

.scroll-card-sm::-webkit-scrollbar-thumb:hover {
    background-color: rgba(0,0,0,0.35); /* Hover un poco más oscuro */
}

/* Firefox */
.scroll-card-sm {
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.2) rgba(0,0,0,0.05);
}















.barra-progreso-contenedor {
position: absolute;
  width: 100%;
  height: 3px;
  background-color: #7ae7c628;
  border-radius: 10px;
  margin-bottom: 10px;
}

.barra-progreso {
  height: 100%;
  width: 0%; /* Comienza en 0% */
  background-color: #6765e6;
  border-radius: 10px;
  transition: width 0.5s ease-out; /* Añade una transición suave */
}

    </style>

    <div class="col-auto">
        <nav class="sidebar">
            <header>
                <span class="text text-center mx-4 fs-5 fw-bold ">Usuario</span>
                <i class="bi fs-2  bi-caret-left toggle" aria-label="Alternar menú"></i>
            </header>

            <ul class="menu" role="menubar">

    <!-- ====================== -->
    <!-- MÓDULO: ACTIVOS FIJOS -->
    <!-- ====================== -->
    <li class="menu-item" data-submenu="submenuActivos" role="none">
        <div class="main-item bg-success bg-opacity-10" tabindex="0" role="menuitem" aria-haspopup="true"
            aria-expanded="false" aria-controls="submenuActivos">
            <i class="bi bi-boxes icon" aria-hidden="true"></i>
            <span class="text">Activos Fijos</span>
            <i class="bi bi-caret-down caret" aria-hidden="true"></i>
        </div>
        <ul class="submenu" id="submenuActivos">
            <li><a href="{{ route('activos.index') }}" role="menuitem" class="cargar" id="primario">Listar Activos</a></li>
            <li><a href="{{ route('activos.create') }}" role="menuitem" class="cargar" >Registrar Activo</a></li>
            <li><a href="#" role="menuitem">Buscar Activo</a></li>
            <li><a href="{{ route('bajas.create') }}" role="menuitem" class="cargar">Dar de Baja Activo</a></li>

            {{-- <li><a href="#" role="menuitem">Dar de Baja Activo</a></li> --}}
            <li><a href="#" role="menuitem"></a></li>
                <li><a href="{{ route('traslados.show', ['id' => 1 ?? 1]) }}" role="menuitem" class="cargar">Registrar Traslado</a></li>

            <li><a href="#" role="menuitem">Registrar Devolución</a></li>
        </ul>
    </li>

    <!-- ====================== -->
    <!-- MÓDULO: ENTREGAS Y ACTAS -->
    <!-- ====================== -->
    <li class="menu-item" data-submenu="submenuEntregas" role="none">
        <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true"
            aria-expanded="false" aria-controls="submenuEntregas">
            <i class="bi bi-rocket-takeoff icon" aria-hidden="true"></i>
            <span class="text">Entregas y Actas</span>
            <i class="bi bi-caret-down caret" aria-hidden="true"></i>
        </div>
        <ul class="submenu" id="submenuEntregas">
            <li><a href="{{ route('entregas.create') }}" role="menuitem" class="cargar">Crear Entrega</a></li>
            <li><a href="{{ route('entregas.realizar') }}" role="menuitem" class="cargar">Realizar Entrega</a></li>
            <li><a href="#" role="menuitem">Listar Actas Generadas</a></li>
        </ul>
    </li>

    <!-- ====================== -->
    <!-- MÓDULO: INVENTARIOS -->
    <!-- ====================== -->
    <li class="menu-item" data-submenu="submenuInventario" role="none">
        <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true"
            aria-expanded="false" aria-controls="submenuInventario">
            <i class="bi bi-clipboard-data icon" aria-hidden="true"></i>
            <span class="text">Inventarios</span>
            <i class="bi bi-caret-down caret" aria-hidden="true"></i>
        </div>
        <ul class="submenu" id="submenuInventario">
            <li><a href="#" role="menuitem">Realizar Inventario</a></li>
            <li><a href="{{ route('inventario.consultar') }}" role="menuitem" class="cargar">Consultar Inventario</a></li>
            <li><a href="{{ route('pruebas') }}" role="menuitem" class="cargar">prueba interfaces</a></li>
        </ul>
    </li>

    <!-- ====================== -->
    <!-- MÓDULO: REPORTES -->
    <!-- ====================== -->
    <li class="menu-item" data-submenu="submenuReportes" role="none">
        <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true"
            aria-expanded="false" aria-controls="submenuReportes">
            <i class="bi bi-graph-up icon" aria-hidden="true"></i>
            <span class="text">Reportes</span>
            <i class="bi bi-caret-down caret" aria-hidden="true"></i>
        </div>
        <ul class="submenu" id="submenuReportes">
            <li><a href="#" role="menuitem">Reportes de Activos</a></li>
            <li><a href="#" role="menuitem">Reportes por Responsable</a></li>
            <li><a href="#" role="menuitem">Reportes Globales</a></li>
        </ul>
    </li>

</ul>

<div class="mb-3 d-flex flex-column align-items-center gap-2">
    <input type="text" id="rutaDefecto" class="form-control" value="activos.index" placeholder="Ej: /user/activos" style="max-width:300px;">
    <br>
    <button id="guardarRuta" class="btn btn-sm btn-primary">Guardar ruta</button>
</div>





            <!-- Menú de usuario adaptado -->
            <li class="menu-item  list-unstyled">
                <a href="#" class="main-item dropdown-toggle d-flex align-items-center gap-2 text-decoration-none"
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <i class="bi bi-person-circle icon fs-5 text-primary"></i>
            <span class="text">Juanito</span> --}}
                    <i class="bi bi-person-circle fs-5 icon"></i>
                    <span class="text text-truncate" style="max-width: 80%">
                        {{ Auth::user()->usuario }}
                    </span>
                    {{-- <i class="bi bi-caret-down caret"></i> --}}
                </a>
                <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="userDropdown">
                    {{-- aria-labelledby="userDropdown" --}}
                    <li>
                        {{-- <li role="none">
                            <a href="{{ route('usuarios.create') }}" role="menuitem" class="cargar">Crear Usuarios</a>
                        </li> --}}
                        <a class="ajustes dropdown-item" href="{{ route('ajustes.index') }}">
                            <i class="bi bi-gear me-2"></i>Preferencias
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                        </a>
                    </li>
                </ul>
            </li>
        </nav>
    </div>
    <div class="col ">

        <div id="mensaje" class="w-100"></div>
     



<div class="barra-progreso-contenedor">
  <div id="miBarra" class="barra-progreso "></div>
</div>




        <div id="contenido" class="bg-dansger flex-grow-1 p-4 m-0 ">
            <h2>Panel de Usuario</h2>
            <p>Selecciona una opción del menú para comenzar hh.</p>
        </div>
    </div>


    <script>
        const baseUrl = "{{ url('/') }}";

        $(document).ready(function() {

            $('#contenido').on('keydown', '.con-ceros', function(e) {
                if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    var numero2 = parseInt($(this).val(), 10) || 0;
                    var numero = e.key === 'ArrowUp' ? numero2 + 1 : numero2 - 1;
                    if (numero < 0) numero = 0;
                    var numeroStr = numero.toString().padStart(3, '0');
                    $(this).val(numeroStr);
                }
            });

            // Detecta cambios que pueden venir por click en flechas nativas o edición manual
            $('#contenido').on('input', '.con-ceros', function() {
                var val = $(this).val();
                var num = parseInt(val, 10) || 0;
                if (num < 0) num = 0;
                var newVal = num.toString().padStart(3, '0');
                if (val !== newVal) {
                    $(this).val(newVal);
                }
            });

$('#contenido').on('click', '.toggleSidebar', function() {
// $('.').click(function() {
// alert("fhoanfl")
        const $button = $(this);
        const $sidebarCol = $button.closest('.sidebar-col'); // card individual
        const $sidebarWrapper = $sidebarCol.parent(); // contenedor de todos los sidebars
        const $mainCol = $('.main-col');
        const $text = $sidebarCol.find('h3').text();
        // alert($text)

        const isCollapsed = $sidebarCol.hasClass('card-minimized');

        if (!isCollapsed) {
            // Minimizar solo este sidebar
            $sidebarCol.addClass('card-minimized');

            // Cambiar texto botón a texto completo (ejemplo)
            $button.text($text);

            // Si todos los sidebars están minimizados, ajustar ancho wrapper y main
            const allCollapsed = $sidebarWrapper.children('.sidebar-col').length === $sidebarWrapper.children(
                '.sidebar-col.card-minimized').length;
            if (allCollapsed) {
                $sidebarWrapper.addClass('sidebar-collapsed');
                $mainCol.addClass('main-expanded');
            }

        } else {
            // Restaurar sidebar actual
            $sidebarCol.removeClass('card-minimized');
            $button.text('⮞');

            // Si alguno está abierto, quitar clases de wrapper y main
            $sidebarWrapper.removeClass('sidebar-collapsed');
            $mainCol.removeClass('main-expanded');
        }
    });



        });




        function reset(formSelector) {
            formSelector[0].reset();
        }
        // $('#numero_acta_buscar').on(function(){
        // alert("alert")
        // })
        //deja los 00 en el input de tipo number




        /**
             * const sidebar = document.querySelector('.sidebar');
            const toggleBtn = sidebar.querySelector('.toggle');
            const menuItems = sidebar.querySelectorAll('li.menu-item');
            const body = document.body;


            $(document).ready(function() {
                $('.cargar').on('click', function(e) {
                    e.preventDefault(); // evita que el enlace recargue la página

                    let url = $(this).attr('href');

                    // Cargar contenido usando AJAX
                    $.get(url, function(data) {
                        $('#contenido').html(data);
                    }).fail(function() {
                        $('#contenido').html('<p style="color:red;">Error al cargar contenido.</p>');
                    });
                });
            });


            // Toggle sidebar width
            toggleBtn.addEventListener('click', () => {
                // Close all submenus if minimized
                // sidebar.classList.toggle('close');
                // if (sidebar.classList.contains('close')) {
                //     menuItems.forEach(item => {
                //         item.classList.remove('open');
                //     });
                // }

                menuItems.forEach(item => {
                    item.classList.remove('open');
                });

                // Paso 2: esperar 300ms y luego cerrar sidebar
                setTimeout(() => {
                    sidebar.classList.toggle('close');
                }, 300); // Espera igual a la transición de los submenús

            });

            menuItems.forEach(item => {
                const mainItem = item.querySelector('.main-item');
                const submenu = item.querySelector('.submenu');

                mainItem.addEventListener('click', e => {
                    e.preventDefault();

                    // Si sidebar minimizado, abrir sidebar para mostrar submenu
                    if (sidebar.classList.contains('close')) {
                        sidebar.classList.remove('close');
                    }

                    // Abrir/cerrar submenu
                    const isOpen = item.classList.contains('open');

                    // Cerrar todos los demás submenus
                    // const keepOpen = document.getElementById('keepOpen');
                    // if (!keepOpen.checked) {
                        menuItems.forEach(i => {
                            if (i !== item) {
                                i.classList.remove('open');
                            }
                        });
                    // }

                    if (isOpen) {
                        item.classList.remove('open');
                    } else {
                        item.classList.add('open');
                    }
                });
            });

            // Manejo de selección y carga de contenido para links
            sidebar.querySelectorAll('ul.submenu li a').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();

                    // Remover seleccionado anterior
                    sidebar.querySelectorAll('ul.submenu li a.selected').forEach(el => el.classList.remove(
                        'selected'));

                    link.classList.add('selected');

                    // Aquí puedes cargar contenido dinámico, ejemplo:
                    const contenido = document.getElementById('contenido');
                    contenido.innerHTML =
                        `<h2>${link.textContent}</h2><p>Contenido para "${link.textContent}" cargado.</p>`;
                });
            });
             *
            */
        function mensaje(mensaje, tipo) {
            var nuevaAlerta = $('<div class="alert alert-' + tipo +
                ' alert-dismissible fade show" role="alert" ><strong>' + mensaje +
                '</strong> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button></div>'
            );
            $("#mensaje").append(nuevaAlerta);
            // console.log(mensaje);
            if ($("#mensaje .alert-flotante").length > 10) {
                $("#mensaje .alert-flotante").first().remove();
            }
            setTimeout(function() {
                nuevaAlerta.remove();
            }, 7000);
        };
    </script>
@endsection
