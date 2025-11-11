@extends('layout')
@section('contenido')
    <style>
        /* estilso de modal  */
.modal-custom {
    background: var(--color-fondo);
    border-radius: var(--border-radius-tarjeta);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    border: 1px solid var(--tarjeta-borde-color);
}

.modal-header-custom {
    background: var(--color-primario);
    color: var(--color-boton-texto);
    border-top-left-radius: var(--border-radius-tarjeta);
    border-top-right-radius: var(--border-radius-tarjeta);
    padding: 1rem 1.5rem;
}

.modal-footer-custom {
    border-top: 1px solid var(--tarjeta-borde-color);
    background: var(--color-fondo-secundario);
    border-bottom-left-radius: var(--border-radius-tarjeta);
    border-bottom-right-radius: var(--border-radius-tarjeta);
}

.input-custom {
    background: var(--color-input-fondo);
    color: var(--color-input-texto);
    border: 1px solid var(--tarjeta-borde-color);
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    transition: border-color var(--duration) var(--efecto);
}

.input-custom:focus {
    border-color: var(--color-input-borde-led);
    outline: none;
    box-shadow: 0 0 0 2px rgba(105, 122, 254, 0.2);
}

.btn-custom {
    background: var(--color-boton-fondo);
    color: var(--color-boton-texto);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: background var(--duration) var(--efecto);
}

.btn-custom:hover {
    background: var(--color-link-hover);
}

.btn-cancel {
    background: transparent;
    color: var(--color-primario);
    border: 1px solid var(--color-primario);
    border-radius: 8px;
    padding: 0.5rem 1rem;
    transition: all var(--duration) var(--efecto);
}

.btn-cancel:hover {
    background: var(--color-primario);
    color: var(--color-boton-texto);
}

    </style>

    <div class="col-auto">
        <nav class="sidebar d-flex flex-column flex-shrink: 0;" aria-label="Menú de navegación principal">
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
                <a href="{{ route('admin.panel') }}" role="menuitem"
                    class="cargar nav-link d-flex align-items-center py-2 px-3">
                    <i class="bi bi-speedometer2 me-2 fs-5"></i>
                    <span class="fw-semibold text-truncate overflow-hidden ps-4">Dashboard</span>
                </a>
            </li>

            <ul class="menu " role="menubar">
                <!-- Gestión de Usuarios -->
                <li class="menu-item" data-submenu="submenuUsuarios" role="none">
                    <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                        aria-controls="submenuUsuarios">
                        <i class="bi bi-people icon" aria-hidden="true"></i>
                        <span class="text">Usuarios</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuUsuarios" role="menu" aria-label="Submenú Usuarios">
                        <li role="none">
                            <a href="{{ route('usuarios.create') }}" role="menuitem" class="cargar">Crear Usuario</a>
                        </li>
                        <li role="none">
                            <a href="{{ route('responsable.index') }}" role="menuitem" class="cargar">Listar personal</a>
                        </li>
                        <li role="none">
                            <a href="{{ route('usuarios.index') }}" role="menuitem" class="cargar">Listar Usuarios</a>
                        </li>
                        <li role="none">
                            <a href="#" data-url="/usuarios/roles" role="menuitem" class="cargar">Roles y Permisos</a>
                        </li>
                    </ul>
                </li>

                <!-- Gestión de Activos Fijos -->
                {{-- <li class="menu-item" data-submenu="submenuActivos" role="none">
                    <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                        aria-controls="submenuActivos">
                        <i class="bi bi-boxes icon" aria-hidden="true"></i>
                        <span class="text">Activos Fijos</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuActivos" role="menu" aria-label="Submenú Activos Fijos">
                        <li role="none"><a href="#" role="menuitem" class="cargar">Listar Activos</a></li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Registrar Activo</a></li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Dar de Baja</a></li>
                    </ul>
                </li> --}}

                <!-- Categorías y Unidades -->
                <li class="menu-item" data-submenu="submenuCategorias" role="none">
                    <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                        aria-controls="submenuCategorias">
                        <i class="bi bi-tags icon" aria-hidden="true"></i>
                        <span class="text">Categorías y Unidades</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuCategorias" role="menu" aria-label="Submenú Categorías y Unidades">
                        <li role="none"><a href="#" role="menuitem" class="cargar">Gestionar Categorías</a></li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Gestionar Unidades</a></li>
                    </ul>
                </li>

                <!-- Proveedores y Donantes -->
                <li class="menu-item" data-submenu="submenuProveedores" role="none">
                    <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                        aria-controls="submenuProveedores">
                        <i class="bi bi-building icon" aria-hidden="true"></i>
                        <span class="text">Proveedores y Donantes</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuProveedores" role="menu"
                        aria-label="Submenú Proveedores y Donantes">
                        <li role="none"><a href="#" role="menuitem" class="cargar">Gestionar Proveedores</a>
                        </li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Gestionar Donantes</a></li>
                    </ul>
                </li>

                <!-- Entregas y Devoluciones -->
                {{-- <li class="menu-item" data-submenu="submenuEntregas" role="none">
                    <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                        aria-controls="submenuEntregas">
                        <i class="bi bi-card-checklist icon" aria-hidden="true"></i>
                        <span class="text">Entregas y Devoluciones</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuEntregas" role="menu"
                        aria-label="Submenú Entregas y Devoluciones">
                        <li role="none"><a href="#" role="menuitem" class="cargar">Realizar Entrega</a></li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Registrar Devolución</a>
                        </li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Consultar Entregas</a></li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Consultar Devoluciones</a>
                        </li>
                    </ul>
                </li> --}}

                <!-- Inventarios y Movimientos -->
                {{-- <li class="menu-item" data-submenu="submenuInventarios" role="none">
                    <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                        aria-controls="submenuInventarios">
                        <i class="bi bi-clipboard-data icon" aria-hidden="true"></i>
                        <span class="text">Inventarios y Movimientos</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuInventarios" role="menu"
                        aria-label="Submenú Inventarios y Movimientos">
                        <li role="none"><a href="" role="menuitem" class="cargar">Realizar Inventario</a></li>
                        <li role="none"><a href="" role="menuitem" class="cargar">Consultar Inventario</a>
                        </li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Transferir Activo</a></li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Consultar Movimientos</a>
                        </li>
                    </ul>
                </li> --}}

                <!-- Configuración del Sistema -->
                <li class="menu-item" data-submenu="submenuConfig" role="none">
                    <div class="main-item" tabindex="0" role="menuitem" aria-haspopup="true" aria-expanded="false"
                        aria-controls="submenuConfig">
                        <i class="bi bi-gear icon" aria-hidden="true"></i>
                        <span class="text">Configuración</span>
                        <i class="bi bi-caret-down caret" aria-hidden="true"></i>
                    </div>
                    <ul class="submenu" id="submenuConfig" role="menu" aria-label="Submenú Configuración">
                        <li role="none"><a href="#" role="menuitem" class="cargar">Parámetros del Sistema</a>
                        </li>
                        <li role="none"><a  role="menuitem" class="cargar">Backup y Restauración</a>
                        </li>
                        <li role="none"><a href="#" role="menuitem" class="cargar">Auditoría</a></li>
                    </ul>
                </li>
            </ul>
            <li class="menu-item  list-unstyled">
                <a href="#" class="main-item dropdown-toggle d-flex align-items-center gap-2 text-decoration-none"
                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <i class="bi bi-person-circle icon fs-5 text-primary"></i>
            <span class="text">Juanito</span> --}}
                    <i class="bi bi-person-circle fs-5 icon"></i>
                    <span class="text text-truncate" style="max-width: 80%">
                        {{-- usuario o sea yo xdddddd --}}
                        {{Auth::user()->usuario }}
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
    <!-- admin.blade.php -->

    <div class="col ">
        <div class="barra-progreso-contenedor">
            <div id="miBarra" class="barra-progreso "></div>
        </div>
        <div id="mensaje" class="w-100"></div>
        <div id="contenido" class="bg-fdanger flex-grow-1 p-4 m-0 ">
            @include('user.panelControl')
            {{-- <div id="mensaje" class="w-100"></div> --}}
            <h2>Panel de Administración</h2>
            <p>Selecciona una opción del menú para comenzar hh.</p>
            <button onclick="mensaje('Esto es una alerta exitosa', 'success')" class="btn btn-success">Mostrar
                Success</button>
            <button onclick="mensaje('Esto es una alerta de error', 'danger')" class="btn btn-danger">Mostrar
                Error</button>
            <button onclick="mensaje('Esto es una advertencia', 'warning')" class="btn btn-warning">Mostrar
                Warning</button>
            <button onclick="mensaje('Esto es una información', 'info')" class="btn btn-info text-white">Mostrar
                Info</button>

        </div>
    </div>





    @endsection
    @push('scripts')
    <script>


