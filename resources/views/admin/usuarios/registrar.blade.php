<style>
    .input-form {
        background-color: var(--color-input-fondo);
        color: var(--color-input-texto);
    }

</style>
{{-- @extends('layout') --}}

<div class="row">

    <div class="col-md-12 col-lg-2  text-white ">
        <div id="form_usuario_existente" class="card mt-4 p-4 rounded shadow d-none"
            style="background-color: var(--color-fondo);  min-height:20vh;">
            <form id="form_select" method="POST" action="" class=" mb-5">
                @csrf
                <h5 class="mb-3 text-primary">Buscar Responsable Existente</h5>
                <div class="row g-3">
                    <div class="col-md-12 col-lg-12">
                        <label for="responsable_existente" class="form-label">Responsable</label>
                        <select name="responsable_existente" id="responsable_existente" class="form-select input-form"
                            required>
                            <option value="" selected disabled>Seleccione un responsable</option>

                            @foreach ($responsables as $responsable)
                                <option value="{{ $responsable->id_responsable }}"
                                    data-nombre="{{ $responsable->nombre }}" data-ci="{{ $responsable->ci }}">
                                    {{ $responsable->nombre }} - CI {{ $responsable->ci }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="col-sm-12 col-lg-8  text-white">


        {{-- <form action="" method="post"> --}}
        <div class="card mt-4 p-4 rounded shadow " style="background-color: var(--color-fondo);  min-height:90vh;">
            <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Gestión de Usuario y
                Responsable
            </h2>

            <div class="row">
                <div class="col-md-12 flex-grow-1 col-lg-10 ">
                    <!-- Selector -->
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="toggleModoResponsable">
                        <label class="form-check-label fw-bold" for="toggleModoResponsable"
                            style="color: var(--color-texto-principal);">
                            Usar Responsable Existente
                        </label>
                    </div>

                    <!-- NUEVO RESPONSABLE -->
                    <form id="form_responsable_seleccionado" method="POST" action="" class="mb-5 d-none">
                        @csrf
                        <h5 class="mb-3 text-primary">Responsable seleccionado</h5>
                        <div class="row g-3">
                            <div class="col-6 col-md-4">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control input-form" name="nombre2" id="nombre2"
                                    placeholder="sin selccionar" required>
                            </div>
                            <div class="col-6 col-md-4">
                                <label for="ci" class="form-label">C.I.</label>
                                <input type="text" class="form-control input-form" name="ci2" id="ci2"
                                    placeholder="sin seleccionar" required>
                            </div>



                        </div>
                    </form>
                    <form id="form_responsable2" method="POST" action="{{ route('responsables.store') }}"
                        class="mb-5">
                        @csrf
                        <input type="submit" value="fdsaf" class="d-none" id="submit_responsable">
                        <h5 class="mb-3 text-primary">Nuevo Responsable</h5>
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control input-form" name="nombre" id="nombre"
                                    placeholder="Juan Pérez" required>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <label for="ci" class="form-label">C.I.</label>
                                <input type="text" class="form-control input-form" name="ci" id="ci"
                                    placeholder="12345678" required>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control input-form" name="telefono" id="telefono"
                                    placeholder="71234567">
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <label for="id_cargo" class="form-label">Cargo</label>
                                <select name="id_cargo" id="id_cargo" class="form-select input-form" required>
                                    <option value="" disabled selected>Seleccione un cargo</option>
                                    @foreach ($cargos as $cargo)
                                        <option value="{{ $cargo->id_cargo }}">{{ $cargo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <!-- RESPONSABLE EXISTENTE -->


                    <!-- FORMULARIO USUARIO -->
                    <form id="form_usuario" method="POST" action="{{ route('usuarios.store') }}">
                        @csrf
                        <h5 class="mb-3 text-primary">Datos de Usuario del Sistema</h5>
                        <div class="row g-3">
                            <input type="hidden" name="id_usuario" value="{{ old('id_usuario') }}">
                            <input type="hidden" name="id_responsable" id="id_responsable">

                            <div class="col-md-6 col-lg-4">
                                <label for="usuario" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control input-form" name="usuario" id="usuario"
                                    placeholder="ej. jperez" required>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label for="clave" class="form-label">Contraseña</label>
                                <input type="text" class="form-control input-form" name="clave" id="clave"
                                    placeholder="Mínimo 8 caracteres" required minlength="8">
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select name="rol" id="rol" class="form-select input-form" required>
                                    <option value="" selected disabled>Seleccione un rol</option>
                                    <option value="usuario">usuario</option>
                                    <option value="administrador">Administrador</option>
                                </select>
                            </div>
                        </div>

                        <input type="submit" value="fdsaf" class="d-none" id="submit_usuario">

                    </form>
                </div>
                <div class="col-auto d-flex flex-column justify-content-start pt-5 align-items-start border-start">
                    <button type="submit" class="btn text-nowrap mb-1" id="crear"
                        style="min-width: max-content; background-color: var(--color-boton-fondo); color: var(--color-boton-texto);">
                        Crear usuario
                    </button>
                    <button type="submit" class="btn btn-danger text-nowrap mb-1 w-100" id="clear"
                        style="min-width: max-content;   color: var(--color-boton-texto);">
                        limpiar datos
                    </button>
                    {{-- <button type="submit" class="btn btn-info text-nowrap mb-1 w-100" onclick="test()"
                        style="min-width: max-content;   color: var(--color-boton-texto);">
                        test
                    </button> --}}



                </div>
            </div>
            {{-- </form> --}}

        </div>
        <div class="col-12 col-md-2 text-white">

        </div>

        <!-- Columna central que siempre empieza en la columna 3 del contenedor padre (offset por las 2 columnas vacías) -->

    </div>



    {{-- <div class="card mt-4 p-4 rounded shadow col-1" style="background-color: var(--color-fondo);  min-height:90vh;">fdsafdafda</div> --}}


</div>
 {{-- @extends('layout') --}}
{{-- @push('scripts')> --}}

<script>

function test(){
    $("#clave").on("blur",function(){
this.reportValidity();
    });

}

function clear(){
    // Limpiar todos los inputs, incluyendo hidden
    $('input').val('');

// Reiniciar todos los selects al valor por defecto
$('select').each(function() {
    $(this).prop('selectedIndex', 0); // selecciona la primera opción
});
}

    $(document).ready(function() {

        const toggleforms = $('#toggleModoResponsable');
        const responsableSelect = $('#responsable_existente');
        const idResponsableInput = $('#id_responsable');

        toggleforms.on('change', function() {
            const crearNuevo = !this.checked;

            // console.log($('#form_responsable2').length); // Debe imprimir "1"


            $('#form_responsable2').css('display', crearNuevo ? 'block' : 'none');
            $('#form_usuario_existente').toggleClass('d-none', crearNuevo);
            $('#form_responsable_seleccionado').toggleClass('d-none', crearNuevo);



            if (crearNuevo) {
                idResponsableInput.val('');
            }
        });


        //

        responsableSelect.on('change', function() {
            idResponsableInput.val($(this).val());
            const selected = $(this).find('option:selected');
            const nombre = selected.data('nombre') || '';
            const ci = selected.data('ci') || '';

            $('#nombre2').val(nombre);
            $('#ci2').val(ci);
            // alert(selected.val());
            $('#id_responsable').val();
        });


        $('#clear').on('click', function() {
clear()
        });
        $('#crear').on('click', function(e) {
            e.preventDefault(); // Evita el envío automático

            const formUsuario = $('#form_usuario')[0]; // DOM nativo
            const formResponsable = $('#form_responsable2')[0];
            const formselect = $('#form_select')[0];
            let activarformresp = false;

            if (!$(formResponsable).is(':visible')) {
                if (!formselect.checkValidity()) {
                    formselect.reportValidity();
                    return;
                }
            } else {
                if (!formResponsable.checkValidity()) {
                    formResponsable.reportValidity();
                    return;
                }
                activarformresp = true;
            }

            if (!formUsuario.checkValidity()) {
                formUsuario.reportValidity();
                return;
            }

            // if (activarformresp) {

                // Limpiar mensaje previo

                if (activarformresp) {
                    e.preventDefault();
                    $('#mensaje-error').html('');
                    // Enviar responsable con AJAX primero
                    $.ajax({
                        url: $('#form_responsable2').attr('action'),
                        method: 'POST',
                        data: $('#form_responsable2').serialize(),
                        success: function(response) {
                            // Verificar que venga el ID del responsable
                            const idResponsable = response.responsable_id ||
                                response.id;
                            // mensaje(idResponsable)
                            if (response.success && idResponsable) {
                                // Poner el id_responsable en el formulario usuario
                                $('#form_usuario #id_responsable').val(idResponsable);

                                // Enviar el formulario usuario con AJAX
                                $.ajax({
                                    url: $('#form_usuario').attr('action'),
                                    method: 'POST',
                                    data: $('#form_usuario').serialize(),
                                    success: function(response2) {
                                        if (response2.success) {
                                            mensaje('Responsable y usuario creados correctamente',
                                                'success');
                                                clear();
                                            // limpiar o redirigir
                                        } else {
                                            mensaje(response2.message ||
                                                'Error al crear usuario',
                                                'danger');
                                        }
                                    },
                                    error: function(xhr) {
                                        mensaje(xhr.responseJSON
                                            ?.message ||
                                            'Error en la petición del usuario',"danger"
                                        );
                                    }
                                });
                            } else {
                                mensaje(response.message ||
                                    'No se pudo crear el responsable',"warning");
                                // No continuar con envío del usuario
                            }
                        },
                        error: function(xhr) {
                            mensaje(xhr.responseJSON?.message ||
                                'Error en la petición del responsable',"danger");
                        }
                    });
                } else {
                    // Solo enviar usuario (responsable no visible)
                    $.ajax({
                        url: $('#form_usuario').attr('action'),
                        method: 'POST',
                        data: $('#form_usuario').serialize(),
                        success: function(response) {
                            if (response.success) {
                                mensaje('Usuario creado correctamente',"success");
                                // Opcional: limpiar o redirigir
                                // clear();
                            } else {
                                mensaje(response.errors ||
                                    'Error al crear usuario',"danger");
                            }
                        },
                        error: function(xhr) {
                             let mensajes = [];
        $.each(xhr.responseJSON.errors, function(campo, mensajesCampo) {
            mensajes = mensajes.concat(mensajesCampo);
        });
        // Ahora mensajes es un array con todos los mensajes de error
        mensaje(mensajes.join('<br>'), "danger");
                            // mensaje(xhr.responseJSON?.errors || 'Error en la petición del usuario', "danger");
                            // mensaje(xhr.responseJSON?.errors || 'Error en la petición del usuario', "danger");

                            // mensaje(xhr.response.errors || 'Error en la petición del usuario', "danger");
                        }
                    });
                }
            // };


        });













    });
</script>
{{-- @endpush --}}
