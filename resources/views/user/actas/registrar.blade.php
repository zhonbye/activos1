<div class="col-md-12 col-lg-12 text-white">
    <div class="card mt-4 p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 90vh;">
        <h2 class="mb-4 text-center" style="color: var(--color-texto-principal);">Registro de Acta</h2>

        <form method="POST" id="form_docto" action="{{ route('actas.store') }}">
            @csrf

            <div class="row g-3">
                {{-- Número (solo muestra, autogenerado en backend) --}}
                <div class="col-md-3 ">
                    <label class="form-label">Nro. de Acta</label>
                    <input type="number" class="form-control input-form" name="numero" id="numero" value="{{ $numeroSiguiente }}" readonly>
                </div>
                <div class="col-md-3">
                    <label for="gestion" class="form-label">Gestión</label>
                    <input type="number" class="form-control input-form" name="gestion" id="gestion"
                        value="{{ date('Y') }}" required>
                </div>

                {{-- Fecha actual --}}
                <div class="col-md-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control input-form" name="fecha" id="fecha"
                        value="{{ date('Y-m-d') }}" required>
                </div>

                {{-- Tipo --}}
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select input-form" required>
                        <option value="" disabled selected>Seleccione tipo</option>
                        <option value="ENTREGA">ENTREGA</option>
                        <option value="DEVOLUCIÓN">DEVOLUCIÓN</option>
                        <option value="TRASLADO">TRASLADO</option>
                        <option value="INVENTARIO">INVENTARIO</option>
                        <option value="BAJA">BAJA</option>
                    </select>
                </div>

                {{-- Ubicación --}}
                {{-- <div class="col-md-3">
                    <label for="id_ubicacion" class="form-label">Ubicación de origen</label>
                    <select id="id_ubicacion_origen" name="id_ubicacion_origen" class="form-select" required disabled>
                        <option value="" disabled selected>Seleccione ubicación</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id_ubicacion }}">{{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="id_servicio_origen" class="form-label">Servicio de origen</label>
                    <select id="id_servicio_origen" name="id_servicio_origen" class="form-select" required disabled>
                        <option value="" disabled selected>Sin servicio</option>
                    </select>
                </div>
                <div class="col-md-6">

                </div> --}}
                <div class="col-md-3">
                    <label for="id_ubicacion" class="form-label">Ubicación de destino</label>
                    <select name="id_ubicacion" id="id_ubicacion" class="form-select input-form"
                        required>
                        <option value="" disabled selected>Seleccione ubicación</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id_ubicacion }}">{{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="id_servicio" class="form-label">Servicio de destino</label>
                    <select name="id_servicio" id="id_servicio" class="form-select input-form" required>
                        <option value="" disabled selected>Seleccione servicio</option>
                    </select>
                </div>




                {{-- Responsable del servicio (automático, solo muestra) --}}
                <div class="col-md-6">
                    <label class="form-label">Responsable</label>
                    <input type="text" class="form-control input-form" id="nombre_responsable" readonly>
                    <input type="hidden" name="id_responsable" id="id_responsable">
                </div>

                {{-- Detalle --}}
                <div class="col-12">
                    <label for="detalle" class="form-label">Detalle</label>
                    <textarea name="detalle" id="detalle" class="form-control input-form" rows="4" placeholder="Detalle del acta..."
                        required></textarea>
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn"
                    style="background-color: var(--color-boton-fondo); color: var(--color-boton-texto);">
                    Guardar Acta
                </button>
                <button type="reset" class="btn btn-danger">
                    Limpiar
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    

    // $('#tipo').on('change', function() {
    //     var valorSeleccionado = $(this).val();

    //     if (valorSeleccionado === 'TRASLADO' || valorSeleccionado === 'DEVOLUCIÓN') {
    //         $('#id_ubicacion_origen').prop('disabled', false);
    //         $('#id_servicio_origen').prop('disabled', false);
    //     } else {
    //         $('#id_ubicacion_origen').prop('disabled', true);
    //         $('#id_servicio_origen').prop('disabled', true);
    //     }
    // });


    function cargarResponsable($selectServicio) {
        const servicioId = $selectServicio.val();

        if (!servicioId) {
            $('#nombre_responsable').val('');
            $('#id_responsable').val('');
            return;
        }

        $.getJSON(`${baseUrl}/servicios/${servicioId}/responsable`)
            .done(function(data) {
                $('#nombre_responsable').val(data.nombre);
                $('#id_responsable').val(data.id);
            })
            .fail(function() {
                $('#nombre_responsable').val('Error al cargar');
                $('#id_responsable').val('');
            });
    }

    function cargarServicios($selectUbicacion, $selectServicio) {

        const ubicacionId = $selectUbicacion.val();
        const ubicacionTexto = $selectUbicacion.find("option:selected").text();

        if (!ubicacionId) {
            $selectServicio.html('<option value="" disabled selected>Seleccione servicio</option>');
            $selectServicio.prop('disabled', true);
            return;
        }
        $selectServicio.html('<option value="" disabled selected>Cargando...</option>');
        $selectServicio.prop('disabled', true);

        $.getJSON(`${baseUrl}/ubicaciones/${ubicacionId}/servicios`)
            .done(function(data) {
                let options = '';

                if (data.length === 0) {
                    // No hay servicios, mostrar solo el nombre de la ubicación
                    options = `<option value="${ubicacionId}" selected>${ubicacionTexto}</option>`;
                } else {
                    options = '<option value="" disabled selected>Elegir servicio</option>';
                    $.each(data, function(i, s) {
                        options += `<option value="${s.id_servicio}">${s.nombre}</option>`;
                    });
                }

                $selectServicio.html(options);
                $selectServicio.prop('disabled', false);
            })
            .fail(function() {
                $selectServicio.html('<option value="" disabled selected>Error al cargar</option>');
                $selectServicio.prop('disabled', true);
            });
    }

    // Asignar evento change solo una vez
    // $('#id_ubicacion_origen').on('change', function() {
    //     cargarServicios($(this), $('#id_servicio_origen'));
    // });
    $('#id_ubicacion').on('change', function() {
        cargarServicios($(this), $('#id_servicio'));

    });
    $('#id_servicio').on('change', function () {
    cargarResponsable($(this));
});
$(document).ready(function() {


    $('#gestion').on('change', function() {
    const gestion = $(this).val();

    if (!gestion) {
        $('#numero').val(''); // limpia el campo número si no hay gestión
        return;
    }

    $.ajax({
        url: `${baseUrl}/actas/ultimodocto/${gestion}`,  // usa la ruta que definiste
        method: 'GET',
        success: function(response) {
            if (response.success) {
                $('#numero').val(response.numero);
            } else {
                $('#numero').val('');
            }
        },
        error: function() {
            $('#numero').val('');
        }
    });
});
















  $('#form_docto').submit(function(e) {
    e.preventDefault();

    $.ajax({
      url: $(this).attr('action'),
      method: $(this).attr('method'),
      data: $(this).serialize(),
      success: function(response) {
        if (response.success) {
          mensaje('Acta creada correctamente', 'success');
          $('#form_docto')[0].reset();
          $('#numero').val(response.numeroSiguiente);
        } else {
          // Si hay errores devueltos en el objeto response.errors
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
        } else {
          mensaje('Error inesperado en el servidor', 'danger');
        }
      }
    });
  });
});