// $(document).ready(function() {
//     $('#contenido').on('click', '#gg', function(e) {

// mensaje('Esto es una alerta exitosa', 'success');
//     });
//     $('#contenido').on('focus', '#contenido', function(e) {

// mensaje('Esto es una alerta exitosa', 'success');
//     });
// });


        // $('.cargar').click(function(e) {
        //     e.preventDefault();
        //     let url = $(this).data('url');
        //     if (!url) return;

        //     $.get(url, function(data) {
        //         $('#contenido').html(data);
        //     }).fail(function() {
        //         $('#contenido').html('<p>Error al cargar contenido.</p>');
        //     });
        // });
        // window.mensaje = function(mensaje, tipo) {
        function mensaje(mensaje, tipo) {
            var nuevaAlerta = $('<div class="alert alert-' + tipo +
            ' alert-dismissible fade show" role="alert" ><strong>' + mensaje +
                '</strong> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button></div>'
            );
            $("#mensaje").append(nuevaAlerta);
            console.log(mensaje);
            if ($("#mensaje .alert-flotante").length > 10) {
                $("#mensaje .alert-flotante").first().remove();
            }
            setTimeout(function() {
                nuevaAlerta.remove();
            }, 7000);
        };
//         $('#contenido').on('click', '#gg', function(e) {

// mensaje('Esto es una alerta exitosa', 'success');
// });

//         mensaje('Esto es una alerta exitosa', 'success');
        // Manejo de selección y carga de contenido para links
        // sidebar.querySelectorAll('ul.submenu li a').forEach(link => {
        //     link.addEventListener('click', e => {
        //         e.preventDefault();

        //         // Remover seleccionado anterior
        //         sidebar.querySelectorAll('ul.submenu li a.selected').forEach(el => el.classList.remove(
        //             'selected'));

        //         link.classList.add('selected');

        //         // Aquí puedes cargar contenido dinámico, ejemplo:
        //         // const contenido = document.getElementById('contenido');
        //         // contenido.innerHTML =
        //         //     `<h2>${link.textContent}</h2><p>Contenido para "${link.textContent}" cargado.</p>`;
        //     });
        // });
    </script>
    @endpush
{{--
@push('scripts')
holaaa
@endpush --}}
