<style>
    /* .input-form {
        background-color: var(--color-input-fondo);
        color: var(--color-input-texto);
    }
    #paginadorExterno .paginate_button {
  padding: 4px 8px;
  margin: 0 2px;
  font-size: 0.1rem;
  border-radius: 4px;
} */
    #userList th,
    #userList td {
        white-space: nowrap;
        /* evita salto de línea */
    }

    #paginadorExterno .paginate_button {
        /* background-color: #697afe;  */
        color: white;
        min-width: max-content;
        font-weight: bold;
        font-size: 0.2rem;
        /* padding: 0.375rem 0.9rem !important; */
        margin-top: 10%
            /* min-width: 40px;  */
    }

    #paginadorExterno .paginate_button .page-link {
        /* background-color: #697afe;  */
        font-size: 0.5rem;
        /* margin: 0%; */

    }

    #paginadorExterno .paginate_button:hover {
        background-color: #4d5be1 !important;
        color: white;
        cursor: pointer;
    }

    /* .flotante {
        position: sticky !important;
        left: 0;
        right: 0;
        background: var(--color-fondo-secundario);

        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        z-index: 1050;
        padding: 0.5rem 1rem;
        border-radius: 0 0 18px 18px;

        }*/

    .flotante {
        /* margin:20px; */
        margin-top: 20px;
        position: sticky;
        /* top: 600px; */
        /* ajustar a la altura real del contenido superior */
        /* background: var(--color-fondo-secundario); */
        background: rgba(98, 98, 238, 0.3);
        /* Transparencia */
        backdrop-filter: blur(10px);
        /* Difuminar lo que está detrás */
        -webkit-backdrop-filter: blur(3px);
        /* Safari/Chrome */
        /* background: red; */
        /* background: var(--color-fondo-secundario); */
        z-index: 1050;
        width: 100%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        /* margin: auto; */
        bottom: 40px;
        overflow-y: none;
        border-radius: 18px;
        padding: 0.5rem 0.5rem;
    }
</style>
{{-- @extends('layout') --}}
<!-- Modal -->
<div class="modal fade" id="userEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content"
            style="background-color: var(--color-fondo); border-radius: var(--border-radius-tarjeta); border: 1px solid var(--tarjeta-borde-color); box-shadow: 0 6px 20px rgba(0,0,0,0.1);">
            <div class="modal-header"
                style="background-color: var(--color-primario); color: var(--color-boton-texto); border-top-left-radius: var(--border-radius-tarjeta); border-top-right-radius: var(--border-radius-tarjeta);">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarUsuario">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id_usuario">

                    <div class="mb-3">
                        <label>Responsable</label>
                        <input type="text" id="edit_responsable" class="form-control" readonly
                            style="background-color: var(--color-input-fondo); color: var(--color-input-texto); border: 1px solid var(--tarjeta-borde-color); border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                        <label>Usuario</label>
                        <input type="text" id="edit_usuario" name="usuario" class="form-control"
                            style="background-color: var(--color-input-fondo); color: var(--color-input-texto); border: 1px solid var(--tarjeta-borde-color); border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                        <label>Rol</label>
                        <input type="text" id="edit_rol" name="rol" class="form-control"
                            style="background-color: var(--color-input-fondo); color: var(--color-input-texto); border: 1px solid var(--tarjeta-borde-color); border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                        <label>Estado</label>
                        <select id="edit_estado" name="estado" class="form-select"
                            style="background-color: var(--color-input-fondo); color: var(--color-input-texto); border: 1px solid var(--tarjeta-borde-color); border-radius: 8px;">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer"
                    style="background-color: var(--color-fondo-secundario); border-top: 1px solid var(--tarjeta-borde-color); border-bottom-left-radius: var(--border-radius-tarjeta); border-bottom-right-radius: var(--border-radius-tarjeta);">
                    <button type="submit" class="btn btn-success"
                        style="background-color: var(--color-boton-fondo); color: var(--color-boton-texto); border:none; border-radius: 8px; padding: 0.5rem 1rem;">Guardar
                        cambios</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="background-color: transparent; color: var(--color-primario); border: 1px solid var(--color-primario); border-radius: 8px; padding: 0.5rem 1rem;">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>







