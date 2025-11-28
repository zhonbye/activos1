<!-- RESUMEN DE STOCK DINÁMICO -->
<div class="row g-3 mb-4">

    <!-- 🔵 TOTAL GENERAL: columna izquierda más grande -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-4 bg-light h-100 d-flex flex-column justify-content-center align-items-center">
            <i class="bi bi-box-seam text-primary fs-1 mb-2"></i> <!-- Icono grande -->
            <h6 class="text-primary fw-bold">Total en Stock</h6>
            <p class="fs-2 fw-bold m-0">{{ $totalGeneral }}</p>
        </div>
    </div>

    <!-- 🔵 ESTADOS DINÁMICOS: columna derecha -->
    <div class="col-md-8">
        <div class="row g-3">
            @foreach($estadoGeneral as $estado => $cantidad)
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 p-3 bg-light h-100 text-center">
                        <h6 class="fw-bold
                            @if(Str::contains(strtolower($estado), 'bueno')) text-success
                            @elseif(Str::contains(strtolower($estado), 'mal')) text-danger
                            @elseif(Str::contains(strtolower($estado), 'regular')) text-warning
                            @else text-primary
                            @endif
                        ">
                            {{ ucfirst(strtolower($estado)) }}
                        </h6>
                        <p class="fs-4 fw-bold m-0">{{ $cantidad }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

<!-- ============================================= -->
<!-- DETALLE DE ACTIVOS POR CATEGORÍA DINÁMICO -->
<!-- ============================================= -->
<div class="card shadow-sm border-0 p-3 mb-4">
    <h5 class="fw-bold text-primary mb-3">Detalle de activos en stock por categoría</h5>

    <ul class="list-group list-group-flush">
        @foreach($categoriasActivos as $categoria => $info)
        <li class="list-group-item d-flex justify-content-between align-items-center categoria-click"
        data-categoria="{{ $categoria }}"
        style="cursor: pointer;">


                <!-- Nombre de la categoría -->
                <span class="fw-semibold">{{ $categoria }}</span>

                <div class="d-flex align-items-center gap-2">
                    <!-- 🔹 Badges de estados más suaves y pequeños -->
                    @if(isset($info['estados']))
                        @foreach($info['estados'] as $estado => $cantidadEstado)
                            <span class="badge text-white fw-normal"
                                  style="
                                    font-size: 0.7rem;
                                    padding: 0.25em 0.4em;
                                    @if(Str::contains(strtolower($estado), 'bueno')) background-color: #6fcf97;
                                    @elseif(Str::contains(strtolower($estado), 'mal')) background-color: #eb5757;
                                    @elseif(Str::contains(strtolower($estado), 'regular')) background-color: #A0E7FF;
                                    @else background-color: #C3B1E1;
                                    @endif
                                    opacity: 0.85;
                                  ">
                                {{ $estado }}: {{ $cantidadEstado }}
                            </span>
                        @endforeach
                    @endif

                    <!-- 🔹 Badge final con total de activos de la categoría más destacado -->
                    <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                        {{ $info['total'] }}
                    </span>
                </div>

            </li>
        @endforeach
    </ul>
</div>
<script>
    $(document).on('click', '.categoria-click', function () {

const nombreCategoria = $(this).data('categoria')?.trim();

if (!nombreCategoria) return;

let encontrado = false;

// Buscar la opción del select donde el texto sea igual al nombre de la categoría
$("#categoria_activo option").each(function () {

    if ($(this).text().trim().toLowerCase() === nombreCategoria.toLowerCase()) {
        $(this).prop("selected", true);
        encontrado = true;
    }
});

if (!encontrado) {
    console.warn("Categoría no encontrada en el select:", nombreCategoria);
    return;
}

// Presionar automáticamente el botón de búsqueda una sola vez
$("#btn_buscar_inventario").trigger("click");
});

</script>
