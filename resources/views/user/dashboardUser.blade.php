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
            max-height: 50vh;
            /* Altura más pequeña */
            overflow-y: auto;
            /* Scroll vertical */
            position: relative;
        }

        /* Chrome, Edge, Safari */
        .scroll-card-sm::-webkit-scrollbar {
            width: 4px;
            /* Scroll más delgado */
        }

        .scroll-card-sm::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            /* Color de fondo muy claro */
        }

        .scroll-card-sm::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            /* Scroll gris claro */
            border-radius: 2px;
        }

        .scroll-card-sm::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.35);
            /* Hover un poco más oscuro */
        }

        /* Firefox */
        .scroll-card-sm {
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.2) rgba(0, 0, 0, 0.05);
        }















        .barra-progreso-contenedor {
            position: absolute;
            width: 100%;
            height: 7px;
            background-color: #7ae7c628;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .barra-progreso {
            height: 100%;
            width: 0%;
            /* Comienza en 0% */
            background-color: #6765e6;
            border-radius: 10px;
            transition: width 0.5s ease-out;
            /* Añade una transición suave */
        }




        .loader-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            height: 50px;
        }

        .loader-dots span {
            width: 15px;
            height: 15px;
            background-color: #3498db;
            border-radius: 50%;
            display: inline-block;
            animation: bounce 1s infinite ease-in-out;
        }

        .loader-dots span:nth-child(1) {
            animation-delay: 0s;
        }

        .loader-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loader-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }



        /* Clase reusable para “desactivar visualmente” */
        .desactivado {
            filter: grayscale(200%) opacity(0.4);
            /* Convierte a gris y rebaja opacidad */
            pointer-events: none;
            /* Evita clicks */
            transition: all 0.3s ease;
        }
    </style>
    <div id="loader" class="loader-dots" style="display: none;">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="col-auto">
        <nav class="sidebar">
            {{-- <header class="px-3 py-2 d-flex align-items-center font-black justify-content-between bg-light text-white rounded-3">
    <span class="fs-5 fw-bold">Gestión de Activos Fijos</span>
    <i class="bi fs-2 bi-caret-left toggle" aria-label="Alternar menú"></i>
</header> --}}
            <header class="px-3 pt-3 d-flex align-items-center justify-content-between bg- text-white rounded-3 shadow-sm">
                <!-- Icono o logo opcional -->
                <div class="d-flex align-items-center p-2 text-truncate overflow-hidden text-dark">
                    <i class="bi bi-building fs-3 me-2"></i> <!-- Ícono representativo, por ejemplo hospital/edificio -->
                    <span class="   fs-5 fw-bold">Gestión de <br> Activos Fijos</span>
                </div>

                <!-- Toggle menú -->
                <i class="bi fs-2 bi-caret-left toggle" aria-label="Alternar menú"></i>
            </header>
            <hr>
            <li class="nav-item bg-light rounded-4 my-0 p-0" style="max-width: 220px;">
                <a href="{{ route('user.panel') }}" role="menuitem"
                    class="cargar nav-link d-flex align-items-center py-2 px-3">
                    <i class="bi bi-speedometer2 me-2 fs-5"></i>
                    <span class="fw-semibold text-truncate overflow-hidden ps-4">Dashboard</span>
                </a>
            </li>

            <hr>
            <ul class="menu pb-5 mb-5 bg-dadnger" role="menubar">









                <br>
                {{--

                <br>
<br>
 --}}




                <!-- ====================== -->
                <!-- MÓDULO: ACTIVOS FIJOS -->
                <!-- ====================== -->

                <li class="menu-item" data-submenu="submenuActivos" role="btn">
                    <div class="main-item bg-success bg-opacity-10" tabindex="0" role="menuitem" aria-haspopup="true"
                        aria-expanded="false" aria-controls="submenuActivos">
                        <i class="bi bi-boxes icon" aria-hidden="true"></i>
                        <span class="text">Activos Fijos</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuActivos">
                        <li><a href="{{ route('activos.index') }}" role="menuitem" class="cargar" id="primario">Listar
                                Activos</a></li>
                        {{-- <li><a href="{{ route('activos.create') }}" role="menuitem" class="cargar">Registrar Activo</a></li> --}}
                        <li><a href="{{ route('bajas.create') }}" role="menuitem" class=" desactivado cargar">Dar de Baja Activo</a></li>
                        <li><a href="{{ route('activos.historial') }}" role="menuitem" class="cargar">Historial de
                                activo</a></li>

                        {{-- <li><a href="#" role="menuitem">Dar de Baja Activo</a></li> --}}
                        <li><a href="#" role="menuitem"></a></li>
                        <li><a href="{{ route('traslados.show') }}" role="menuitem" class="cargar">Realizar Traslado</a>
                        </li>
                        <li><a href="{{ route('entregas.show') }}" role="menuitem" class="cargar">Realizar Entrega</a></li>
                        {{-- <li><a href="{{ route('devolucion.show', ['id' => 1 ?? 1]) }}" role="menuitem"
                                class="cargar">Registrar Devolución</a></li> --}}
                        <li><a href="{{ route('devolucion.show') }}" role="menuitem" class="cargar">Registrar Devolución</a>
                        </li>

                        {{-- <li><a href="#" role="menuitem"></a></li> --}}
                    </ul>
                </li>

                <!-- ====================== -->
                <!-- MÓDULO: ENTREGAS Y ACTAS -->
                <!-- ====================== -->
                <li class="menu-item" data-submenu="submenuEntregas" role="none">
                    <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                        aria-controls="submenuEntregas">
                        <i class="bi bi-rocket-takeoff icon" aria-hidden="true"></i>
                        <span class="text">Entregas y Actas</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuEntregas">
                        {{-- <li><a href="{{ route('entregas.create') }}" role="menuitem" class="cargar">Crear Entrega</a></li>
                        <li><a href="{{ route('entregas.realizar') }}" role="menuitem" class="cargar">Realizar Entrega</a> --}}
                </li>
                <li><a href="#" class="desactivado" role="menuitem">Listar Actas Generadas</a></li>
            </ul>
            </li>

            <!-- ====================== -->
            <!-- MÓDULO: INVENTARIOS -->
            <!-- ====================== -->
            <li class="menu-item" id="mainMenuBtn" data-submenu="submenuInventario" role="none">
                <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                    aria-controls="submenuInventario">
                    <i class="bi bi-clipboard-data icon" aria-hidden="true"></i>
                    <span class="text">Inventarios</span>
                    <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                </div>
                <ul class="submenu" id="submenuInventario">
                    <li><a href="#" class="desactivado" role="menuitem">Realizar Inventario</a></li>
                    <li><a href="{{ route('inventario.consultar') }}" role="menuitem" class="cargar">Consultar
                    <li><a href="{{ route('inventario.show') }}" role="menuitem" class="cargar">inventario</a></li>
                    <li><a href="{{ route('user.parametros') }}" role="menuitem" class="cargar">Gestión de
                            parametros</a></li>
                    <li><a href="{{ route('pruebas') }}" role="menuitem" class="cargar">prueba interfaces</a></li>
                </ul>
            </li>

            <!-- ====================== -->
            <!-- MÓDULO: REPORTES -->
            <!-- ====================== -->
            <li class="menu-item" data-submenu="submenuReportes" role="none">
                <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                    aria-controls="submenuReportes">
                    <i class="bi bi-graph-up icon" aria-hidden="true"></i>
                    <span class="text">Reportes</span>
                    <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                </div>
                <ul class="submenu" id="submenuReportes">
                    <li><a href="#" class="desactivado" role="menuitem">Reportes de Activos</a></li>
                    <li><a href="#" class="desactivado" role="menuitem">Reportes por Responsable</a></li>
                    <li><a href="#" class="desactivado" role="menuitem">Reportes Globales</a></li>
                </ul>
            </li>

            </ul>

            <div class="mb-3 d-flex flex-column align-items-center gap-1" style="max-width:300px;">
                <button id="btnRestablecerRutas" class="btn btn-danger">Restablecer todas las rutas</button>

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
            @include('user.panelControl')
        </div>
    </div>


    <script>
        function activarRutaMenu(rutaGuardada) {
    // alert(rutaGuardada)
    if (!rutaGuardada) return;

    const enlace = $(`.menu a[href='${rutaGuardada}']`);

    if (enlace.length) {
        // Subimos hasta el menu-item
        const menuItem = enlace.closest('.menu-item');

        if (menuItem.length) {
            // Buscar el .main-item dentro del menu-item
            const mainItem = menuItem.find('.main-item').first();

            // Simular el "clic" para que se abra el submenu
            if (mainItem.length) {
                mainItem.trigger('click');
            }
        }

        // Añadir clase selected al enlace encontrado
        enlace.addClass('selected');

        // Luego cargar el contenido normalmente
        cargarContenido(rutaGuardada);
    } else {
        mensaje('La ruta guardada no se encontró en el menú.', 'danger');
    }
}
        const baseUrl = "{{ url('/') }}";
        const key = 'rutaDefecto';
        const guardar = ruta => localStorage.setItem(key, ruta);
        const leer = () => localStorage.getItem(key);
        const rutaGuardada = leer();

        $(document).ready(function() {
            activarRutaMenu(rutaGuardada);

            // if (rutaGuardada) {
            //     const enlace = $(`.menu a[href='${rutaGuardada}']`);
            //     if (enlace.length) {
            //         // Subimos hasta el menu-item
            //         const menuItem = enlace.closest('.menu-item');

            //         if (menuItem.length) {
            //             // Buscar el .main-item dentro del menu-item
            //             const mainItem = menuItem.find('.main-item').first();

            //             // Simular el "clic" para que se abra el submenu
            //             if (mainItem.length) {
            //                 mainItem.trigger('click');
            //             }
            //             // Añadir clase selected al enlace encontrado
            //             enlace.addClass('selected');
            //         }

            //         // Luego cargar el contenido normalmente
            //         cargarContenido(rutaGuardada);
            //     } else {
            //         mensaje('La ruta guardada no se encontró en el menú.', 'danger');
            //     }

            // }
            /**
 * Selecciona y activa un enlace del menú según la ruta guardada
 * @param {string} rutaGuardada - URL o ruta a seleccionar
 */



            function buscarEnlace(texto) {
                const lower = texto.toLowerCase();
                return $('.menu a').filter(function() {
                    return $(this).text().toLowerCase().includes(lower);
                }).first();
            }

            // Mostrar menú contextual al hacer click derecho sobre li dentro de submenu
            $('.submenu > li').on('contextmenu', function(e) {
                e.preventDefault();
                const $contextMenu = $('#customContextMenu');
                $contextMenu.data('targetElement', this);
                $contextMenu.focus()
                const $li = $(this);
                const offset = $li.offset();
                const liWidth = $li.outerWidth();

                $contextMenu.css({
                    display: 'block',
                    top: offset.top,
                    left: offset.left + liWidth
                }).attr('aria-hidden', 'false');

                return false;
            });

            // Ocultar menú contextual al hacer clic fuera
            $(document).on('click', function(e) {
                const $contextMenu = $('#customContextMenu');
                if (!$(e.target).closest('#customContextMenu').length) {
                    $contextMenu.hide().attr('aria-hidden', 'true');
                }
            });

            // Botón "Hacer predeterminada"
            // En el botón "Hacer predeterminada"
            $('#makeDefaultBtn').on('click', function(e) {
                e.preventDefault();
                const $contextMenu = $('#customContextMenu');
                const $target = $contextMenu.data('targetElement');
                if (!$target) {
                    mensaje('No se pudo identificar el elemento seleccionado.', 'danger');
                    $contextMenu.hide();
                    return;
                }

                const texto = $target.textContent.trim();
                const enlace = buscarEnlace(texto);

                if (!enlace.length) {
                    mensaje('No se encontró el ítem en el menú para guardar.', 'danger');
                    $contextMenu.hide();
                    return;
                }

                const href = enlace.attr('href');
                if (!href || href === '#' || href.trim() === '') {
                    mensaje('El ítem seleccionado no tiene una ruta válida.', 'danger');
                    $contextMenu.hide();
                    return;
                }

                guardar(href);
                mensaje('Ruta guardada como predeterminada.', 'success');
                //   cargarContenido(href);
                $contextMenu.hide();
            });

            $('#btnRestablecerRutas').on('click', function() {
                localStorage.removeItem('rutaDefecto'); // borra solo esa ruta guardada
                mensaje('Se han restablecido todas las rutas guardadas.', 'success');

                // Opcional: recargar contenido predeterminado o página si quieres
                // location.reload(); // si quieres refrescar la página para que el cambio se note
            });


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
                    const allCollapsed = $sidebarWrapper.children('.sidebar-col').length === $sidebarWrapper
                        .children(
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
        //todo esto cierra los modales correctamente
        $('.modal').on('click', function(e) {
            if ($(e.target).is('.modal')) {
                $(this).find('input, select, textarea, button').blur();
                console.log('Click fuera del modal, cerrándolo...');
                $(this).blur()
                $(this).find('button[data-bs-dismiss="modal"]').trigger('click');
            }
        });
        $(document).on('click', '.modal .btn-close[data-bs-dismiss="modal"]', function() {
            console.log('Se hizo clic en el botón X del modal Registrar Activo');
            $(this).blur(); // Quita el foco del botón X
            // alert($('.modal fade show').html()) // Quita el foco del botón X
        });



        function reset(formSelector) {
            formSelector[0].reset();
        }

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
