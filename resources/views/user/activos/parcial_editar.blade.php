<form id="formEditarActivo">
    @csrf
    <input type="hidden" name="id_activo" value="{{ $activo->id_activo }}">

    <div class="container-fluid py-3">
        {{-- ============================ --}}
        {{--  FICHA: INFORMACIÓN DEL ACTIVO --}}
        {{-- ============================ --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-dark text-white fw-bold fs-5">
                <i class="bi bi-card-text me-2"></i> Ficha del Activo (Edición)
            </div>
            <div class="card-body">
                <div class="row g-3">
                    {{-- Código --}}
                    {{-- <div class="col-md-6 col-lg-4">
                        <label for="codigo" class="form-label">Código</label>
                        <div class="input-group">
                            <input type="text" class="form-control input-form" name="codigo" id="codigo"
                                placeholder="Código del activo" value="amd-001" required>
                            <button class="btn btn-outline-primary" type="button" id="buscarCodigoBtn">
                                <i class="bi bi-search"></i> <!-- ícono lupa usando Bootstrap Icons -->
                            </button>
                        </div> --}}
                    {{-- </div>  --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Código</small>
                        <div class="input-group">
                            <input type="text" class="form-control input-form" value="{{ $activo->codigo }}"
                                name="codigo" id="codigo" required>
                            {{-- <input type="text" class="form-control" name="codigo" > --}}
                            {{-- <button type="button" class="btn btn-outline-primary" id="verificarCodigo">Verificar</button> --}}
                            <button class="btn btn-outline-primary" type="button" id="buscarCodigoBtn">
                                <i class="bi bi-search"></i> <!-- ícono lupa usando Bootstrap Icons -->
                            </button>
                        </div>
                        <small id="codigoHelp" class="form-text text-muted"></small>
                    </div>

                    {{-- Nombre --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Nombre</small>
                        <input type="text" class="form-control" name="nombre" value="{{ $activo->nombre }}">
                    </div>

                    {{-- Detalle --}}
                    <div class="col-md-4 col-sm-12">
                        <small class="text-muted">Detalle</small>
                        <textarea class="form-control" name="detalle" rows="2">{{ $activo->detalle }}</textarea>
                    </div>

                 
                    {{-- Select de Estado --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Estado</small>
                        <select class="form-select" name="id_estado">
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado }}"
                                    {{ $activo->id_estado == $estado->id_estado ? 'selected' : '' }}>
                                    {{ $estado->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select de Categoría --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Categoría</small>
                        <select class="form-select" name="id_categoria">
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id_categoria }}"
                                    {{ $activo->id_categoria == $cat->id_categoria ? 'selected' : '' }}>
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select de Unidad --}}
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Unidad</small>
                        <select class="form-select" name="id_unidad">
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id_unidad }}"
                                    {{ $activo->id_unidad == $unidad->id_unidad ? 'selected' : '' }}>
                                    {{ $unidad->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- ============================ --}}
        {{--  DETALLES DE ADQUISICIÓN --}}
        {{-- ============================ --}}
        @php $tipoActual = strtoupper(trim($activo->adquisicion->tipo ?? 'OTRO')); @endphp
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-secondary text-white fw-bold fs-5">
                <i class="bi bi-bag-check me-2"></i> Detalles de la Adquisición
            </div>
            <div class="card-body">
                <div class="row g-3 mb-3">
                    {{-- Tipo de adquisición --}}
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Tipo de adquisición</small>
                        <select class="form-select" name="tipo" id="tipoAdquisicion">
                            <option value="COMPRA" {{ $tipoActual == 'COMPRA' ? 'selected' : '' }}>COMPRA</option>
                            <option value="DONACION" {{ $tipoActual == 'DONACION' ? 'selected' : '' }}>DONACIÓN
                            </option>
                            <option value="OTRO" {{ $tipoActual == 'OTRO' ? 'selected' : '' }}>OTRO</option>
                        </select>
                    </div>

                    {{-- Fecha de adquisición --}}
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Fecha de adquisición</small>
                        <input type="date" class="form-control" name="fecha"
                            value="{{ date('Y-m-d', strtotime($activo->adquisicion->fecha)) }}">
                    </div>

                    {{-- Comentarios --}}
                    <div class="col-md-6 col-sm-12">
                        <small class="text-muted">Comentarios / Observaciones</small>
                        <textarea class="form-control" name="comentarios" rows="2">{{ $activo->adquisicion->comentarios }}</textarea>
                    </div>
                </div>

                {{-- Sección Compra --}}
                <div id="seccionCompra" style="{{ $tipoActual != 'COMPRA' ? 'display:none;' : '' }}">
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted">Proveedor</small>
                            <input type="text" class="form-control" name="proveedor"
                                value="{{ $activo->adquisicion->compra?->proveedor?->nombre ?? '' }}">
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted">Precio Total</small>
                            <input type="number" class="form-control" name="precio"
                                value="{{ $activo->adquisicion->compra?->precio ?? '' }}">
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted">Fecha Registro</small>
                            <input type="date" class="form-control" name="fecha_registro"
                                value="{{ $activo->adquisicion->compra ? date('Y-m-d', strtotime($activo->adquisicion->compra->created_at)) : '' }}">
                        </div>
                    </div>
                </div>

                {{-- Sección Donación --}}
                <div id="seccionDonacion" style="{{ $tipoActual != 'DONACION' ? 'display:none;' : '' }}">
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted">Donante</small>
                            <input type="text" class="form-control" name="donante"
                                value="{{ $activo->adquisicion->donacion?->donante?->nombre ?? '' }}">
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted">Motivo</small>
                            <textarea class="form-control" name="motivo" rows="1">{{ $activo->adquisicion->donacion?->motivo ?? '' }}</textarea>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <small class="text-muted">Valor Estimado</small>
                            <input type="number" class="form-control" name="valor_estimado"
                                value="{{ $activo->adquisicion->donacion?->precio ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#tipoAdquisicion').on('change', function() {
            var tipo = $(this).val();
            $('#seccionCompra').toggle(tipo === 'COMPRA');
            $('#seccionDonacion').toggle(tipo === 'DONACION');
        });
        $('#buscarCodigoBtn').on('click', function() {
            const codigo = $('#codigo').val();

            if (!codigo) {
                alert('Por favor ingresa un código');
                return;
            }

            $.ajax({
                url: `${baseUrl}/activo/siguiente-codigo`, // Cambia la ruta según tu ruta en Laravel
                method: 'POST',
                data: {
                    codigo_base: codigo,
                    _token: '{{ csrf_token() }}' // Asegúrate de pasar el token CSRF
                },
                success: function(response) {
                    if (response.success) {
                        $('#codigo').val(response.siguiente_codigo);
                        mensaje('Código generado', 'success');
                    } else {
                        mensaje('Error: ' + response.message, 'danger');
                    }
                },
                error: function() {
                    mensaje('Error al buscar el siguiente código', 'danger');
                }
            });
        });
    });
</script>