<div class="row">



    <div id="principal" class="col-md-12 col-lg-12  text-white">


        {{-- <form action="" method="post"> --}}
        <div id="card2" class="card mt-4 p-4 rounded shadow "
            style="background-color: var(--color-fondo);;
             min-height:88vh; max-height:88vh; position: relative;
            display: flex;
            flex-direction: column;
            flex-wrap: no-wrap;">
            {{-- style="background-color: var(--color-fondo);  min-height:90vh;" --}}
            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Lista de usuarios</h2>






            <div class="row mb-3 align-items-center">
                <div class="col-12 col-md-6"></div> <!-- espacio vacío a la izquierda -->

                <div class="col-12 col-md-6 d-flex justify-content-end gap-2">


                    <input type="search" id="inputSearch" class="form-control form-control-sm"
                        placeholder="Buscar por CI, usuario..." style="max-width: 280px;">
                    <button id="userSearch" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>



            <!-- Aquí iría tu tabla -->

            {{-- </div> --}}
            {{-- <div class="form-check form-switch mb-4">
                <button type="submit" class="btn text-nowrap " id="crear"
                    style="min-width: max-content;background-color: var(--color-boton-fondo);  color: var(--color-boton-texto);">
                    Creard usuario
                </button>
            </div> --}}
            <div class="row " style="flex-grow: 1; overflow-y: auto; ">
                <div class="col-lg-12 overflow-x: auto;">
                    <table class='table-sm table-striped table-rounded ' id="userList">
                        <thead class='sticky-top bg-light'>
                            <tr>
                                {{-- <th><input type="checkbox" id="checkAll"></th> --}}
                                <th></th>
                                <th>responsable</th>
                                <th>Nombre de usuario</th>
                                <th>Rol</th>
                                <th>estado</th>
                                <th>acciones</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td><input type="checkbox" class="user-checkbox" value="{{ $usuario->id_usuario }}">
                                    </td>
                                    <td>{{ $usuario->responsable->nombre }}</td>
                                    <td>{{ $usuario->usuario }}</td>
                                    <td>{{ $usuario->rol }}</td>
                                    <td>{{ $usuario->estado }}</td>
                                    <td>
                                        <button class='btn btn-editar' data-id="{{ $usuario->id_usuario }}"
                                            data-responsable="{{ $usuario->responsable->nombre }}"
                                            data-usuario="{{ $usuario->usuario }}" data-rol="{{ $usuario->rol }}"
                                            data-estado="{{ $usuario->estado }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class='btn btn-danger btn-eliminar'
                                            data-id="{{ $usuario->id_usuario }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>















































                </div>
            </div>
            <div id="fila1">

                <div class="row d-flex flex-row  gx-1 mb-1 align-items-center  gap-1 flex-nowrap"
                    style="font-size: 0.6rem; ">
                    <div id="paginadorExterno"
                        class=" d-flex flex-nowrap align-items-center justify-content-between justify-content-center gap-2 align-items-center">
                    </div>
                </div>



                <div class="row align-items-center gx-1 mb-1">

                    <div class="col-12 col-md-7 d-flex align-items-center gap-2 flex-wrap">
                        <div class="form-check me-3">
                            <input type="checkbox" class="form-check-input" id="checkAll">
                            <label class="form-check-label" for="checkAll"
                                style="user-select:none; font-size: 0.9rem;">Seleccionar todos</label>
                        </div>

                        <select id="accionMasiva" class="form-select form-select-sm w-auto"
                            style="min-width: 160px;">
                            <option value="" selected>-- Seleccionar acción --</option>
                            <option value="inactivar">Poner en Inactivo</option>
                            <option value="activar">Poner en Activo</option>
                            <option value="eliminar">Eliminar</option>
                            <option value="restablecer">Restablecer contraseña</option>
                        </select>

                        <button id="btnAplicarAccion" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                            <i class="bi bi-check-circle"></i> Aplicar
                        </button>
                    </div>

                <div class="col-3 col-md-2 d-flex align-items-center gap-2 flex-wrap">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="toggleFlotante">
                        <label class="form-check-label text-nowrap" for="toggleFlotante" style="user-select:none;">extender tabla</label>
                    </div>
                    </div>

                    <div class="col-12 col-md-3 d-flex justify-content-md-end align-items-center gap-2 mt-3 mt-md-0">
                        <label for="selectFilas" class="mb-0"
                            style="color: var(--color-texto-principal); font-size: 0.9rem;">Mostrar por:</label>
                        <select id="selectFilas" class="form-select form-select-sm w-auto">
                            <option value="1">1 filas</option>
                            <option value="5">5 filas</option>
                            <option value="10">10 filas</option>
                            <option value="20">20 filas</option>
                            <option value="50">50 filas</option>
                            <option value="100">100 filas</option>
                        </select>
                    </div>

                </div>

            </div>

        </div>
        <div class="col-12 col-md-2 text-white">

        </div>
    </div>



    {{-- <div class="card mt-4 p-4 rounded shadow col-1" style="background-color: var(--color-fondo);  min-height:90vh;">fdsafdafda</div> --}}


