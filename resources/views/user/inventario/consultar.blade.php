<style>
    /* Destacar inputs activos */
    .input-activo {
        border: 2px solid #0d6efd !important;
        background-color: #e7f1ff !important;
    }
    #iframeOverlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050;
}

.iframe-container {
    position: relative;
    width: 80vw;
    height: 80vh;
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 10px #000;
}

.iframe-container iframe {
    width: 100%;
    height: 100%;
    border-radius: 0 0 8px 8px;
    border: none;
}

#iframeOverlay #closeIframe {
    position: absolute;
    top: 8px;
    right: 8px;
    background: red;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 4px 8px;
    font-weight: bold;
    cursor: pointer;
}
</style>





<div class="row  p-0 mb-4 pb-4" style="height: 90vh;">














    {{-- <div class="main-col col-md-12 col-lg-10 text-white order-lg-1 order-1 transition"> --}}

    {{-- <div class="main-col col-md-12 col-lg-12 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;"> --}}
    {{-- <div class="card  p-4 rounded shadow" style="background-color: var(--color-fondo); min-height: 100vh;"> --}}

    {{-- <div class="main-col col-md-12 order-lg-1 order-1 mb-4 p-1 transition" style="max-height: 95vh;"> --}}
    {{-- <div class="row g-3" style="min-height: 95vh;"> --}}

    <!-- Columna filtros (más ancha) -->
    <div class="col-12 col-lg-3">
        <div class="card p-3 rounded shadow" style="background-color: var(--color-fondo); min-height: 95vh;">
            <h5 class="text-center mb-4" style="color: var(--color-texto-principal);">🔍 Filtros de búsqueda
            </h5>

            {{-- <form id="formFiltros" action="" method="GET" class="d-flex flex-column gap-3"> --}}
              <form id="formFiltros" action="{{ route('inventario.filtrar') }}" method="GET"
                  class="d-flex flex-column gap-3">

                  <!-- Servicio -->
                  <div>
                      <label for="filtro_servicio" class="form-label fw-bold">Servicio</label>
                      <select id="filtro_servicio" name="servicio" class="form-select">
                          <option value="all" selected>Todos</option>
                          @foreach ($servicios as $servicio)
                              <option value="{{ $servicio->id_servicio }}">
                                  {{ $servicio->nombre }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <!-- Responsable -->
                  <div>
                      <label for="filtro_responsable" class="form-label fw-bold">Responsable</label>
                      <select id="filtro_responsable" name="responsable" class="form-select">
                          <option value="all" selected>Todos</option>
                          @foreach ($responsables as $responsable)
                              <option value="{{ $responsable->id_responsable }}">
                                  {{ $responsable->nombre }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <!-- Gestión + toggle fecha -->
                  <div class="d-flex align-items-center gap-2">
                      <div class="flex-grow-1">
                          <label for="filtro_gestion" class="form-label fw-bold">Gestión</label>
                          <input type="number" id="filtro_gestion" name="gestion" value="{{ date('Y') }}"
                              class="form-control" placeholder="Ej: 2025" min="0">
                      </div>

                      <button type="button" id="toggleFechas" class="btn btn-outline-primary mt-4"
                          title="Activar filtro por fechas">
                          <i class="bi bi-calendar-event"></i>
                      </button>
                  </div>

                  <!-- Rango de fechas -->
                  <div id="rangoFechas" class="d-none">
                      <label class="form-label fw-bold mb-1">Rango de fechas</label>
                      <div class="d-flex gap-3 mb-3">
                          <div style="flex:1;">
                              <label for="fecha_inicio" class="form-label small text-muted">Fecha Inicio</label>
                              <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                  value="2017-01-01">

                              <!-- Slider para fecha_inicio -->
                              <input type="range" id="slider_start" value="0" min="0" max="100"
                                  step="1" class="form-range mt-1">
                          </div>

                          <div style="flex:1;">
                              <label for="fecha_fin" class="form-label small text-muted">Fecha Fin</label>
                              <input type="date" id="fecha_fin" name="fecha_fin" class="form-control"
                                  value="{{ date('Y-m-d') }}">

                              <!-- Slider para fecha_fin -->
                              <input type="range" id="slider_end" value="100" min="0" max="100"
                                  step="1" class="form-range mt-1">
                          </div>
                      </div>
                  </div>



                  <!-- Botones -->
                  <div class="d-flex justify-content-between mt-3">
                      <button type="submit" class="btn btn-primary">
                          <i class="bi bi-search"></i> Filtrar
                      </button>
                      <button type="reset" id="btnLimpiar" class="btn btn-secondary">
                          <i class="bi bi-x-circle"></i> Limpiar filtros
                      </button>
                  </div>

              </form>
        </div>
    </div>

    <!-- Columna principal vacía (más grande) -->
    <div class="col-12 col-lg-9">
        <div class="card p-3 rounded shadow" style="background-color: var(--color-fondo); min-height: 95vh;">

            {{-- <div class="col-12 col-lg-9 h-100">
                <div class="card p-4 rounded shadow d-flex flex-column" --}}
            {{-- style="height: 90vh; background-color: var(--color-fondo); border: 2px dashed var(--color-texto-principal);"> --}}

            <h3 class="text-center text-muted mb-3">Lista de inventarios</h3>

            <div id="contenedorResultados" class="d-flex flex-column flex-grow-1 bg-secondary rounded bg-opacity-10">
                {{-- Aquí se cargará el contenido dinámico por AJAX --}}
                {{-- @include('user.inventario.parcial', ['inventarios' => $inventarios]) --}}
            </div>
        </div>
    </div>


    {{-- </div> --}}
    {{-- </div> --}}

    <!-- Scripts al final de tu body -->

    <div id="iframeContainer" style="display:none; position:fixed; top:10%; left:10%; width:80%; height:70%; background:#fff; border:1px solid #ccc; z-index:9999;">
        <button id="cerrarIframe" style="position:absolute; top:5px; right:10px;">Cerrar X</button>
        <iframe id="iframeActivos" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>



</div>








<script>
    $(document).ready(function() {


        $(document).on('click', '.visualizar-btn', function() {
    const idInventario = $(this).data('id');
    // alert(idInventario)
    const url = baseUrl + `/inventario/${idInventario}/activos`;  // Ajusta si tienes prefijo

    $('#iframeActivos').attr('src', url);
    // Opcional: mostrar el iframe si está oculto, o abrir contenedor
    $('#iframeContainer').show();
});


$('#cerrarIframe').click(function(){
    $('#iframeContainer').hide();
    $('#iframeActivos').attr('src', '');
});















        let usandoFechas = false;

        $('#toggleFechas').on('click', function() {
            usandoFechas = !usandoFechas;

            if (usandoFechas) {
                // Activar fechas, desactivar gestión
                $('#rangoFechas').removeClass('d-none');
                $('#filtro_gestion').prop('disabled', true);

                $('#fecha_inicio, #fecha_fin').prop('disabled', false);
                $(this).addClass('active'); // opcional para estilo
            } else {
                // Activar gestión, desactivar fechas
                $('#rangoFechas').addClass('d-none');
                $('#filtro_gestion').prop('disabled', false);

                $('#fecha_inicio, #fecha_fin').prop('disabled', true);
                $(this).removeClass('active');
            }
        });

        // Opcional: al cargar la página, asegurarse que los campos estén correctos
        $('#filtro_gestion').prop('disabled', false);
        $('#fecha_inicio, #fecha_fin').prop('disabled', true);


        $('#btnLimpiar').on('click', function() {
            // if (!$('#rangoFechas').hasClass('d-none')) {
            //     $('#rangoFechas').addClass('d-none');
            //     $('#toggleFechas i').removeClass('bi-calendar-event-fill').addClass('bi-calendar-event');
            //     $('#toggleFechas').attr('title', 'Activar filtro por fechas');
            // }
        });
        $('#formFiltros').on('submit', function(e) {
            e.preventDefault();
            console.log('Submit interceptado!');
            $.ajax({
                url: $(this).attr('action'),
                type: 'GET',
                data: $(this).serialize(),
                success: function(data) {
                    $('#contenedorResultados').html(data);
                    // Actualizar URL sin recargar (opcional)
                    // const newUrl = window.location.pathname + '?' + $('#formFiltros').serialize();
                    // window.history.pushState(null, '', newUrl);
                },
                error: function() {
                    alert('Error al cargar datos.');
                }
            });
        });
    });

    // Paginación por AJAX
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            data: $('#filtro-form').serialize(), // ENVÍO LOS FILTROS AL AJAX
            success: function(data) {
                $('#contenedorResultados').html(data);
                // window.history.pushState(null, '', url); // opcional
            },
            error: function() {
                alert('Error al cargar página.');
            }
        });
    });










    $(function() {
        // Fecha mínima fija
        const fechaMin = new Date('2017-01-01');

        // Fecha máxima = hoy del sistema
        const fechaMax = new Date();
        const fechaMaxISO = fechaMax.toISOString().slice(0, 10);

        // Ajustamos los atributos min/max en los inputs date
        $('#fecha_inicio, #fecha_fin').attr('min', '2017-01-01').attr('max', fechaMaxISO);

        // Función que convierte un valor slider (0-100) a fecha ISO
        function sliderToDate(val) {
            const diff = fechaMax.getTime() - fechaMin.getTime();
            const date = new Date(fechaMin.getTime() + (val / 100) * diff);
            return date.toISOString().slice(0, 10);
        }

        // Función que convierte una fecha ISO a valor slider (0-100)
        function dateToSlider(fechaStr) {
            const date = new Date(fechaStr);
            if (isNaN(date)) return 0;
            const diff = fechaMax.getTime() - fechaMin.getTime();
            let val = ((date.getTime() - fechaMin.getTime()) / diff) * 100;
            return Math.min(100, Math.max(0, val));
        }

        // Al cargar, sincronizamos sliders con los inputs de fecha (ambos hoy)
        $('#slider_start').val(dateToSlider($('#fecha_inicio').val()));
        $('#slider_end').val(dateToSlider($('#fecha_fin').val()));

        // Slider inicio controla fecha_inicio
        $('#slider_start').on('input change', function() {
            let val = +$(this).val();
            let finVal = +$('#slider_end').val();

            if (val > finVal) {
                val = finVal; // no permitir pasar el slider fin
                $(this).val(val);
            }

            $('#fecha_inicio').val(sliderToDate(val));
        });

        // Slider fin controla fecha_fin
        $('#slider_end').on('input change', function() {
            let val = +$(this).val();
            let inicioVal = +$('#slider_start').val();

            if (val < inicioVal) {
                val = inicioVal; // no permitir bajar del slider inicio
                $(this).val(val);
            }

            $('#fecha_fin').val(sliderToDate(val));
        });

        // Cambios manuales en fecha_inicio actualizan slider inicio
        $('#fecha_inicio').on('change', function() {
            let val = dateToSlider($(this).val());
            let finVal = +$('#slider_end').val();

            if (val > finVal) {
                val = finVal; // evitar cruzar
                $(this).val(sliderToDate(val));
            }

            $('#slider_start').val(val);
        });

        // Cambios manuales en fecha_fin actualizan slider fin
        $('#fecha_fin').on('change', function() {
            let val = dateToSlider($(this).val());
            let inicioVal = +$('#slider_start').val();

            if (val < inicioVal) {
                val = inicioVal; // evitar cruzar
                $(this).val(sliderToDate(val));
            }

            $('#slider_end').val(val);
        });
    });
