<div class="card border-0 shadow-sm p-4 pt-0 mx-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <!-- Columna izquierda: Inputs -->
            <div class="flex-grow-1">
                <form id="form_buscar_devolucion" class="row g-3 text-start">
                    @csrf

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Número de Documento</label>
                        <input type="text" name="numero_documento" class="form-control" placeholder="Ej. 004">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Gestión</label>
                        <input type="number" name="gestion" value="{{ date('Y') }}" class="form-control" placeholder="2025">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Fecha Desde</label>
                        <input type="date" name="fecha_desde" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Fecha Hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Servicio</label>
                        <select name="id_servicio" class="form-select">
                            <option value="">Todos...</option>
                            @foreach ($servicios as $s)
                                <option value="{{ $s->id_servicio }}">{{ $s->nombre }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Botón centrado abajo -->
                    {{-- <div class="col-12 text-center mt-4 d-flex gap-3 justify-content-center">
                        <button type="button" id="btn_buscar_inventario" class="btn btn-primary w-75">
                            <i class="bi bi-search me-1"></i> Buscar
                        </button>
                        <button type="reset" class="btn btn-danger w-25">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                        </button>
                    </div> --}}
                    <div class="col-12 text-center mt-4 d-flex gap-2 justify-content-center">
                        <button type="button" id="btn_buscar_devolucion" class="btn btn-primary w-75">
                            <i class="bi bi-search me-1"></i> Buscar
                        </button>
                        <button type="reset" class="btn btn-danger w-25">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Columna derecha: Icono grande con título y subtítulo -->
            <div class="ms-4 text-center">
                <i class="bi bi-search text-primary fs-1"></i>
                <h4 class="fw-bold mt-2">Buscar Devolución</h4>
                <p class="text-muted small">Ingrese los criterios para encontrar una devolución</p>
            </div>
        </div>
    </div>
</div>


<!-- Tabla de resultados -->
<div class="mt-4" id="resultado_devoluciones"></div>

<script>
    $(document).on('click', '#btn_buscar_devolucion', function() {
        $.ajax({
            url: "{{ route('devolucion.buscar') }}",
            type: 'POST',
            data: $('#form_buscar_devolucion').serialize(),
            success: function(html) {
                $('#resultado_devoluciones').html(html);
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensaje(xhr.responseJSON.message, 'danger');
                } else {
                    mensaje('Ocurrió un error inesperado.', 'danger');
                }
            }
        });
    });


    // Capturar ID al presionar "Seleccionar"
//     $(document).on('click', '#seleccionar_devolucion', function() {
//         var idDevolucion = $(this).data('id');

//         // console.log("Devolución seleccionada:", idDevolucion);
//         // alert(idDevolucion);
// alert("fdafdsafd")
//         // cargarDetalleDevolucion(idDevolucion);
//         cargarTablaActivos(idDevolucion);
//         $('#buscarDevolucion .btn-close').trigger('click');
//     });
    //  $(document).on('click', '#seleccionar_devolucion', function() {
    //     var idTraslado = $(this).data('id');

    //     // console.log("Traslado seleccionado:", idTraslado);
    //     // alert(idTraslado    )
    //     cargarDetalleTraslado(idTraslado);
    //     cargarTablaActivos(idTraslado);
    //     $('#buscarTraslado .btn-close').trigger('click');
    // });
</script>
