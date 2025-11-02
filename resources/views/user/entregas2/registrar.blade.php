<div class="card border-0 shadow-sm p-4 pt-0 mx-auto" style="max-width: 700px;">
    <div class="card-body">
        <div class="text-center mb-2">
            <i class="bi bi-plus-circle text-primary fs-1"></i>
            <h4 class="fw-bold mt-2">Nueva Entrega</h4>
            <p class="text-muted small">Complete los datos para registrar la entrega</p>
        </div>

     <form id="form_entrega" class="row g-3" action="{{ route('entregas.store') }}" method="POST">
            @csrf
 <div class="col-md-6 col-lg-6">
                    <label for="numero_documento" class="form-label fw-bold">Número Documento</label>
                    <input type="text" class="form-control fw-bold" value="{{ $numeroSiguiente }}"
                        name="numero_documento" id="numero_documento" readonly placeholder="">
                    <div class="form-text">Este campo se genera automáticamente</div>
                </div>


                <div class="col-md-6 col-lg-6">
                    <label for="gestion" class="form-label">Gestión</label>
                    <input type="number" class="form-control" name="gestion" id="gestion" value="2025" required>
                </div>

                <div class="col-md-6 col-lg-6">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" id="fecha" value="2025-09-16"
                        required>
                </div>

                  <div class="col-md-6 col-lg-6">
                    <label for="id_servicio" class="form-label">Servicio destino</label>
                    <select name="id_servicio" id="id_servicio" class="form-select" required>
                         <option value="">Seleccione...</option>
        @foreach ($servicios as $s)
            <option value="{{ $s->id_servicio }}" data-responsable="{{ $s->responsable->nombre ?? 'N/D' }}">
                {{ $s->nombre }}
            </option>
        @endforeach
        
                        {{-- <option value="" disabled selected>Seleccione servicio</option>
                        @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id_servicio }}"
                                data-responsable="{{ $servicio->id_responsable }}">
                                {{ $servicio->nombre }}
                            </option>
                        @endforeach --}}
                    </select>
                    <div id="info_responsable_destino" class="form-text text-muted">
        Responsable: N/D
    </div>
                </div>
{{-- 
                <div class="col-md-6 col-lg-6">
                    <label for="id_responsable" class="form-label">Responsable</label>
                    <input type="text" class="form-control" value="Selecione un servicio" id="nombre_responsable"
                        readonly>
                    <input type="hidden" name="id_responsable" id="id_responsable" value="">
                </div> --}}

                <div class="col-md-6 col-lg-12">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3"
                        placeholder="Detalles de la entrega..."></textarea>
                </div>
            {{-- <div class="col-md-6">
                <label class="form-label fw-semibold">Número de Documento</label>
                <input type="text" class="form-control fw-bold" value="{{ $numeroDisponible }}"
                    name="numero_documento" id="numero_documento" readonly placeholder="">
                <div class="form-text">Este campo se genera automáticamente</div>

            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Gestión</label>
                <input type="number" name="gestion" class="form-control" value="{{ $gestionActual }}" required>
            </div>

            
            <div class="col-md-6">
    <label class="form-label fw-semibold">Servicio Origen</label>
    <select name="id_servicio_origen" id="id_servicio_origen" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach ($servicios as $s)
            <option value="{{ $s->id_servicio }}" data-responsable="{{ $s->responsable->nombre ?? 'N/D' }}">
                {{ $s->nombre }}
            </option>
        @endforeach
    </select>
    <div id="info_responsable_origen" class="form-text text-muted">
        Responsable: N/D
    </div>
</div>

<div class="col-md-6">
    <label class="form-label fw-semibold">Servicio Destino</label>
    <select name="id_servicio_destino" id="id_servicio_destino" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach ($servicios as $s)
            <option value="{{ $s->id_servicio }}" data-responsable="{{ $s->responsable->nombre ?? 'N/D' }}">
                {{ $s->nombre }}
            </option>
        @endforeach
    </select>
    <div id="info_responsable_destino" class="form-text text-muted">
        Responsable: N/D
    </div>
</div>
<div class="col-md-6">
                <label class="form-label fw-semibold">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>



            <div class="col-12">
                <label class="form-label fw-semibold">Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3" placeholder="Ingrese observaciones..."></textarea>
            </div> --}}

            <div class="col-12 text-center mt-3">
                <button type="button" id="btn_guardar_entrega" class="btn btn-primary w-50">
                    <i class="bi bi-save me-1"></i> Guardar Entrega
                </button>
            </div>
        </form>
    </div>
</div>


