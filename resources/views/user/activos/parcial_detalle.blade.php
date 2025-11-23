<div class="container-fluid py-4">
    @if($activo)
        {{-- ============================ --}}
        {{--  FICHA: INFORMACIÓN DEL ACTIVO --}}
        {{-- ============================ --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-dark text-white fw-bold fs-5">
                <i class="bi bi-card-text me-2"></i> Ficha del Activo
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Código</small>
                        <div class="fw-semibold fs-5">{{ $activo->codigo ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <small class="text-muted">Nombre</small>
                        <div class="fw-semibold fs-5">{{ $activo->nombre ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <small class="text-muted">Detalle</small>
                        <div class="text-break">{{ $activo->detalle ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Estado</small>
                        <div>{{ $activo->estado?->nombre ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Categoría</small>
                        <div>{{ $activo->categoria?->nombre ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <small class="text-muted">Ubicación actual</small>
                        <div>{{ $servicio?? 'Sin asignación' }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ============================ --}}
        {{--  FICHA: DETALLES DE ADQUISICIÓN --}}
        {{-- ============================ --}}
        @if($activo->adquisicion)
            @php $tipo = strtoupper(trim($activo->adquisicion->tipo ?? '')); @endphp
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-secondary text-white fw-bold fs-5">
                    <i class="bi bi-bag-check me-2"></i> Detalles de la Adquisición
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-3 col-sm-6">
                            <small class="text-muted">ID Adquisición</small>
                            <div>{{ $activo->adquisicion->id_adquisicion }}</div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <small class="text-muted">Tipo</small>
                            <div>{{ $tipo }}</div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <small class="text-muted">Fecha de Adquisición</small>
                            <div>{{ \Carbon\Carbon::parse($activo->adquisicion->fecha)->format('d/m/Y') ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <small class="text-muted">Comentarios</small>
                            <div class="text-break">{{ $activo->adquisicion->comentarios ?? '-' }}</div>
                        </div>
                    </div>

                    {{-- Si es COMPRA --}}
                    @if($tipo === 'COMPRA' && $activo->adquisicion->compra)
                        <hr>
                        <div class="row g-3">
                            <div class="col-md-4 col-sm-6">
                                <small class="text-muted">Proveedor</small>
                                <div>{{ $activo->adquisicion->compra->proveedor?->nombre ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <small class="text-muted">Precio Total</small>
                                <div>{{ number_format($activo->adquisicion->compra->precio, 2) ?? '-' }} Bs</div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <small class="text-muted">Fecha Registro</small>
                                <div>{{ $activo->adquisicion->compra->created_at?->format('d/m/Y') ?? '-' }}</div>
                            </div>
                        </div>
                    @endif

                    {{-- Si es DONACIÓN --}}
                    @if($tipo === 'DONACION' && $activo->adquisicion->donacion)
                        <hr>
                        <div class="row g-3">
                            <div class="col-md-4 col-sm-6">
                                <small class="text-muted">Donante</small>
                                <div>{{ $activo->adquisicion->donacion->donante?->nombre ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <small class="text-muted">Motivo</small>
                                <div class="text-break">{{ $activo->adquisicion->donacion->motivo ?? '-' }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <small class="text-muted">Valor Estimado</small>
                                <div>{{ number_format($activo->adquisicion->donacion->precio, 2) ?? '-' }} Bs</div>
                            </div>
                             <div class="col-md-4 col-sm-6">
                                <small class="text-muted">Fecha Registro</small>
                                <div>{{ $activo->adquisicion->donacion->created_at?->format('d/m/Y') ?? '-' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="alert alert-secondary text-center">
                <i class="bi bi-info-circle me-1"></i> No hay información de adquisición disponible.
            </div>
        @endif
    @else
        <div class="alert alert-danger text-center">
            <i class="bi bi-exclamation-triangle me-1"></i> No se pudo cargar la información del activo.
        </div>
    @endif
</div>