</div>
{{-- @extends('layout') --}}
{{-- @push('scripts')> --}}
<script>
    // $('#toggleFlotante').on('change', function() {
    //     if ($(this).is(':checked')) {
    //         // alert("hodsfdosa")
    //         $('.card').css('max-height', 'none');
    //         // Medir la altura del contenido que está arriba
    //         let alturaFila1 = $('#fila1').outerHeight();
    //         // Aplicar sticky con top ajustado
    //         // $('#fila1, #fila2').appendTo('#principal');
    //         $('#fila1').addClass('flotante');


    //     } else {
    //         // $('#fila1, #fila2').appendTo('#card2');
    //         $('.card').css('max-height', '88vh');
    //         $('#fila1').removeClass('flotante');
    //     }
    // });












    var table = $('#userList').DataTable({
        dom: 'rtip', // o el que quieras
        lengthMenu: [1, 5, 10, 20, 50],
        pageLength: 10,
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ filas",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            paginate: {
                previous: "Anterior",
                next: "Siguiente"
            }
        },
        pagingType: 'simple_numbers',
    });
    $('.dataTables_paginate, .dataTables_info').appendTo('#paginadorExterno');
    $('#userSearch').on('click', function() {
        var valorBusqueda = $('#inputSearch').val();
        table.search(valorBusqueda).draw();
    });
    $('#selectFilas').on('change', function() {
        var filas = parseInt($(this).val(), 10);
        table.page.len(filas).draw();
        // alert(filas)
    });

    $('#checkAll').on('change', function() {
        $('.user-checkbox').prop('checked', $(this).prop('checked'));
    });

    $(".btn-editar").on("click", function() {
        // alert("fdsafdsaf")
        $("#edit_id").val($(this).data("id"));
        $("#edit_responsable").val($(this).data("responsable"));
        $("#edit_usuario").val($(this).data("usuario"));
        $("#edit_rol").val($(this).data("rol"));
        $("#edit_estado").val($(this).data("estado"));

        $("#userEdit").modal("show");
    });
    $(".btn-eliminar").on('click', function() {
        let id = $(this).data('id');

        if (confirm('¿Seguro que deseas eliminar este usuario?')) {
            $.ajax({
                url: '/usuarios/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Usuario eliminado');
                    location.reload();
                },
                error: function() {
                    alert('Error al eliminar');
                }
            });
        }
    });
    // $("#formEditarUsuario").on("submit", function(e) {
    //     e.preventDefault();

    //     $.ajax({
    //         url: "/usuarios/editar", // Ruta en Laravel
    //         method: "POST",
    //         data: $(this).serialize(),
    //         success: function(res) {
    //             mensaje2("Usuario actualizado correctamente", 'success');
    //             // location.reload(); // Recarga la tabla
    //         },
    //         error: function(err) {
    //             mensaje2("Error al actualizar el usuario", 'error');
    //             console.error(err);
    //         }
    //     });
    // });
</script>


{{-- @endpush --}}