{{-- <div class="col-md-12 col-lg-6 text-white"> --}}
    {{-- <div class="card mt-4 p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 90vh;"> --}}
        {{-- <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Crear entrega</h2>

        <form id="form_entrega" method="POST" action="{{ route('entregas.store') }}">
            @csrf
            <div class="row g-3">

                <!-- Datos generales de la entrega -->
               

              
                <hr>
                <div class="row"> --}}





                    {{-- <div class="container"> --}}
                    {{-- <div class="row"> --}}
                    {{-- <div
                        class=" col-md-12 col-lg-8 mt-4 mt-lg-0 d-flex flex-lg-nowrap flex-wrap justify-content-end align-items-center gap-1 order-3 order-lg-2">
                        <!-- Botones -->
                        <input type="submit" id="btn_guardar_borrador"
                            class="btn  btn-success w-20 w-lg-auto text-nowrap" value="Guardar Acta"> --}}



                        {{-- <button type="submit" id="btn_entregar" class="btn btn-success w-100 w-lg-50 text-nowrap">
                            Entregar y Añadir a Inventario
                        </button> --}}
                        {{-- <button type="reset" class="btn btn-danger w-20 w-lg-auto text-nowrap">
                            Limpiar
                        </button>
                    </div> --}}

                    {{-- </div> --}}
                    {{-- </div> --}}





                    {{-- <div class="col-lg-8 col-md-3 mt-4 mt-lg-0 d-flex flex-wrap justify-content-end align-items-center gap-2 order-3 order-lg-2">
                        <!-- Botones -->
                        <button type="button" id="btn_guardar_borrador"
                            class="btn btn-secondary w-100 w-lg-auto text-nowrap">Guardar Acta en blanco</button>
                        <button type="submit" id="btn_entregar" class="btn btn-success w-100 w-lg-auto text-nowrap">Entregar y
                            Añadir a Inventario</button>
                        <button type="reset" class="btn btn-danger w-100 w-lg-auto text-nowrap">Limpiar formulario</button>
                    </div> --}}

                    {{-- <div class="col-lg-4 col-md-6 mt-4 mt-lg-0 d-lg-flex gap-2 justify-content-center align-items-center col-12 order-3 order-lg-2">
                        <!-- Botones -->
                        <button type="button" id="btn_guardar_borrador"
                            class="btn btn-secondary w-100 w-lg-auto text-nowrap">Guardar Acta en blanco</button>
                        <button type="submit" id="btn_entregar" class="btn btn-success w-100 w-lg-auto text-nowrap">Entregar y
                            Añadir a Inventario</button>
                        <button type="reset" class="btn btn-danger w-100 w-lg-auto text-nowrap">Limpiar formulario</button>


                    </div> --}}



                {{-- </div>

            </div>

            <!-- Botones -->

        </form> --}}



    {{-- </div> --}}
{{-- </div> --}}
<script>
    $('#form_entrega').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'), // ruta que está en el form
            method: $(this).attr('method'), // método del form (POST)
            data: $(this).serialize(), // serializa los campos
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    mensaje('Entrega guardada correctamente', 'success');
                    $('#form_entrega')[0].reset();
                    $('#numero_documento').val(response.numeroSiguiente);
                    // Si quieres actualizar algún campo con datos del backend:
                    // $('#numero_documento').val(response.numeroSiguiente);
                    $('#gestion').trigger('change')
                } else {
                    let mensajes = [];
                    if (response.errors) {
                        $.each(response.errors, function(key, errors) {
                            mensajes = mensajes.concat(errors);
                        });
                    } else if (typeof response === 'string') {
                        mensajes.push(response);
                    }
                    mensaje(mensajes.join('<br>'), 'danger');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let mensajes = [];
                    $.each(xhr.responseJSON.errors, function(key, errors) {
                        mensajes = mensajes.concat(errors);
                    });
                    mensaje(mensajes.join('<br>'), 'danger');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    // Aquí muestra el mensaje que envía el controlador (por ejemplo en errores 500)
                    mensaje(xhr.responseJSON.message, 'warning');
                } else {
                    mensaje('Error inesperado en el servidor', 'danger');
                }
            }
        });
    });





    $('#id_servicio').on('change', function() {
        var responsableId = $(this).find('option:selected').data('responsable');

        if (!responsableId) {
            $('#nombre_responsable').val('');
            $('#id_responsable').val('');
            return;
        }

        $.ajax({
            url: baseUrl + '/responsables/' + responsableId,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#nombre_responsable').val(data.nombre);
                $('#id_responsable').val(data.id_responsable);
            },
            error: function() {
                $('#nombre_responsable').val('No encontrado');
                $('#id_responsable').val('');
            }
        });
    });
    $('#gestion').on('change', function() {
        var gestion = $(this).val();
        $('#numero_documento').val('');

        if (!gestion) {
            $('#numero_documento').val('Error');
            alert('Debe seleccionar una gestión.');
            return;
        }

        $.ajax({
            url: baseUrl + '/getDocto',
            method: 'GET',
            data: {
                gestion: gestion
            },
            dataType: 'json',
            success: function(data) {
                if (data.numero) {
                    $('#numero_documento').val(data.numero);
                } else if (data.error) {
                    $('#numero_documento').val('Error');
                    console.error('Error desde backend:', data.error);
                    alert('Error: ' + data.error);
                } else {
                    $('#numero_documento').val('Error');
                    console.error('Error desconocido');
                    alert('Error desconocido del servidor.');
                }
            },
            error: function(xhr, status, error) {
                $('#numero_documento').val('Error');

                let errorMsg = 'Error al obtener número de documento';

                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        errorMsg = response.error;
                    }
                } catch (e) {
                    // No se pudo interpretar la respuesta
                }

                console.error(errorMsg);
                alert(errorMsg);
            }
        });
    });
</script>
