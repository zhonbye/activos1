<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Baja;
use App\Models\Devolucion;
use App\Models\Entrega;
use App\Models\Estado;
use App\Models\Inventario;
use App\Models\Servicio;
use App\Models\Traslado;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{

    public function global()
    {session()->forget('activos_filtrados');
        // Para filtros
        $servicios = DB::table('servicios')->orderBy('nombre')->get();
        $categorias = DB::table('categorias')->orderBy('nombre')->get();
        $estados   = DB::table('estados')->orderBy('nombre')->get();

        // ============================
        // CONTADORES DIRECTOS
        // ============================

        $total_activos = DB::table('activos')->count();

        // Asignados = estado_situacional = ACTIVO
        $activos_asignados = DB::table('activos')
            ->where('estado_situacional', 'ACTIVO')
            ->count();

        // Disponibles = INACTIVO
        $activos_disponibles = DB::table('activos')
            ->where('estado_situacional', 'INACTIVO')
            ->count();

        // Bajas = BAJA
        $activos_baja = DB::table('activos')
            ->where('estado_situacional', 'BAJA')
            ->count();

        return view('user.reportes.global', compact(
            'servicios',
            'estados',
            'categorias',
            'total_activos',
            'activos_asignados',
            'activos_disponibles',
            'activos_baja'
        ));
    }

public function generar(Request $req)
{
    $tipo    = $req->tipo;
    $desde   = $req->desde;
    $hasta   = $req->hasta;
    $formato = $req->formato;

    switch ($tipo) {

        case 'resumen':
            return $this->reporteResumen($desde, $hasta, $formato);

        case 'servicio':
            return $this->reporteServicio($desde, $hasta, $formato);

        case 'categoria':
            return $this->reporteCategoria($desde, $hasta, $formato);

        case 'estado':
            return $this->reporteEstado($desde, $hasta, $formato);

        case 'inventario':
            return $this->reporteInventario($formato);

        case 'asignados':
            return $this->reporteAsignados($desde, $hasta, $formato);

        case 'disponibles':
            return $this->reporteDisponibles($formato);

        case 'baja':
            return $this->reporteBajas($desde, $hasta, $formato);

        case 'compra':
            return $this->reporteCompra($desde, $hasta, $formato);

        case 'donacion':
            return $this->reporteDonacion($desde, $hasta, $formato);

        case 'otros':
            return $this->reporteOtros($desde, $hasta, $formato);

        default:
            abort(404, 'Tipo de reporte desconocido');
    }
}

private function reporteServicio($desde, $hasta, $formato)
{
    // ----------------------------------------------------
    // NORMALIZAR FECHAS
    // ----------------------------------------------------
    $desde = $desde ?: '1970-01-01';
    $hasta = $hasta ?: date('Y-m-d');

    // ----------------------------------------------------
    // 0. REVISAR SI HAY ACTIVOS FILTRADOS EN LA SESIÓN
    // ----------------------------------------------------
    $filtrados = session('activos_filtrados');

    if ($filtrados && count($filtrados) > 0) {

        // ------------------------------
        // CASO A: USAR ACTIVOS FILTRADOS (SESIÓN)
        // ------------------------------
        $serviciosNombres = collect($filtrados)
            ->pluck('ubicacion_actual')
            ->unique()
            ->values();

        $servicios = DB::table('servicios AS s')
            ->leftJoin('responsables AS r', 'r.id_responsable', '=', 's.id_responsable')
            ->whereIn('s.nombre', $serviciosNombres)
            ->select(
                's.id_servicio',
                's.nombre AS servicio',
                's.descripcion',
                'r.nombre AS responsable',
                'r.ci',
                'r.telefono'
            )
            ->get();

        foreach ($servicios as $serv) {

            // FILTRADOS SOLO PARA ESTE SERVICIO
            $items = collect($filtrados)
                ->where('ubicacion_actual', $serv->servicio)
                ->values();

            $serv->activos = $items;
            $serv->totalActivos = $items->count();

            // -----------------------
            // CATEGORÍAS LIMPIAS
            // -----------------------
            $serv->categorias = $items
                ->groupBy(function ($item) {

                    // Si la categoría es un OBJETO → devolver SOLO EL NOMBRE
                    if (is_object($item->categoria)) {
                        return $item->categoria->nombre;
                    }

                    return $item->categoria;   // ya string
                })
                ->map(function ($grupo, $catNombre) {

                    $o = new \stdClass();
                    $o->categoria = $catNombre;  // string limpio
                    $o->total = $grupo->count();
                    return $o;
                })
                ->values();

            // VARIABLES QUE LA VISTA SIEMPRE ESPERA
            $serv->bajas = collect();
            $serv->inventarios = collect();
            $serv->traslados_origen = collect();
            $serv->traslados_destino = collect();
        }

    } else {

        // ----------------------------------------------------
        // CASO B: NO HAY FILTRO → USAR INVENTARIO VIGENTE
        // ----------------------------------------------------
        $servicios = DB::table('servicios AS s')
            ->leftJoin('responsables AS r', 'r.id_responsable', '=', 's.id_responsable')
            ->select(
                's.id_servicio',
                's.nombre AS servicio',
                's.descripcion',
                'r.nombre AS responsable',
                'r.ci',
                'r.telefono'
            )
            ->get();

        foreach ($servicios as $serv) {

            // 1) BUSCAR INVENTARIO VIGENTE
            $invVigente = DB::table('inventarios')
                ->where('id_servicio', $serv->id_servicio)
                ->where('estado', 'vigente')
                ->orderByDesc('fecha')
                ->first();
                
                if (!$invVigente) {
                    
                    $serv->activos = collect();
                    $serv->totalActivos = 0;
                    $serv->categorias = collect();
                    
                } else {

                // 2) ACTIVOS DEL INVENTARIO VIGENTE
               $activos = DB::table('detalle_inventarios AS di')
    ->join('activos AS a', 'a.id_activo', '=', 'di.id_activo')
    ->leftJoin('categorias AS c', 'c.id_categoria', '=', 'a.id_categoria')
    ->leftJoin('estados AS es', 'es.id_estado', '=', 'a.id_estado')
    ->where('di.id_inventario', $invVigente->id_inventario)
    ->select(
        'a.id_activo',
        'a.codigo',
        'a.nombre AS activo',
        'c.nombre AS categoria',
        'es.nombre AS estado',
        'di.estado_actual',
        'di.observaciones'
    )
    ->get();


                $serv->activos = $activos;
                $serv->totalActivos = $activos->count();

                // 3) CATEGORÍAS DEL INVENTARIO VIGENTE
                $serv->categorias = DB::table('detalle_inventarios AS di')
                    ->join('activos AS a', 'a.id_activo', '=', 'di.id_activo')
                    ->leftJoin('categorias AS c', 'c.id_categoria', '=', 'a.id_categoria')
                    ->where('di.id_inventario', $invVigente->id_inventario)
                    // ->where('di.estado', 'vigente')
                    ->groupBy('c.nombre')
                    ->select(
                        'c.nombre AS categoria',
                        DB::raw('COUNT(*) AS total')
                    )
                    ->get();
            }

            // 4) BAJAS
            $serv->bajas = DB::table('bajas AS b')
                ->join('activos AS a', 'a.id_activo', '=', 'b.id_activo')
                ->where('b.id_servicio', $serv->id_servicio)
                ->whereBetween('b.fecha', [$desde, $hasta])
                ->select(
                    'a.codigo',
                    'a.nombre AS activo',
                    'b.fecha',
                    'b.motivo',
                    'b.observaciones'
                )
                ->get();

            // 5) INVENTARIOS DEL PERIODO
            $serv->inventarios = DB::table('inventarios AS i')
                ->where('i.id_servicio', $serv->id_servicio)
                ->whereBetween('i.fecha', [$desde, $hasta])
                ->select(
                    'i.id_inventario',
                    'i.numero_documento',
                    'i.fecha',
                    'i.observaciones',
                    'i.estado'
                )
                ->get();

            // DETALLE DE INVENTARIOS
            foreach ($serv->inventarios as $inv) {
                $inv->detalle = DB::table('detalle_inventarios AS di')
                    ->join('activos AS a', 'a.id_activo', '=', 'di.id_activo')
                    ->leftJoin('categorias AS c', 'c.id_categoria', '=', 'a.id_categoria')
                    ->leftJoin('estados AS es', 'es.id_estado', '=', 'a.id_estado')
                    ->where('di.id_inventario', $inv->id_inventario)
                    ->where('di.estado_actual', 'vigente')
                    ->select(
                        'a.codigo',
                        'a.nombre AS activo',
                        'c.nombre AS categoria',
                        'es.nombre AS estado',
                        'di.estado_actual',
                        'di.observaciones'
                    )
                    ->get();
            }

            // 6) TRASLADOS ORIGEN
            $serv->traslados_origen = DB::table('traslados AS t')
                ->where('t.id_servicio_origen', $serv->id_servicio)
                ->whereBetween('t.fecha', [$desde, $hasta])
                ->select('t.numero_documento', 't.fecha', 't.observaciones')
                ->get();

            // 7) TRASLADOS DESTINO
            $serv->traslados_destino = DB::table('traslados AS t')
                ->where('t.id_servicio_destino', $serv->id_servicio)
                ->whereBetween('t.fecha', [$desde, $hasta])
                ->select('t.numero_documento', 't.fecha', 't.observaciones')
                ->get();
        }
    }

    // ----------------------------------------------------
    // RETORNAR EL PDF FINA
    // ----------------------------------------------------
    return PDF::loadView('user.reportes.servicio_pdf', [
        'servicios' => $servicios,
        'desde' => $desde,
        'hasta' => $hasta,
    ])->stream("reporte_servicios.pdf");
}




private function reporteResumen($desde, $hasta, $formato)
{
    // normalizar fechas (si vienen vacías usar un rango amplio)
    $desde = $desde ?: '1970-01-01';
    $hasta = $hasta ?: date('Y-m-d');

    // convertir a Carbon para comparaciones
    $desdeC = Carbon::parse($desde)->startOfDay();
    $hastaC = Carbon::parse($hasta)->endOfDay();

    // ---------------------------
    // A. TOTALES / KPI
    // ---------------------------

    // Total activos (filtrados por fecha de creación dentro del rango)
    $totalActivos = DB::table('activos')
        ->whereBetween('created_at', [$desdeC, $hastaC])
        ->count();

    // Activos con ubicación asignada (tienen detalle_inventarios con inventario.estado = 'vigente')
    $activosConUbic = DB::table('activos as a')
        ->whereBetween('a.created_at', [$desdeC, $hastaC])
        ->whereExists(function($q){
            $q->select(DB::raw(1))
              ->from('detalle_inventarios as di')
              ->join('inventarios as i', 'di.id_inventario', '=', 'i.id_inventario')
              ->whereRaw('di.id_activo = a.id_activo')
              ->where('i.estado', 'vigente');
        })
        ->count();

    // Activos sin ubicación
    $activosSinUbic = max(0, $totalActivos - $activosConUbic);

    // Activos dados de baja (por estado_situacion = 'baja', dentro rango de creación)
    // (o contar bajas table dentro fecha rango — aquí consideramos estado_situacion)
    $activosBaja = DB::table('activos')
        ->whereBetween('created_at', [$desdeC, $hastaC])
        ->where('estado_situacional', 'baja')
        ->count();

    // Adquisiciones por tipo (conteo)
    $adq_totales = DB::table('adquisiciones')
        ->whereBetween('fecha', [$desdeC, $hastaC])
        ->select('tipo', DB::raw('count(*) as cnt'))
        ->groupBy('tipo')
        ->pluck('cnt','tipo')
        ->toArray();

    $adqCompra = (int)($adq_totales['COMPRA'] ?? 0);
    $adqDonacion = (int)($adq_totales['DONACION'] ?? 0);
    $adqOtros = (int)($adq_totales['OTRO'] ?? 0);

    // Monto total y promedio de compras (usar tabla compras ligada a adquisiciones)
    $compraData = DB::table('adquisiciones as a')
        ->join('compras as c', 'a.id_adquisicion', '=', 'c.id_adquisicion')
        ->where('a.tipo', 'COMPRA')
        ->whereBetween('a.fecha', [$desdeC, $hastaC])
        ->select(DB::raw('COUNT(*) as cnt'), DB::raw('COALESCE(SUM(c.precio),0) as total_precio'))
        ->first();

    $compra_count = $compraData->cnt ?? 0;
    $compra_total_monto = (float)($compraData->total_precio ?? 0);
    $compra_precio_prom = $compra_count ? round($compra_total_monto / $compra_count, 2) : 0;

    // Total servicios
    $totalServicios = DB::table('servicios')->count();

    // Inventarios realizados este año (year of fecha)
    $inventariosThisYear = DB::table('inventarios')
        ->whereYear('fecha', Carbon::now()->year)
        ->count();

    // Activos agregados este mes
    $activosEsteMes = DB::table('activos')
        ->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();

    // ---------------------------
    // B. Clasificación por estado físico (tabla estados)
    // ---------------------------
    $estadosFisicos = DB::table('estados as e')
        ->leftJoin('activos as a', 'a.id_estado', '=', 'e.id_estado')
        ->select('e.nombre', DB::raw('COUNT(a.id_activo) as total'))
        ->groupBy('e.id_estado', 'e.nombre')
        ->get();

    // calcular porcentajes (con respecto a totalActivos, si totalActivos=0 evitar división)
    $estadosFisicos = $estadosFisicos->map(function($row) use ($totalActivos) {
        $row->porcentaje = $totalActivos ? round(($row->total / $totalActivos) * 100, 2) : 0;
        return $row;
    });

    // ---------------------------
    // C. Clasificación por adquisición (cantidad/porcentaje/monto/promedio)
    // ---------------------------
    // cantidad ya calculada (adqCompra, adqDonacion, adqOtros)
    $adq_total_general = $adqCompra + $adqDonacion + $adqOtros;
    $adq_pct_compra = $adq_total_general ? round($adqCompra / $adq_total_general * 100, 2) : 0;
    $adq_pct_donacion = $adq_total_general ? round($adqDonacion / $adq_total_general * 100, 2) : 0;
    $adq_pct_otros = $adq_total_general ? round($adqOtros / $adq_total_general * 100, 2) : 0;

    // total monto de donaciones (si guardaste precio en donaciones)
    $donacion_total_monto = DB::table('adquisiciones as a')
        ->join('donaciones as d', 'a.id_adquisicion', '=', 'd.id_adquisicion')
        ->where('a.tipo', 'DONACION')
        ->whereBetween('a.fecha', [$desdeC, $hastaC])
        ->select(DB::raw('COALESCE(SUM(d.precio),0) as total'))
        ->value('total') ?? 0;

    // ---------------------------
    // D. MOVIMIENTOS (recuento por tablas reales)
    // ---------------------------
    $total_entregas = DB::table('entregas')->whereBetween('fecha', [$desdeC, $hastaC])->count();
    $total_devoluciones = DB::table('devoluciones')->whereBetween('fecha', [$desdeC, $hastaC])->count();
    $total_traslados = DB::table('traslados')->whereBetween('fecha', [$desdeC, $hastaC])->count();
    // "asignaciones" consideraremos entregas (entregas = asignaciones)
    $total_asignaciones = $total_entregas;

    // total movimientos sum (entregas + devoluciones + traslados + inventarios + bajas)
    $total_inventarios = DB::table('inventarios')->whereBetween('fecha', [$desdeC, $hastaC])->count();
    $total_bajas = DB::table('bajas')->whereBetween('fecha', [$desdeC, $hastaC])->count();

    $total_movimientos_registrados = $total_entregas + $total_devoluciones + $total_traslados + $total_inventarios + $total_bajas;

    // ---------------------------
    // E. Bajas (detalle por año)
    // ---------------------------
    $bajasPorAnio = DB::table('bajas')
        ->select(DB::raw('YEAR(fecha) as anio'), DB::raw('COUNT(*) as total'))
        ->groupBy(DB::raw('YEAR(fecha)'))
        ->orderBy('anio', 'desc')
        ->get();

    // ---------------------------
    // F. Servicios
    // ---------------------------
    // TOP 10 servicios con más activos: contaremos activos ubicados por inventario vigente en ese servicio
    $topServicios = DB::table('servicios as s')
        ->join('inventarios as i', 's.id_servicio', '=', 'i.id_servicio')
        ->join('detalle_inventarios as di', 'i.id_inventario', '=', 'di.id_inventario')
        ->join('activos as a', 'di.id_activo', '=', 'a.id_activo')
        ->where('i.estado', 'vigente')
        ->whereBetween('a.created_at', [$desdeC, $hastaC])
        ->select('s.id_servicio','s.nombre', DB::raw('COUNT(DISTINCT a.id_activo) as total'))
        ->groupBy('s.id_servicio','s.nombre')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    // servicios sin activos (servicios que no aparecen unidos con detalle_inventarios vigentes)
$topServiciosConBajas = DB::table('bajas as b')
    ->join('servicios as s', 'b.id_servicio', '=', 's.id_servicio')
    ->whereBetween('b.fecha', [$desde, $hasta])   // FILTRO DE RANGO
    ->select(
        's.id_servicio',
        's.nombre',
        DB::raw('COUNT(b.id_baja) as total_bajas')
    )
    ->groupBy('s.id_servicio', 's.nombre')
    ->orderByDesc('total_bajas')
    ->limit(10)
    ->get();


    // ---------------------------
    // G. Antigüedad
    // ---------------------------
    $activosMasAntiguos = DB::table('activos')
        ->whereBetween('created_at', [$desdeC, $hastaC])
        ->orderBy('created_at', 'asc')
        ->limit(20)
        ->get();

    // Cantidad de activos comprados/donados por año
    $adqPorAnio = DB::table('adquisiciones as a')
        ->select(DB::raw('YEAR(a.fecha) as anio'), 'a.tipo', DB::raw('COUNT(*) as total'))
        ->groupBy(DB::raw('YEAR(a.fecha)'), 'a.tipo')
        ->orderBy('anio', 'desc')
        ->get();

    // primer año registrado (por adquisiciones o activos)
    $primerAnio = DB::table('adquisiciones')->select(DB::raw('MIN(YEAR(fecha)) as primer'))->value('primer') ??
                  DB::table('activos')->select(DB::raw('MIN(YEAR(created_at)) as primer'))->value('primer');

    // ---------------------------
    // H. Inventarios
    // ---------------------------
    $inventariosPorAnio = DB::table('inventarios')
        ->select('gestion', DB::raw('COUNT(*) as total'))
        ->groupBy('gestion')
        ->orderBy('gestion','desc')
        ->get();

    $inventariosThisYear = DB::table('inventarios')
        ->whereYear('fecha', Carbon::now()->year)
        ->count();

    // inventarios pendientes (inventarios con estado distinto a 'finalizado' o 'concluido')
    $inventariosPendientes = DB::table('inventarios')
        ->whereNotIn('estado', ['finalizado','concluido'])
        ->count();

    // ---------------------------
    // Adicional: categorias (cantidad por categoría)
    // ---------------------------
    $categoriasResumen = DB::table('categorias as c')
        ->leftJoin('activos as a', 'c.id_categoria', '=', 'a.id_categoria')
        ->select('c.id_categoria','c.nombre', DB::raw('COUNT(a.id_activo) as total'))
        ->groupBy('c.id_categoria','c.nombre')
        ->orderByDesc('total')
        ->get();

    // ---------------------------
    // Prepara data para la vista / pdf
    // ---------------------------
    $data = [
        // A
        'totalActivos' => $totalActivos,
        'activosConUbic' => $activosConUbic,
        'activosSinUbic' => $activosSinUbic,
        'activosBaja' => $activosBaja,
        'adqCompra' => $adqCompra,
        'adqDonacion' => $adqDonacion,
        'adqOtros' => $adqOtros,
        'totalServicios' => $totalServicios,
        'inventariosThisYear' => $inventariosThisYear,
        'activosEsteMes' => $activosEsteMes,

        // B
        'estadosFisicos' => $estadosFisicos,

        // C
        'adq_total_general' => $adq_total_general,
        'adq_pct_compra' => $adq_pct_compra,
        'adq_pct_donacion' => $adq_pct_donacion,
        'adq_pct_otros' => $adq_pct_otros,
        'compra_total_monto' => $compra_total_monto,
        'compra_precio_prom' => $compra_precio_prom,
        'donacion_total_monto' => $donacion_total_monto,

        // D
        'total_movimientos_registrados' => $total_movimientos_registrados,
        'total_entregas' => $total_entregas,
        'total_devoluciones' => $total_devoluciones,
        'total_traslados' => $total_traslados,
        'total_asignaciones' => $total_asignaciones,

        // E
        'total_bajas' => $total_bajas,
        'bajasPorAnio' => $bajasPorAnio,

        // F
        'topServicios' => $topServicios,
        'topServiciosConBajas' => $topServiciosConBajas,
        'totalServicios' => $totalServicios,

        // G
        'activosMasAntiguos' => $activosMasAntiguos,
        'adqPorAnio' => $adqPorAnio,
        'primerAnio' => $primerAnio,

        // H
        'inventariosPorAnio' => $inventariosPorAnio,
        'inventariosThisYear' => $inventariosThisYear,
        'inventariosPendientes' => $inventariosPendientes,

        // categorias
        'categoriasResumen' => $categoriasResumen,
    ];

    // ---------------------------
    // RETORNAR PDF (o según formato, aquí siempre PDF)
    // ---------------------------
    return PDF::loadView('user.reportes.resumen_pdf', $data)->stream("resumen_general.pdf");
}















    public function resumen(Request $req)
    {
        $activos = $req->activos;

        // 🔥 Si llega como string JSON → convertir a array
        if (is_string($activos)) {
            $activos = json_decode($activos, true);
        }

        // 🔥 Si por alguna razón sigue sin ser array → crear array vacío
        if (!is_array($activos)) {
            $activos = [];
        } // 🔥 recibimos la misma variable
        // dd($activos);
        $tipo    = $req->tipo;
        $desde   = $req->desde;
        $hasta   = $req->hasta;
        $formato = $req->formato;

        // Puedes procesar según el tipo de reporte
        // ejemplo:
        // if ($tipo == 'servicio') { ... }

        // Renderizar el PDF
        $pdf = Pdf::loadView('user.reportes.resumen_pdf', [
            'activos' => $activos,
            'tipo'    => $tipo,
            'desde'   => $desde,
            'hasta'   => $hasta
        ]);

        return $pdf->stream('reporte.pdf'); // abrir en navegador
    }
    // public function filtrar(Request $req)
    // {
    //     $search   = $req->search;
    //     $servicio = $req->servicio;
    //     $estado   = $req->estado;
    //     $tipo     = $req->tipo;

    //     /* =====================================================
    //        INVENTARIO
    //     ======================================================*/
    //     $inventario = DB::table('activos as a')
    //         ->leftJoin('estados as e', 'e.id_estado', '=', 'a.id_estado')
    //         ->leftJoin('categorias as c', 'c.id_categoria', '=', 'a.id_categoria')
    //         ->leftJoin('unidades as u', 'u.id_unidad', '=', 'a.id_unidad')
    //         ->leftJoin('detalle_inventarios as di', 'di.id_activo', '=', 'a.id_activo')
    //         ->leftJoin('inventarios as i', 'i.id_inventario', '=', 'di.id_inventario')
    //         ->leftJoin('servicios as s', 's.id_servicio', '=', 'i.id_servicio')

    //         // ÚLTIMA ENTREGA PARA OBTENER RESPONSABLE
    //         ->leftJoin('detalle_entregas as de', 'de.id_activo', '=', 'a.id_activo')
    //         ->leftJoin('entregas as en', 'en.id_entrega', '=', 'de.id_entrega')
    //         ->leftJoin('responsables as r', 'r.id_responsable', '=', 'en.id_responsable')

    //         ->select(
    //             'a.id_activo',
    //             'a.codigo',
    //             'a.nombre',
    //             's.nombre as servicio',
    //             'u.nombre as unidad',
    //             'e.nombre as estado',
    //             // CORREGIDO → si NO hay servicio, NO debe haber responsable
    //             DB::raw("
    //                 CASE
    //                     WHEN s.id_servicio IS NULL THEN '-'
    //                     WHEN r.nombre IS NULL THEN '-'
    //                     ELSE r.nombre
    //                 END as asignado_a
    //             ")
    //         )

    //         ->when($search, function($q) use ($search){
    //             $q->where(function($qq) use ($search){
    //                 $qq->where('a.codigo','LIKE',"%$search%")
    //                    ->orWhere('a.nombre','LIKE',"%$search%");
    //             });
    //         })

    //         ->when($servicio, fn($q)=>$q->where('s.nombre',$servicio))
    //         ->when($estado, fn($q)=>$q->where('e.nombre',$estado))

    //         ->groupBy(
    //             'a.id_activo',
    //             'a.codigo',
    //             'a.nombre',
    //             's.nombre',
    //             'u.nombre',
    //             'e.nombre',
    //             'r.nombre',
    //             's.id_servicio'
    //         )
    //         ->get();


    //     /* =====================================================
    //        MOVIMIENTOS
    //     ======================================================*/
    //     $movs = collect();

    //     /* ENTRADAS */
    //     $entradas = DB::table('detalle_entregas as d')
    //         ->join('entregas as e', 'e.id_entrega', '=', 'd.id_entrega')
    //         ->join('activos as a', 'a.id_activo', '=', 'd.id_activo')
    //         ->join('responsables as r','r.id_responsable','=','e.id_responsable')
    //         ->join('servicios as s','s.id_servicio','=','e.id_servicio')
    //         ->join('estados as est','est.id_estado','=','a.id_estado')

    //         ->select(
    //             'a.codigo',
    //             'a.nombre',
    //             's.nombre as servicio',
    //             'r.nombre as responsable',
    //             'e.fecha',
    //             DB::raw("'Entrada' as tipo"),
    //             'est.nombre as estado'
    //         )

    //         ->when($search, function($q) use ($search){
    //             $q->where(function($qq) use ($search){
    //                 $qq->where('a.codigo','LIKE',"%$search%")
    //                    ->orWhere('a.nombre','LIKE',"%$search%");
    //             });
    //         })
    //         ->when($servicio, fn($q)=>$q->where('s.nombre',$servicio))
    //         ->when($estado, fn($q)=>$q->where('est.nombre',$estado))
    //         ->get();


    //     /* TRASLADOS */
    //     $traslados = DB::table('detalle_traslados as d')
    //         ->join('traslados as t', 't.id_traslado', '=', 'd.id_traslado')
    //         ->join('activos as a', 'a.id_activo', '=', 'd.id_activo')
    //         ->join('responsables as r','r.id_responsable','=','t.id_responsable_destino')
    //         ->join('servicios as s','s.id_servicio','=','t.id_servicio_destino')
    //         ->join('estados as est','est.id_estado','=','a.id_estado')

    //         ->select(
    //             'a.codigo',
    //             'a.nombre',
    //             's.nombre as servicio',
    //             'r.nombre as responsable',
    //             't.fecha',
    //             DB::raw("'Traslado' as tipo"),
    //             'est.nombre as estado'
    //         )

    //         ->when($search, function($q) use ($search){
    //             $q->where(function($qq) use ($search){
    //                 $qq->where('a.codigo','LIKE',"%$search%")
    //                    ->orWhere('a.nombre','LIKE',"%$search%");
    //             });
    //         })
    //         ->when($servicio, fn($q)=>$q->where('s.nombre',$servicio))
    //         ->when($estado, fn($q)=>$q->where('est.nombre',$estado))
    //         ->get();


    //     /* DEVOLUCIONES */
    //     $devoluciones = DB::table('detalle_devoluciones as d')
    //         ->join('devoluciones as dv', 'dv.id_devolucion', '=', 'd.id_devolucion')
    //         ->join('activos as a', 'a.id_activo', '=', 'd.id_activo')
    //         ->join('responsables as r','r.id_responsable','=','dv.id_responsable')
    //         ->join('servicios as s','s.id_servicio','=','dv.id_servicio')
    //         ->join('estados as est','est.id_estado','=','a.id_estado')

    //         ->select(
    //             'a.codigo',
    //             'a.nombre',
    //             's.nombre as servicio',
    //             'r.nombre as responsable',
    //             'dv.fecha',
    //             DB::raw("'Devolución' as tipo"),
    //             'est.nombre as estado'
    //         )

    //         ->when($search, function($q) use ($search){
    //             $q->where(function($qq) use ($search){
    //                 $qq->where('a.codigo','LIKE',"%$search%")
    //                    ->orWhere('a.nombre','LIKE',"%$search%");
    //             });
    //         })
    //         ->when($servicio, fn($q)=>$q->where('s.nombre',$servicio))
    //         ->when($estado, fn($q)=>$q->where('est.nombre',$estado))
    //         ->get();


    //     /* UNIFICAR MOVIMIENTOS */
    //     $movs = $movs->merge($entradas)->merge($traslados)->merge($devoluciones);

    //     if ($tipo) {
    //         $movs = $movs->where('tipo', $tipo)->values();
    //     }

    //     return response()->json([
    //         "inventario"  => $inventario,
    //         "movimientos" => $movs
    //     ]);
    // }
  public function filtrar(Request $req)
{
    $servicio  = $req->servicio;
    $categoria = $req->categoria;
    $estado    = $req->estado;

    $query = Activo::query()
        ->with([
            'categoria',
            'unidad',
            'estado',
            'adquisicion',
            'adquisicion.compra',
            'adquisicion.donacion',
            'detalles.inventario.servicio'
        ]);

    // FILTRO: SERVICIO (ubicación)
    if ($servicio != "") {
        $query->whereHas('detalles.inventario', function ($q) use ($servicio) {
            $q->where('estado', 'vigente')
              ->where('id_servicio', $servicio);
        });
    }

    // FILTRO: CATEGORÍA
    if ($categoria != "") {
        $query->where('id_categoria', $categoria);
    }

    // FILTRO: ESTADO
    if ($estado != "") {
        $query->where('id_estado', $estado);
    }

    $activos = $query->get();

    // UBICACIÓN ACTUAL
    $activos->transform(function ($a) {

        $inventarioVigente = $a->detalles
            ->where('inventario.estado', 'vigente')
            ->first();

        if ($inventarioVigente) {
            $a->ubicacion_actual = $inventarioVigente->inventario->servicio->nombre;
        } else {
            $a->ubicacion_actual = "SIN UBICACIÓN";
        }

        return $a;
    });

    /*  
    ===========================================================
      🔥 AQUÍ GUARDAMOS LOS ACTIVOS FILTRADOS EN LA SESIÓN
    ===========================================================
    */
    session(['activos_filtrados' => $activos]);

    return response()->json([
        "success" => true,
        "activos" => $activos
    ]);
}


    // public function generar(Request $req)
    // {
    //     $from = $req->fromDate;
    //     $to   = $req->toDate;
    //     $type = $req->reportType;

    //     // Datos filtrados enviados desde el frontend
    //     $inventoryData = $req->inventoryData ?? [];
    //     $movementData  = $req->movementData ?? [];

    //     /* --------------------------------------------
    //     FILTRO DE FECHA REUTILIZABLE (cuando aplica)
    // ---------------------------------------------*/
    //     $dateFilter = fn($q, $col = 'fecha') =>
    //     $q->when($from, fn($q) => $q->whereDate($col, '>=', $from))
    //         ->when($to,   fn($q) => $q->whereDate($col, '<=', $to));

    //     /* --------------------------------------------
    //     SWITCH PRINCIPAL — TODAS LAS OPCIONES
    // ---------------------------------------------*/

    //     switch ($type) {

    //         /* ════════════════════════════════════════════
    //         1) RESUMEN RÁPIDO  (NO USA FILTROS, USA TODO)
    //  case 'kpi_overview':

    // /* ============================================================
    //    1) TOTAL DE ACTIVOS
    // ============================================================ */
    //         case 'kpi_overview':
    //             $totalActivos = DB::table('activos')->count();


    //             /* ============================================================
    //    2) ACTIVOS ASIGNADOS (sin devolución)
    // ============================================================ */
    //             $asignados = DB::table('detalle_entregas as d')
    //                 ->leftJoin('detalle_devoluciones as dv', 'dv.id_activo', '=', 'd.id_activo')
    //                 ->whereNull('dv.id_activo')
    //                 ->count();


    //             /* ============================================================
    //    3) ACTIVOS NO ASIGNADOS
    // ============================================================ */
    //             $noAsignados = $totalActivos - $asignados;


    //             /* ============================================================
    //    4) ACTIVOS DADOS DE BAJA
    // ============================================================ */
    //             $bajas = DB::table('bajas')->count();


    //             /* ============================================================
    //    5) ACTIVOS POR ESTADO FÍSICO
    // ============================================================ */
    //             $porEstado = DB::table('activos')
    //                 ->join('estados', 'estados.id_estado', '=', 'activos.id_estado')
    //                 ->select('estados.nombre as estado', DB::raw("COUNT(*) as total"))
    //                 ->groupBy('estados.id_estado')
    //                 ->get();


    //             /* ============================================================
    //    6) ACTIVOS POR SERVICIO
    // ============================================================ */
    //             $porServicio = DB::table('inventarios')
    //                 ->join('servicios', 'servicios.id_servicio', '=', 'inventarios.id_servicio')
    //                 ->select('servicios.nombre as servicio', DB::raw("COUNT(*) as total"))
    //                 ->groupBy('servicios.id_servicio')
    //                 ->get();


    //             /* ============================================================
    //    7) ACTIVOS POR CATEGORÍA
    // ============================================================ */
    //             $porCategoria = DB::table('activos')
    //                 ->join('unidades', 'unidades.id_unidad', '=', 'activos.id_unidad')
    //                 ->select('unidades.nombre as categoria', DB::raw("COUNT(*) as total"))
    //                 ->groupBy('unidades.id_unidad')
    //                 ->get();


    //             /* ============================================================
    //    8) ÚLTIMOS 10 MOVIMIENTOS UNIDOS
    //       (ENTREGAS + TRASLADOS + DEVOLUCIONES)
    // ============================================================ */
    //             $ultMovimientos = collect([]);

    //             // ENTREGAS FINALIZADAS
    //             // ENTREGAS FINALIZADAS
    //             $entregas = DB::table('detalle_entregas as d')
    //                 ->join('entregas as e', 'e.id_entrega', '=', 'd.id_entrega')
    //                 ->join('responsables as r', 'r.id_responsable', '=', 'e.id_responsable')
    //                 ->where('e.estado', 'finalizado')
    //                 ->select(
    //                     DB::raw("'ENTREGA' as tipo"),
    //                     'd.id_activo',
    //                     'e.fecha',
    //                     DB::raw("r.nombre as responsable"),
    //                     'e.usuario',
    //                     'e.observacion'
    //                 );

    //             // DEVOLUCIONES FINALIZADAS
    //             $devoluciones = DB::table('detalle_devoluciones as d')
    //                 ->join('devoluciones as e', 'e.id_devolucion', '=', 'd.id_devolucion')
    //                 ->join('responsables as r', 'r.id_responsable', '=', 'e.id_responsable')
    //                 ->where('e.estado', 'finalizado')
    //                 ->select(
    //                     DB::raw("'DEVOLUCIÓN' as tipo"),
    //                     'd.id_activo',
    //                     'e.fecha',
    //                     DB::raw("r.nombre as responsable"),
    //                     'e.usuario',
    //                     'e.observacion'
    //                 );

    //             // TRASLADOS FINALIZADOS
    //             $traslados = DB::table('detalle_traslados as d')
    //                 ->join('traslados as e', 'e.id_traslado', '=', 'd.id_traslado')
    //                 ->join('servicios as so', 'so.id_servicio', '=', 'e.id_servicio_origen')
    //                 ->join('servicios as sd', 'sd.id_servicio', '=', 'e.id_servicio_destino')
    //                 ->where('e.estado', 'finalizado')
    //                 ->select(
    //                     DB::raw("'TRASLADO' as tipo"),
    //                     'd.id_activo',
    //                     'e.fecha',
    //                     DB::raw("CONCAT(so.nombre, ' → ', sd.nombre) as responsable"),
    //                     'e.usuario',
    //                     'e.observacion'
    //                 );

    //             // UNIÓN FINAL
    //             $ultMovimientos = $entregas
    //                 ->unionAll($devoluciones)
    //                 ->unionAll($traslados)
    //                 ->orderBy('fecha', 'DESC')
    //                 ->limit(10)
    //                 ->get();



    //             /* ============================================================
    //    9) TOTAL ENTREGAS
    // ============================================================ */
    //             $totalEntregas = DB::table('entregas')
    //                 ->where('estado', 'finalizado')
    //                 ->count();


    //             /* ============================================================
    //    10) TOTAL DEVOLUCIONES
    // ============================================================ */
    //             $totalDevoluciones = DB::table('devoluciones')
    //                 ->where('estado', 'finalizado')
    //                 ->count();


    //             /* ============================================================
    //    11) TOTAL SERVICIOS
    // ============================================================ */
    //             $servicios = DB::table('servicios')->count();


    //             /* ============================================================
    //    12) TOTAL CATEGORÍAS
    // ============================================================ */
    //             $totalCategorias = DB::table('unidades')->count();


    //             /* ============================================================
    //    13) ACTIVOS RECIENTES
    // ============================================================ */
    //             $recientes = DB::table('activos')
    //                 ->orderBy('fecha_registro', 'desc')
    //                 ->limit(10)
    //                 ->get();


    //             /* ============================================================
    //    RETURN FINAL
    // ============================================================ */
    //             return response()->json([
    //                 "title" => "Resumen rápido",
    //                 "data"  => [
    //                     "total_activos"         => $totalActivos,
    //                     "activos_asignados"     => $asignados,
    //                     "activos_no_asignados"  => $noAsignados,
    //                     "activos_baja"          => $bajas,

    //                     "por_estado"            => $porEstado,
    //                     "por_servicio"          => $porServicio,
    //                     "por_categoria"         => $porCategoria,

    //                     "ultimos_movimientos"   => $ultMovimientos,

    //                     "total_entregas"        => $totalEntregas,
    //                     "total_devoluciones"    => $totalDevoluciones,

    //                     "total_servicios"       => $servicios,
    //                     "total_categorias"      => $totalCategorias,

    //                     "activos_recientes"     => $recientes,
    //                 ]
    //             ]);



    //             /* ════════════════════════════════════════════
    //         2) INVENTARIO DETALLADO (USA RESULTADOS FILTRADOS)
    //     ════════════════════════════════════════════ */
    //         case 'inventory_detail':

    //             return response()->json([
    //                 "title" => "Inventario detallado",
    //                 "data"  => $inventoryData     // filtrado desde el frontend
    //             ]);


    //             /* ════════════════════════════════════════════
    //         3) MOVIMIENTOS (USA RESULTADOS FILTRADOS)
    //     ════════════════════════════════════════════ */
    //         case 'movements_summary':

    //             return response()->json([
    //                 "title" => "Movimientos",
    //                 "data"  => $movementData
    //             ]);


    //             /* ════════════════════════════════════════════
    //         4) ACTIVOS POR SERVICIO (CONSULTA BD)
    //     ════════════════════════════════════════════ */
    //         case 'assets_by_service':

    //             $result = DB::table('detalle_inventarios')
    //                 ->join('inventarios', 'inventarios.id_inventario', '=', 'detalle_inventarios.id_inventario')
    //                 ->join('servicios', 'servicios.id_servicio', '=', 'inventarios.id_servicio')
    //                 ->join('activos', 'activos.id_activo', '=', 'detalle_inventarios.id_activo')
    //                 ->select('servicios.nombre as servicio', DB::raw("COUNT(*) as total"))
    //                 ->groupBy('servicios.id_servicio')
    //                 ->orderBy('total', 'desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por servicio",
    //                 "data"  => $result
    //             ]);


    //             /* ════════════════════════════════════════════
    //         5) ACTIVOS POR CATEGORÍA
    //     ════════════════════════════════════════════ */
    //         case 'assets_by_category':

    //             $result = DB::table('activos')
    //                 ->join('unidades', 'unidades.id_unidad', '=', 'activos.id_unidad')
    //                 ->select('unidades.nombre as categoria', DB::raw("COUNT(*) as total"))
    //                 ->groupBy('unidades.id_unidad')
    //                 ->orderBy('total', 'desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por categoría",
    //                 "data" => $result
    //             ]);


    //             /* ════════════════════════════════════════════
    //         6) ACTIVOS POR NOMBRE
    //     ════════════════════════════════════════════ */
    //         case 'assets_by_name':

    //             $result = DB::table('activos')
    //                 ->select('nombre', DB::raw("COUNT(*) as total"))
    //                 ->groupBy('nombre')
    //                 ->orderBy('total', 'desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por nombre",
    //                 "data" => $result
    //             ]);


    //             /* ════════════════════════════════════════════
    //         7) ACTIVOS POR ADQUISICIÓN
    //     ════════════════════════════════════════════ */
    //         case 'assets_by_acquisition':

    //             $result = DB::table('activos')
    //                 ->select('origen', DB::raw("COUNT(*) as total"))
    //                 ->groupBy('origen')
    //                 ->orderBy('total', 'desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por adquisición",
    //                 "data" => $result
    //             ]);


    //             /* ════════════════════════════════════════════
    //         8) LISTA DE SERVICIOS
    //     ════════════════════════════════════════════ */
    //         case 'list_services':

    //             $serv = DB::table('servicios')->select('nombre')->orderBy('nombre')->get();

    //             return response()->json([
    //                 "title" => "Lista de servicios",
    //                 "data" => $serv
    //             ]);


    //             /* ════════════════════════════════════════════
    //         9) ACTIVOS ASIGNADOS
    //     ════════════════════════════════════════════ */
    //         case 'assigned_assets':

    //             $asignados = DB::table('detalle_entregas as d')
    //                 ->leftJoin('detalle_devoluciones as dv', 'dv.id_activo', '=', 'd.id_activo')
    //                 ->join('activos as a', 'a.id_activo', '=', 'd.id_activo')
    //                 ->join('entregas as e', 'e.id_entrega', '=', 'd.id_entrega')
    //                 ->join('responsables as r', 'r.id_responsable', '=', 'e.id_responsable')
    //                 ->join('servicios as s', 's.id_servicio', '=', 'e.id_servicio')
    //                 ->whereNull('dv.id_activo')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos asignados",
    //                 "data" => $asignados
    //             ]);


    //             /* ════════════════════════════════════════════
    //         10) ACTIVOS NO ASIGNADOS
    //     ════════════════════════════════════════════ */
    //         case 'unassigned_assets':

    //             $ids = DB::table('detalle_entregas')->pluck('id_activo')->toArray();

    //             $no = DB::table('activos')
    //                 ->whereNotIn('id_activo', $ids)
    //                 ->select('codigo', 'nombre')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos no asignados",
    //                 "data" => $no
    //             ]);


    //             /* ════════════════════════════════════════════
    //         11) ACTIVOS DE BAJA
    //     ════════════════════════════════════════════ */
    //         case 'assets_low':

    //             $bajas = DB::table('bajas')
    //                 ->join('activos', 'activos.id_activo', '=', 'bajas.id_activo')
    //                 ->join('responsables', 'responsables.id_responsable', '=', 'bajas.id_responsable')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos de baja",
    //                 "data" => $bajas
    //             ]);


    //             /* ════════════════════════════════════════════
    //         12) ACTIVOS POR ESTADO
    //     ════════════════════════════════════════════ */
    //         case 'assets_by_condition':

    //             $result = DB::table('activos')
    //                 ->join('estados', 'estados.id_estado', '=', 'activos.id_estado')
    //                 ->select('estados.nombre as estado', DB::raw("COUNT(*) as total"))
    //                 ->groupBy('estados.id_estado')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por estado",
    //                 "data" => $result
    //             ]);
    //     }

    //     return response()->json(["error" => "Tipo inválido"]);
    // }


    // public function generar(Request $req)
    // {
    //     $from = $req->fromDate;
    //     $to   = $req->toDate;
    //     $type = $req->reportType;

    //     /* --------------------------------------------
    //        FILTRO DE FECHAS DINÁMICO
    //     ---------------------------------------------*/
    //     $dateFilter = fn($q, $column = 'fecha') =>
    //         $q->when($from, fn($q)=>$q->whereDate($column,'>=',$from))
    //           ->when($to,   fn($q)=>$q->whereDate($column,'<=',$to));

    //     /* --------------------------------------------
    //         REPORTES SEGÚN reportType
    //     ---------------------------------------------*/

    //     switch ($type) {


    //         /* ════════════════════════════════════════════
    //             1) RESUMEN RÁPIDO
    //         ════════════════════════════════════════════ */
    //         case 'kpi_overview':
    //             return $this->getKpiOverview($dateFilter);



    //         /* ════════════════════════════════════════════
    //             2) INVENTARIO DETALLADO
    //         ════════════════════════════════════════════ */
    //         case 'inventory_detail':
    //             return $this->getInventoryDetail();



    //         /* ════════════════════════════════════════════
    //             3) MOVIMIENTOS
    //         ════════════════════════════════════════════ */
    //         case 'movements_summary':
    //             return $this->getMovements($dateFilter);



    //         /* ════════════════════════════════════════════
    //             4) ACTIVOS POR SERVICIO (TU ANTIGUO assets_by_area)
    //         ════════════════════════════════════════════ */
    //         case 'assets_by_service':

    //             $result = DB::table('detalle_inventarios')
    //                 ->join('inventarios','inventarios.id_inventario','=','detalle_inventarios.id_inventario')
    //                 ->join('servicios','servicios.id_servicio','=','inventarios.id_servicio')
    //                 ->join('activos','activos.id_activo','=','detalle_inventarios.id_activo')
    //                 ->select('servicios.nombre as servicio', DB::raw('COUNT(*) as total'))
    //                 ->groupBy('servicios.id_servicio')
    //                 ->orderBy('total','desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por servicio",
    //                 "data"  => $result
    //             ]);


    //         /* ════════════════════════════════════════════
    //             5) ACTIVOS POR CATEGORÍA (UNIDADES)
    //         ════════════════════════════════════════════ */
    //         case 'assets_by_category':

    //             $result = DB::table('activos')
    //                 ->join('unidades','unidades.id_unidad','=','activos.id_unidad')
    //                 ->select('unidades.nombre as categoria', DB::raw('COUNT(*) as total'))
    //                 ->groupBy('unidades.id_unidad')
    //                 ->orderBy('total','desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por categoría",
    //                 "data"  => $result
    //             ]);


    //         /* ════════════════════════════════════════════
    //             6) ACTIVOS POR NOMBRE (agrupados)
    //         ════════════════════════════════════════════ */
    //         case 'assets_by_name':

    //             $result = DB::table('activos')
    //                 ->select('nombre', DB::raw('COUNT(*) as total'))
    //                 ->groupBy('nombre')
    //                 ->orderBy('total','desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por nombre",
    //                 "data"  => $result
    //             ]);


    //         /* ════════════════════════════════════════════
    //             7) ACTIVOS POR ADQUISICIÓN (compra, donación, otros)
    //                ⚠️ Debes tener columna "origen" en activos
    //         ════════════════════════════════════════════ */
    //         case 'assets_by_acquisition':

    //             $result = DB::table('activos')
    //                 ->select('origen', DB::raw('COUNT(*) as total'))
    //                 ->groupBy('origen')
    //                 ->orderBy('total','desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por tipo de adquisición",
    //                 "data"  => $result
    //             ]);


    //         /* ════════════════════════════════════════════
    //             8) LISTA COMPLETA DE SERVICIOS
    //         ════════════════════════════════════════════ */
    //         case 'list_services':

    //             $servicios = DB::table('servicios')
    //                 ->select('nombre')
    //                 ->orderBy('nombre')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Lista de servicios",
    //                 "data"  => $servicios
    //             ]);


    //         /* ════════════════════════════════════════════
    //             9) ACTIVOS ASIGNADOS (entregados sin devolución)
    //         ════════════════════════════════════════════ */
    //         case 'assigned_assets':

    //             $asignados = DB::table('detalle_entregas as d')
    //                 ->leftJoin('detalle_devoluciones as dv','dv.id_activo','=','d.id_activo')
    //                 ->join('activos as a','a.id_activo','=','d.id_activo')
    //                 ->join('entregas as e','e.id_entrega','=','d.id_entrega')
    //                 ->join('responsables as r','r.id_responsable','=','e.id_responsable')
    //                 ->join('servicios as s','s.id_servicio','=','e.id_servicio')
    //                 ->whereNull('dv.id_activo')
    //                 ->select(
    //                     'a.codigo','a.nombre',
    //                     's.nombre as servicio',
    //                     'r.nombre as responsable',
    //                     'e.fecha as fecha_entrega'
    //                 )
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos asignados",
    //                 "data"  => $asignados
    //             ]);


    //         /* ════════════════════════════════════════════
    //             10) ACTIVOS NO ASIGNADOS
    //         ════════════════════════════════════════════ */
    //         case 'unassigned_assets':

    //             $asignados = DB::table('detalle_entregas')
    //                 ->pluck('id_activo')
    //                 ->toArray();

    //             $noAsignados = DB::table('activos')
    //                 ->whereNotIn('id_activo', $asignados)
    //                 ->select('codigo','nombre')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos no asignados",
    //                 "data"  => $noAsignados
    //             ]);


    //         /* ════════════════════════════════════════════
    //             11) ACTIVOS DADOS DE BAJA
    //         ════════════════════════════════════════════ */
    //         case 'assets_low':

    //             $bajas = DB::table('bajas')
    //                 ->join('activos','activos.id_activo','=','bajas.id_activo')
    //                 ->join('responsables','responsables.id_responsable','=','bajas.id_responsable')
    //                 ->select(
    //                     'activos.codigo','activos.nombre',
    //                     'responsables.nombre as responsable',
    //                     'bajas.fecha'
    //                 )
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos dados de baja",
    //                 "data"  => $bajas
    //             ]);


    //         /* ════════════════════════════════════════════
    //             12) ACTIVOS POR ESTADO FÍSICO
    //         ════════════════════════════════════════════ */
    //         case 'assets_by_condition':

    //             $result = DB::table('activos')
    //                 ->join('estados','estados.id_estado','=','activos.id_estado')
    //                 ->select('estados.nombre as estado', DB::raw('COUNT(*) as total'))
    //                 ->groupBy('estados.id_estado')
    //                 ->orderBy('total','desc')
    //                 ->get();

    //             return response()->json([
    //                 "title" => "Activos por estado",
    //                 "data"  => $result
    //             ]);
    //     }

    //     return response()->json(["error" => "Tipo de reporte inválido"], 400);
    // }




    public function imprimirDonantes()
    {
        // Tomamos los donantes filtrados de la sesión
        $donantes = session('donantes_filtrados', collect());

        if ($donantes->isEmpty()) {
            return back()->with('error', 'No hay donantes para imprimir.');
        }

        // Contar donantes por lugar sin alterar la lista
        $conteosPorLugar = $donantes->groupBy('tipo')->map(fn($grupo) => $grupo->count());

        // Generar PDF
        $pdf = Pdf::loadView('user.donantes.reporteDonante', [
            'donantes' => $donantes,
            'conteosPorLugar' => $conteosPorLugar
        ]);

        return $pdf->stream('reporte-proveedores.pdf');
    }

    public function imprimirProveedores()
    {
        // Tomamos los proveedores filtrados de la sesión
        $proveedores = session('proveedores_filtrados', collect());

        if ($proveedores->isEmpty()) {
            return back()->with('error', 'No hay proveedores para imprimir.');
        }

        // Contar proveedores por lugar sin alterar la lista
        $conteosPorLugar = $proveedores->groupBy('lugar')->map(fn($grupo) => $grupo->count());

        // Generar PDF
        $pdf = Pdf::loadView('user.proveedores.reporteProveedores', [
            'proveedores' => $proveedores,
            'conteosPorLugar' => $conteosPorLugar
        ]);

        return $pdf->stream('reporte-proveedores.pdf');
    }






    public function imprimirActas()
    {
        $resultados = session('resultados_filtrados', collect());

        if ($resultados->isEmpty()) {
            return back()->with('error', 'No hay resultados para imprimir.');
        }

        $pdf = Pdf::loadView('user.movimientos.reporte', [
            'resultados' => $resultados
        ]);

        return $pdf->stream('reporte-actas.pdf');
    }
}
