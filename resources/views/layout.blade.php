<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Hospital App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <style>
        .btn-editar {
            background-color: var(--color-boton-fondo);
            color: var(--color-boton-texto);
            transition: background-color 0.5s ease;
        }

        .btn-editar:hover {
            background-color: var(--color-boton-fondo);
            filter: brightness(90%);
            transform: scale(1.1);
        }

        #mensaje {
            position: fixed;
            display: flex;
            justify-content: end;
            bottom: 20px;
            /* top: 20px; */
            right: 20px;
            z-index: 999 !important;
            max-width: 13%;
            font-size: 0.9rem;
            /* margin: 10px; */
            display: flex;
            flex-direction: column;
            gap: 0px;
            height: auto;
            min-height: 60vh;
            max-height: 60vh;
            /* background-color: red; */
            transition: 2s;
            padding-bottom: 2%;
            /* transition: all 0.3s ease; Para una animación suave */
            pointer-events: none;
        }

        #mensaje {
            mask-image: linear-gradient(to top, rgba(255, 255, 255, 1) 80%, rgba(255, 255, 255, 0) 100%);
        }

        #mensaje .alert {
            pointer-events: auto;
        }

        :root {
            --color-fondo: #ffffff;
            --color-fondo-secundario: rgba(230, 230, 230, 1);
            --color-tarjeta-fondo: var(--color-fondo);
            --tarjeta-borde-color: rgba(92, 92, 92, 0.489);
            --color-texto-principal: rgb(1, 0, 0);
            --color-input-fondo: #ffffff;
            --color-input-texto: rgb(1, 0, 0);
            --color-input-placeholder: rgba(92, 92, 92, 0.489);
            --color-input-borde-led: #697afe;
            --color-boton-fondo: #697afe;
            --color-boton-texto: #ffffff;
            --color-link: #697afe;
            --color-link-hover: #4d5be1;
            --ancho-tarjeta: 460px;
            --border-radius-tarjeta: 12px;
            --font-size-titulo: 2.4rem;
            --font-weight-titulo: 700;
            --duration: 0.5s;
            --efecto: ease;
            --text-color: rgb(0, 0, 0);
            --color-primario: #697afe;
            --color-temp: rgba(92, 92, 92, 0.489);
        }

        body {
            /* background: url("{{ asset('img/hwk.jpg') }}") no-repeat center center fixed; */
            background-size: cover;
            min-height: 100vh;
            height: 100vh;
            max-height: 100vh;
            padding: 0px;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--color-texto-principal);
            overflow-x: hidden;
            min-width: 0;
            max-height: 50vh;
        }

        body::before {
            content: "";
            max-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("{{ asset('/img/hwk.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            filter: blur(18px);
            z-index: -1;
        }

        #contenido {
            background-color: var(--color-fondo-secundario);
            max-width: 100%;
            width: 100%;
            min-width: 0;
            height: 100vh;
            max-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            /* scroll vertical solo si es necesario */
            padding: 1rem;
            word-break: break-word;
            overflow-wrap: break-word;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE y Edge */
        }

        #contenido::-webkit-scrollbar {
            display: none;
        }


        .sidebar {
            /* position: fixed; */
            top: 0;
            left: 0;
            height: 100vh;
            max-height: 100vh;
            width: 250px;
            background-color: var(--color-fondo);
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 10px 15px;
            display: flex;
            flex-direction: column;
            /* transition: width var(--duration) cubic-bezier(0.4, 0, 0.2, 1); */
            overflow: visible;
            z-index: 1000;
            transition: var(--duration);
            position: relative;
        }

        .sidebar.close {
            width: 80px;
        }

        .sidebar header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-right: 5px;
            position: relative;
            height: 50px;
        }

        .sidebar header .toggle {
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            display: flex;
            background-color: var(--color-fondo);
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 1.8rem;
            color: var(--color-primario);
            user-select: none;
            transition: transform 0.4s ease;
            transition: background-color 0.7s ease-out;

            position: absolute;
            top: 50%;
            width: 50px;
            height: 50px;
            right: -15%;
            z-index: 1001;
            /* transform: translateY(-50%); */
        }

        .sidebar.close header .toggle {
            right: 1%;

            transform: translateY(-50%) rotate(180deg);
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0);
            background-color: var(--color-fondo-secundario);
        }

        ul.menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
            /* background-color: red; */
            mask-image: linear-gradient(to bottom, rgb(243, 14, 14) 80%, rgba(255, 255, 255, 0) 100%);

        }

        ul.menu::-webkit-scrollbar {
            display: none;
        }

        li.menu-item {
            position: relative;
            user-select: none;
            margin-bottom: 5px;
        }

        li.menu-item>div.main-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 14px;
            border-radius: 50px;
            cursor: pointer;
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
            white-space: nowrap;
            overflow: hidden;
        }

        li.menu-item>div.main-item i.icon {
            min-width: 24px;
            font-size: 1.3rem;
            color: var(--color-primario);
            flex-shrink: 0;
            text-align: center;
        }

        li.menu-item>div.main-item span.text {
            flex-grow: 1;
            opacity: 1;
            transition: opacity 0.2s;
            max-width: 90%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .sidebar.close li.menu-item>div.main-item span.text {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
            /* transition: 0; */

        }

        .sidebar.close span.text {
            opacity: 0;
            max-width: 0;
            pointer-events: none;
            transition: 0.4s;
        }

        li.menu-item>div.main-item:hover:not(.selected) {
            background-color: var(--color-temp);
            color: #fff;
        }

        li.menu-item>div.main-item.selected {
            background-color: var(--color-primario);
            color: white !important;
        }

        /* Flecha submenu */
        li.menu-item>div.main-item i.caret {
            font-size: 1rem;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--color-primario);
            flex-shrink: 0;
        }

        li.menu-item.open>div.main-item i.caret {
            transform: rotate(180deg);
        }

        /* Submenu estilos */
        ul.submenu {
            list-style: none;
            margin: 0;
            padding-left: 55px;
            max-height: 0;
            overflow: hidden;
            transition: var(--duration) var(--efecto), opacity 0.1s ease;
            opacity: 0;
            /* background-color: red */
        }

        li.menu-item.open>ul.submenu {
            max-height: 600px;
            opacity: 1;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.5s ease 0.2s;
        }

        ul.submenu li a {
            display: block;
            padding: 8px 10px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-color);
            font-size: 0.9rem;
            white-space: nowrap;
            transition: background-color 0.3s, color 0.3s;
        }

        ul.submenu li a:hover,
        ul.submenu li a.selected {
            background-color: var(--color-primario);
            color: white;
        }

        .sidebar.close ul.submenu {
            padding-left: 10px;
        }

        /* Bottom content */
        /* Estilos adaptados al tema del sidebar */
        .sidebar .dropdown-toggle {
            color: var(--text-color);
            border-radius: 50px;
            padding: 10px 15px;
            transition: background-color 0.3s;
        }

        .sidebar .dropdown-toggle:hover {
            background-color: var(--color-temp);
            color: white;
        }

        .sidebar.close .dropdown-toggle .text {
            display: none;
        }



        .main-item:focus {
            outline: none;
            /* quitar el outline por defecto */
            background-color: #e7f1ff !important;
            /* fondo azul suave */
            border: 2px solid #0d6efd !important;
            /* borde azul bootstrap */
            border-radius: 6px;
            /* margin: 2px; ese margen azul que querías */
            box-sizing: border-box;
            /* para que el tamaño no se desajuste por el borde/margen */
        }

        .cargar:focus {
            outline: none;
            /* quitar el outline por defecto */
            background-color: #e7f1ff !important;
            /* fondo azul suave */
            border: 2px solid #0d6efd !important;
            /* borde azul bootstrap */
            border-radius: 19px;
            /* margin: 2px; ese margen azul que querías */
            box-sizing: border-box;/
        }
    </style>

    @yield('styles')
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- printThis -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html-docx-js/0.4.1/html-docx.js"></script> --}}

    <div class="container-fluid  p-0 m-0">
        <div class="row g-0 " style="flex-wrap: nowrap; height: 90vh; max-width: 100%; position: relative;">
            @yield('contenido')
        </div>
    </div>

    <!-- Aquí el menú contextual (inicialmente oculto) -->
    <!-- Menú contextual Bootstrap -->
    <ul id="customContextMenu" class="dropdown-menu" style="display:none; position:absolute;">
        <li><button class="dropdown-item" id="makeDefaultBtn">Hacer predeterminada</button></li>
        <li><button class="dropdown-item" id="resetBtn">Restablecer</button></li>
    </ul>


    {{-- <div id="contenido"></div> --}}



    <script>
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = sidebar?.querySelector('.toggle'); // si sidebar es null, toggleBtn será undefined
        const menuItems = sidebar?.querySelectorAll('li.menu-item') || []; // si null, devuelve array vacío
        const body = document.body;
        const key = 'rutaDefecto';
        const guardar = ruta => localStorage.setItem(key, ruta);
        const leer = () => localStorage.getItem(key);
        const rutaGuardada = leer();
        let ajaxActual = null;

        $(document).ready(function() {
            if (rutaGuardada) {
                const enlace = $(`.menu a[href='${rutaGuardada}']`);
                if (enlace.length) {
                    cargarContenido(rutaGuardada);
                } else {
                    mensaje('La ruta guardada no se encontró en el menú.', 'danger');
                }
            }

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




             // para guardar la petición activa

            function cargarContenido(url) {
                if (!url) {
                    $('#contenido').html('<p style="color:red;">No se ha proporcionado una URL.</p>');
                    return;
                }

                // Si hay una petición activa, cancelarla
                if (ajaxActual) {
                    ajaxActual.abort();
                    ajaxActual = null;
                }

                // Reiniciar barra visualmente SIN glitch
                $('#miBarra').stop(true, true).css({
                    'transition': 'none',
                    'width': '0%'
                });
                // $('#miBarra').stop(true, true).css({ 'transition': 'none', 'height': '100%' });
                $('.barra-progreso-contenedor').show();

                // Forzar reflujo para que el navegador aplique el 0%
                $('#miBarra')[0].offsetHeight;
                $('#miBarra').css('transition', 'width 0.5s ease-out');

                // Crear la nueva petición AJAX
                ajaxActual = $.ajax({
                    url: url,
                    type: "GET",
                    xhr: function() {
                        var xhr = $.ajaxSettings.xhr();

                        let width = 0;
                        // Simular progreso mientras se descarga
                        let simInterval = setInterval(() => {
                            if (width < 90) {
                                width += Math.random() * 5; // progreso visual variable
                                $('#miBarra').css('width', width + '%');
                            }
                        }, 150);

                        xhr.onprogress = function(evt) {
                            // console.log("Evento progreso recibido:", evt);
                            // console.log("lengthComputable:", evt.lengthComputable, "loaded:", evt
                            //     .loaded, "total:", evt.total);

                            if (evt.lengthComputable) {
                                let porcentaje = Math.floor((evt.loaded / evt.total) * 100);
                                $('#miBarra').css('width', porcentaje + '%');
                                // console.log("Porcentaje real:", porcentaje + "%");
                            } else {
                                // si no se puede medir, dejamos que el intervalo maneje el avance
                                // console.log(
                                //     "No se puede calcular el porcentaje (Content-Length ausente)"
                                // );
                            }
                        };

                        // Cuando termine (éxito o error), detener simulación
                        xhr.onloadend = function() {
                            clearInterval(simInterval);
                            $('#miBarra').css('width', '100%');
                            setTimeout(() => $('.barra-progreso-contenedor').fadeOut(300), 400);
                        };

                        return xhr;
                    },

                    success: function(data) {
                        // $('#contenido').html(data);
                        $('#miBarra').css('width', '100%');

                        setTimeout(() => {
                            $('#contenido').html(data);

                            // Oculta suavemente la barra
                            setTimeout(() => {
                                $('.barra-progreso-contenedor').fadeOut(300);
                                $('#miBarra').css('width', '0%');
                            }, 500);

                        }, 0); // ← 5 segundos de retraso


                        ajaxActual = null; // liberar
                    },
                    error: function(xhr, status, error) {
                        if (status !== 'abort') { // no mostrar error si fue cancelada
                            $('#contenido').html(`
                    <div style="
                        color: red;
                        padding: 10px;
                        border: 1px solid red;
                        background: #ffe6e6;
                        max-width: 100%;
                        width: fit-content;
                        word-wrap: break-word;
                        box-sizing: border-box;">
                        <strong>Error al cargar el contenido:</strong><br>
                        ${xhr.responseText}
                    </div>
                `);
                        }
                        $('#miBarra').css('width', '0%');
                        ajaxActual = null;
                    }
                });
            }





            $('.cargar').on('click', function(e) {
                e.preventDefault(); // Evita que se siga el enlace
                // Quitar clase 'selected' de otros enlaces
                $('ul.submenu li a.selected').removeClass('selected');

                // Añadir clase 'selected' al actual
                $(this).addClass('selected');


                // Obtener URL desde href o data-url
                let url = $(this).attr('href') || $(this).data('url');


                // Cargar contenido dinámico con AJAX
                cargarContenido(url)

            })


            $('.ajustes').on('click', function(e) {
                e.preventDefault();
                let url = $(this).attr('href') || $(this).data('url');
                if (!url) {
                    $('#contenido').html('<p style="color:red;">No se ha proporcionado una URL.</p>');
                    return;
                }
                $.get(url, function(data) {
                    $('#contenido').html(data);
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    $('#contenido').html(
                        `<div style="color: red;padding: 10px;border: 1px solid red;background: #ffe6e6;max-width: 100%;width: fit-content;word-wrap: break-word;box-sizing: border-box;"><strong>Error al cargar el contenido:</strong><br>
                        ${jqXHR.responseText || textStatus + ': ' + errorThrown}
                        </div>`
                    );
                });
            });



        });



        // Toggle sidebar width
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                menuItems.forEach(item => {
                    item.classList.remove('open');
                });
                // Paso 2: esperar 300ms y luego cerrar sidebar
                setTimeout(() => {
                    sidebar.classList.toggle('close');
                }, 30); // Espera igual a la transición de los submenús
            });
        }



        menuItems.forEach(item => {
            const mainItem = item.querySelector('.main-item');
            const submenu = item.querySelector('.submenu');



            mainItem.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') {
                    e.preventDefault();
                    mainItem.click(); // simula el click para reutilizar la lógica
                }
            });





            // Al cargar la página, deshabilitar tab en enlaces del submenu
            if (submenu) {
                submenu.querySelectorAll('a').forEach(link => link.setAttribute('tabindex', '-1'));
            }
            mainItem.addEventListener('click', e => {
                e.preventDefault();

                // Si sidebar minimizado, abrir sidebar para mostrar submenu
                if (sidebar.classList.contains('close')) {
                    sidebar.classList.remove('close');
                }

                const isOpen = item.classList.contains('open');

                // Cerrar todos los demás submenus y deshabilitar tab
                menuItems.forEach(i => {
                    if (i !== item) {
                        i.classList.remove('open');
                        const otherSubmenu = i.querySelector('.submenu');
                        if (otherSubmenu) {
                            otherSubmenu.querySelectorAll('a').forEach(link => link.setAttribute(
                                'tabindex', '-1'));
                        }
                    }
                });


                if (isOpen) {
                    // Cerrar este submenu y deshabilitar tab
                    item.classList.remove('open');
                    submenu.querySelectorAll('a').forEach(link => link.setAttribute('tabindex', '-1'));
                } else {
                    // Abrir submenu y habilitar tab
                    item.classList.add('open');
                    submenu.querySelectorAll('a').forEach(link => link.removeAttribute('tabindex'));
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