</script>



















{{-- <div class="list-group">

    <!-- Ítem de inventario -->
    <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 px-3 border-start border-primary border-3">
        <div class="d-flex flex-wrap align-items-center gap-3">

            <span class="fw-bold text-primary">#001</span>

            <span class="badge bg-secondary">Gestión: 2025</span>
            <span class="badge bg-success">Pendiente</span>

            <small class="text-muted">Servicio: Informática</small>
            <small class="text-muted">Responsable: Juan Pérez</small>
            <small class="text-muted">Fecha: 2025-09-15</small>

        </div>

        <button class="btn btn-sm btn-outline-primary visualizar-inventario" data-id="001"
                title="Visualizar inventario">
            <i class="bi bi-eye"></i>
        </button>
    </div>

    <!-- Otro ítem -->
    <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 px-3 border-start border-danger border-3">
        <div class="d-flex flex-wrap align-items-center gap-3">

            <span class="fw-bold text-danger">#002</span>

            <span class="badge bg-secondary">Gestión: 2024</span>
            <span class="badge bg-danger">Finalizado</span>

            <small class="text-muted">Servicio: Administración</small>
            <small class="text-muted">Responsable: María Gómez</small>
            <small class="text-muted">Fecha: 2024-11-03</small>

        </div>

        <button class="btn btn-sm btn-outline-danger visualizar-inventario" data-id="002"
                title="Visualizar inventario">
            <i class="bi bi-eye"></i>
        </button>
    </div>












</div> --}}



{{-- Ejemplo en Blade (Laravel)
<div class="container-fluid py-3">
    <div class="row g-3">
      <!-- FILTROS -->
      <div class="col-lg-3">
        <div class="border rounded p-3 bg-light shadow-sm">
          <h5 class="mb-3">Filtros de búsqueda</h5>

          <!-- Servicio -->
          <div class="mb-3">
            <label for="filtro_servicio" class="form-label fw-semibold small">Servicio</label>
            <select id="filtro_servicio" class="form-select form-select-sm">
              <option value="">-- Todos --</option>
              @foreach ($servicios as $servicio)
                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
              @endforeach
            </select>
            <div class="d-none mt-1 text-primary small" data-target="#filtro_servicio">
              Activo
              <button type="button" class="btn btn-sm btn-outline-primary btn-clear p-0 ms-1" title="Limpiar filtro">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
          </div>

          <!-- Gestión -->
          <div class="mb-3">
            <label for="filtro_gestion" class="form-label fw-semibold small">Gestión</label>
            <select id="filtro_gestion" class="form-select form-select-sm">
              <option value="">-- Todas --</option>
              @foreach ($gestiones as $gestion)
                <option value="{{ $gestion }}">{{ $gestion }}</option>
              @endforeach
            </select>
            <div class="d-none mt-1 text-primary small" data-target="#filtro_gestion">
              Activo
              <button type="button" class="btn btn-sm btn-outline-primary btn-clear p-0 ms-1" title="Limpiar filtro">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
          </div>

          <!-- Responsable -->
          <div class="mb-3">
            <label for="filtro_responsable" class="form-label fw-semibold small">Responsable</label>
            <select id="filtro_responsable" class="form-select form-select-sm">
              <option value="">-- Todos --</option>
              @foreach ($responsables as $responsable)
                <option value="{{ $responsable->id }}">{{ $responsable->nombre }}</option>
              @endforeach
            </select>
            <div class="d-none mt-1 text-primary small" data-target="#filtro_responsable">
              Activo
              <button type="button" class="btn btn-sm btn-outline-primary btn-clear p-0 ms-1" title="Limpiar filtro">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
          </div>

          <!-- Rango fechas -->
          <div class="mb-3">
            <label class="form-label fw-semibold small">Rango de fechas</label>
            <div class="d-flex gap-2 mb-1">
              <input type="date" id="filtro_fecha_inicio" class="form-control form-control-sm" placeholder="Desde">
              <input type="date" id="filtro_fecha_fin" class="form-control form-control-sm" placeholder="Hasta">
            </div>
            <div class="d-none text-primary small" data-target="#filtro_fecha_inicio,#filtro_fecha_fin">
              Activo
              <button type="button" class="btn btn-sm btn-outline-primary btn-clear p-0 ms-1" title="Limpiar filtro">
                <i class="bi bi-x-lg"></i>
              </button>
            </div>
          </div>

          <button id="btn_filtrar" class="btn btn-primary w-100 mt-2">
            <i class="bi bi-search me-1"></i> Buscar
          </button>

          <div id="mensaje_busqueda" class="alert alert-info mt-3 py-2 px-3 d-none small"></div>
        </div>
      </div>

      <div class="col-lg-9">
        <h5 class="mb-3">Inventarios encontrados</h5>
        <div id="contenedor_inventarios" class="list-group">
        </div>
      </div>
    </div>
  </div> --}}

{{-- <script>
    $(function () {
      function renderInventarios(lista) {
        const cont = $('#contenedor_inventarios');
        cont.empty();

        if (!Array.isArray(lista) || lista.length === 0) {
          cont.append('<div class="alert alert-warning">No se encontraron inventarios.</div>');
          return;
        }

        lista.forEach(inv => {
          const estadoLower = (inv.estado || '').toLowerCase();
          const badgeEstadoClass = estadoLower === 'finalizado' ? 'bg-danger' : 'bg-secondary';

          const item = $(`
            <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2 py-2 px-3 border-start border-danger border-3">
              <div class="d-flex flex-wrap align-items-center gap-3">
                <span class="fw-bold text-danger">#${inv.numero_documento}</span>
                <span class="badge bg-secondary">Gestión: ${inv.gestion}</span>
                <span class="badge ${badgeEstadoClass}">${inv.estado}</span>
                <small class="text-muted">Servicio: ${inv.id_servicio}</small>
                <small class="text-muted">Responsable: ${inv.responsable_nombre || ''}</small>
                <small class="text-muted">Fecha: ${inv.fecha}</small>
              </div>
              <button class="btn btn-sm btn-outline-danger visualizar-inventario" data-id="${inv.id_inventario}" title="Visualizar inventario">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          `);

          cont.append(item);
        });
      }

      function actualizarFiltros() {
        ['#filtro_servicio', '#filtro_gestion', '#filtro_responsable'].forEach(sel => {
          const val = $(sel).val();
          const cont = $(`.d-none[data-target="${sel}"]`);
          if (val && val.toString().trim() !== '') cont.removeClass('d-none');
          else cont.addClass('d-none');
        });

        const inicio = $('#filtro_fecha_inicio').val();
        const fin = $('#filtro_fecha_fin').val();
        const contFecha = $('.d-none[data-target="#filtro_fecha_inicio,#filtro_fecha_fin"]');
        if (inicio || fin) contFecha.removeClass('d-none');
        else contFecha.addClass('d-none');
      }

      $('.btn-clear').on('click', function () {
        const targets = $(this).parent().data('target').split(',');
        targets.forEach(sel => {
          $(sel).val('');
        });
        actualizarFiltros();
        $('#mensaje_busqueda').addClass('d-none').empty();
        filtrarInventarios();
      });

      function filtrarInventarios() {
        const servicio = $('#filtro_servicio').val();
        const gestion = $('#filtro_gestion').val();
        const responsable = $('#filtro_responsable').val();
        const fecha_inicio = $('#filtro_fecha_inicio').val();
        const fecha_fin = $('#filtro_fecha_fin').val();

        $.ajax({
          url: "{{ route('inventarios.filtrar') }}",
          method: "GET",
          data: {
            servicio,
            gestion,
            responsable,
            fecha_inicio,
            fecha_fin
          },
          beforeSend: function () {
            $('#contenedor_inventarios').html('<div class="text-center my-3">🔄 Buscando inventarios...</div>');
          },
          success: function (data) {
            renderInventarios(data);
            $('#mensaje_busqueda')
              .removeClass('d-none')
              .html(`🔍 ${data.length} resultado(s) encontrados.`);
          },
          error: function () {
            $('#contenedor_inventarios').html('<div class="alert alert-danger">Error al cargar los datos.</div>');
          }
        });
      }

      $('#btn_filtrar').on('click', filtrarInventarios);
      $('#filtro_servicio, #filtro_gestion, #filtro_responsable, #filtro_fecha_inicio, #filtro_fecha_fin').on('change', actualizarFiltros);

      $(document).on('click', '.visualizar-inventario', function () {
        const idInv = $(this).data('id');
        alert('Ver inventario: ' + idInv);
        // Aquí podrías abrir modal o redirigir
      });

      // Inicialización
      filtrarInventarios();
      actualizarFiltros();
    });
  </script> --}}
