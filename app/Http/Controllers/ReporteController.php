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
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{

public function global()
{
    // Para filtros
    $servicios = DB::table('servicios')->get();
    $estados   = DB::table('estados')->get();

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
        'total_activos',
        'activos_asignados',
        'activos_disponibles',
        'activos_baja'
    ));
}

public function filtrar(Request $req)
{
    $search   = $req->search;
    $servicio = $req->servicio;
    $estado   = $req->estado;
    $tipo     = $req->tipo;

    /* =====================================================
       INVENTARIO
    ======================================================*/
    $inventario = DB::table('activos as a')
        ->leftJoin('estados as e', 'e.id_estado', '=', 'a.id_estado')
        ->leftJoin('categorias as c', 'c.id_categoria', '=', 'a.id_categoria')
        ->leftJoin('unidades as u', 'u.id_unidad', '=', 'a.id_unidad')
        ->leftJoin('detalle_inventarios as di', 'di.id_activo', '=', 'a.id_activo')
        ->leftJoin('inventarios as i', 'i.id_inventario', '=', 'di.id_inventario')
        ->leftJoin('servicios as s', 's.id_servicio', '=', 'i.id_servicio')

        // ÚLTIMA ENTREGA PARA OBTENER RESPONSABLE
        ->leftJoin('detalle_entregas as de', 'de.id_activo', '=', 'a.id_activo')
        ->leftJoin('entregas as en', 'en.id_entrega', '=', 'de.id_entrega')
        ->leftJoin('responsables as r', 'r.id_responsable', '=', 'en.id_responsable')

        ->select(
            'a.id_activo',
            'a.codigo',
            'a.nombre',
            's.nombre as servicio',
            'u.nombre as unidad',
            'e.nombre as estado',
            // CORREGIDO → si NO hay servicio, NO debe haber responsable
            DB::raw("
                CASE
                    WHEN s.id_servicio IS NULL THEN '-'
                    WHEN r.nombre IS NULL THEN '-'
                    ELSE r.nombre
                END as asignado_a
            ")
        )

        ->when($search, function($q) use ($search){
            $q->where(function($qq) use ($search){
                $qq->where('a.codigo','LIKE',"%$search%")
                   ->orWhere('a.nombre','LIKE',"%$search%");
            });
        })

        ->when($servicio, fn($q)=>$q->where('s.nombre',$servicio))
        ->when($estado, fn($q)=>$q->where('e.nombre',$estado))

        ->groupBy(
            'a.id_activo',
            'a.codigo',
            'a.nombre',
            's.nombre',
            'u.nombre',
            'e.nombre',
            'r.nombre',
            's.id_servicio'
        )
        ->get();


    /* =====================================================
       MOVIMIENTOS
    ======================================================*/
    $movs = collect();

    /* ENTRADAS */
    $entradas = DB::table('detalle_entregas as d')
        ->join('entregas as e', 'e.id_entrega', '=', 'd.id_entrega')
        ->join('activos as a', 'a.id_activo', '=', 'd.id_activo')
        ->join('responsables as r','r.id_responsable','=','e.id_responsable')
        ->join('servicios as s','s.id_servicio','=','e.id_servicio')
        ->join('estados as est','est.id_estado','=','a.id_estado')

        ->select(
            'a.codigo',
            'a.nombre',
            's.nombre as servicio',
            'r.nombre as responsable',
            'e.fecha',
            DB::raw("'Entrada' as tipo"),
            'est.nombre as estado'
        )

        ->when($search, function($q) use ($search){
            $q->where(function($qq) use ($search){
                $qq->where('a.codigo','LIKE',"%$search%")
                   ->orWhere('a.nombre','LIKE',"%$search%");
            });
        })
        ->when($servicio, fn($q)=>$q->where('s.nombre',$servicio))
        ->when($estado, fn($q)=>$q->where('est.nombre',$estado))
        ->get();


    /* TRASLADOS */
    $traslados = DB::table('detalle_traslados as d')
        ->join('traslados as t', 't.id_traslado', '=', 'd.id_traslado')
        ->join('activos as a', 'a.id_activo', '=', 'd.id_activo')
        ->join('responsables as r','r.id_responsable','=','t.id_responsable_destino')
        ->join('servicios as s','s.id_servicio','=','t.id_servicio_destino')
        ->join('estados as est','est.id_estado','=','a.id_estado')

        ->select(
            'a.codigo',
            'a.nombre',
            's.nombre as servicio',
            'r.nombre as responsable',
            't.fecha',
            DB::raw("'Traslado' as tipo"),
            'est.nombre as estado'
        )

        ->when($search, function($q) use ($search){
            $q->where(function($qq) use ($search){
                $qq->where('a.codigo','LIKE',"%$search%")
                   ->orWhere('a.nombre','LIKE',"%$search%");
            });
        })
        ->when($servicio, fn($q)=>$q->where('s.nombre',$servicio))
        ->when($estado, fn($q)=>$q->where('est.nombre',$estado))
        ->get();


    /* DEVOLUCIONES */
    $devoluciones = DB::table('detalle_devoluciones as d')
        ->join('devoluciones as dv', 'dv.id_devolucion', '=', 'd.id_devolucion')
        ->join('activos as a', 'a.id_activo', '=', 'd.id_activo')
        ->join('responsables as r','r.id_responsable','=','dv.id_responsable')
        ->join('servicios as s','s.id_servicio','=','dv.id_servicio')
        ->join('estados as est','est.id_estado','=','a.id_estado')

        ->select(
            'a.codigo',
            'a.nombre',
            's.nombre as servicio',
            'r.nombre as responsable',
            'dv.fecha',
            DB::raw("'Devolución' as tipo"),
            'est.nombre as estado'
        )

        ->when($search, function($q) use ($search){
            $q->where(function($qq) use ($search){
                $qq->where('a.codigo','LIKE',"%$search%")
                   ->orWhere('a.nombre','LIKE',"%$search%");
            });
        })
        ->when($servicio, fn($q)=>$q->where('s.nombre',$servicio))
        ->when($estado, fn($q)=>$q->where('est.nombre',$estado))
        ->get();


    /* UNIFICAR MOVIMIENTOS */
    $movs = $movs->merge($entradas)->merge($traslados)->merge($devoluciones);

    if ($tipo) {
        $movs = $movs->where('tipo', $tipo)->values();
    }

    return response()->json([
        "inventario"  => $inventario,
        "movimientos" => $movs
    ]);
}


public function generar(Request $req)
{
    $from = $req->fromDate;
    $to   = $req->toDate;
    $type = $req->reportType;

    // Datos filtrados enviados desde el frontend
    $inventoryData = $req->inventoryData ?? [];
    $movementData  = $req->movementData ?? [];

    /* --------------------------------------------
        FILTRO DE FECHA REUTILIZABLE (cuando aplica)
    ---------------------------------------------*/
    $dateFilter = fn($q, $col='fecha') =>
        $q->when($from, fn($q)=>$q->whereDate($col,'>=',$from))
          ->when($to,   fn($q)=>$q->whereDate($col,'<=',$to));

    /* --------------------------------------------
        SWITCH PRINCIPAL — TODAS LAS OPCIONES
    ---------------------------------------------*/

    switch($type){

        /* ════════════════════════════════════════════
            1) RESUMEN RÁPIDO  (NO USA FILTROS, USA TODO)
     case 'kpi_overview':

    /* ============================================================
       1) TOTAL DE ACTIVOS
    ============================================================ */
    case 'kpi_overview':
    $totalActivos = DB::table('activos')->count();


    /* ============================================================
       2) ACTIVOS ASIGNADOS (sin devolución)
    ============================================================ */
    $asignados = DB::table('detalle_entregas as d')
        ->leftJoin('detalle_devoluciones as dv','dv.id_activo','=','d.id_activo')
        ->whereNull('dv.id_activo')
        ->count();


    /* ============================================================
       3) ACTIVOS NO ASIGNADOS
    ============================================================ */
    $noAsignados = $totalActivos - $asignados;


    /* ============================================================
       4) ACTIVOS DADOS DE BAJA
    ============================================================ */
    $bajas = DB::table('bajas')->count();


    /* ============================================================
       5) ACTIVOS POR ESTADO FÍSICO
    ============================================================ */
    $porEstado = DB::table('activos')
        ->join('estados','estados.id_estado','=','activos.id_estado')
        ->select('estados.nombre as estado', DB::raw("COUNT(*) as total"))
        ->groupBy('estados.id_estado')
        ->get();


    /* ============================================================
       6) ACTIVOS POR SERVICIO
    ============================================================ */
    $porServicio = DB::table('inventarios')
        ->join('servicios','servicios.id_servicio','=','inventarios.id_servicio')
        ->select('servicios.nombre as servicio', DB::raw("COUNT(*) as total"))
        ->groupBy('servicios.id_servicio')
        ->get();


    /* ============================================================
       7) ACTIVOS POR CATEGORÍA
    ============================================================ */
    $porCategoria = DB::table('activos')
        ->join('unidades','unidades.id_unidad','=','activos.id_unidad')
        ->select('unidades.nombre as categoria', DB::raw("COUNT(*) as total"))
        ->groupBy('unidades.id_unidad')
        ->get();


    /* ============================================================
       8) ÚLTIMOS 10 MOVIMIENTOS UNIDOS
          (ENTREGAS + TRASLADOS + DEVOLUCIONES)
    ============================================================ */
    $ultMovimientos = collect([]);

    // ENTREGAS FINALIZADAS
   // ENTREGAS FINALIZADAS
$entregas = DB::table('detalle_entregas as d')
    ->join('entregas as e','e.id_entrega','=','d.id_entrega')
    ->join('responsables as r','r.id_responsable','=','e.id_responsable')
    ->where('e.estado', 'finalizado')
    ->select(
        DB::raw("'ENTREGA' as tipo"),
        'd.id_activo',
        'e.fecha',
        DB::raw("r.nombre as responsable"),
        'e.usuario',
        'e.observacion'
    );

// DEVOLUCIONES FINALIZADAS
$devoluciones = DB::table('detalle_devoluciones as d')
    ->join('devoluciones as e','e.id_devolucion','=','d.id_devolucion')
    ->join('responsables as r','r.id_responsable','=','e.id_responsable')
    ->where('e.estado', 'finalizado')
    ->select(
        DB::raw("'DEVOLUCIÓN' as tipo"),
        'd.id_activo',
        'e.fecha',
        DB::raw("r.nombre as responsable"),
        'e.usuario',
        'e.observacion'
    );

// TRASLADOS FINALIZADOS
$traslados = DB::table('detalle_traslados as d')
    ->join('traslados as e','e.id_traslado','=','d.id_traslado')
    ->join('servicios as so','so.id_servicio','=','e.id_servicio_origen')
    ->join('servicios as sd','sd.id_servicio','=','e.id_servicio_destino')
    ->where('e.estado', 'finalizado')
    ->select(
        DB::raw("'TRASLADO' as tipo"),
        'd.id_activo',
        'e.fecha',
        DB::raw("CONCAT(so.nombre, ' → ', sd.nombre) as responsable"),
        'e.usuario',
        'e.observacion'
    );

// UNIÓN FINAL
$ultMovimientos = $entregas
    ->unionAll($devoluciones)
    ->unionAll($traslados)
    ->orderBy('fecha','DESC')
    ->limit(10)
    ->get();



    /* ============================================================
       9) TOTAL ENTREGAS
    ============================================================ */
    $totalEntregas = DB::table('entregas')
        ->where('estado','finalizado')
        ->count();


    /* ============================================================
       10) TOTAL DEVOLUCIONES
    ============================================================ */
    $totalDevoluciones = DB::table('devoluciones')
        ->where('estado','finalizado')
        ->count();


    /* ============================================================
       11) TOTAL SERVICIOS
    ============================================================ */
    $servicios = DB::table('servicios')->count();


    /* ============================================================
       12) TOTAL CATEGORÍAS
    ============================================================ */
    $totalCategorias = DB::table('unidades')->count();


    /* ============================================================
       13) ACTIVOS RECIENTES
    ============================================================ */
    $recientes = DB::table('activos')
        ->orderBy('fecha_registro','desc')
        ->limit(10)
        ->get();


    /* ============================================================
       RETURN FINAL
    ============================================================ */
    return response()->json([
        "title" => "Resumen rápido",
        "data"  => [
            "total_activos"         => $totalActivos,
            "activos_asignados"     => $asignados,
            "activos_no_asignados"  => $noAsignados,
            "activos_baja"          => $bajas,

            "por_estado"            => $porEstado,
            "por_servicio"          => $porServicio,
            "por_categoria"         => $porCategoria,

            "ultimos_movimientos"   => $ultMovimientos,

            "total_entregas"        => $totalEntregas,
            "total_devoluciones"    => $totalDevoluciones,

            "total_servicios"       => $servicios,
            "total_categorias"      => $totalCategorias,

            "activos_recientes"     => $recientes,
        ]
    ]);



        /* ════════════════════════════════════════════
            2) INVENTARIO DETALLADO (USA RESULTADOS FILTRADOS)
        ════════════════════════════════════════════ */
        case 'inventory_detail':

            return response()->json([
                "title" => "Inventario detallado",
                "data"  => $inventoryData     // filtrado desde el frontend
            ]);


        /* ════════════════════════════════════════════
            3) MOVIMIENTOS (USA RESULTADOS FILTRADOS)
        ════════════════════════════════════════════ */
        case 'movements_summary':

            return response()->json([
                "title" => "Movimientos",
                "data"  => $movementData
            ]);


        /* ════════════════════════════════════════════
            4) ACTIVOS POR SERVICIO (CONSULTA BD)
        ════════════════════════════════════════════ */
        case 'assets_by_service':

            $result = DB::table('detalle_inventarios')
                ->join('inventarios','inventarios.id_inventario','=','detalle_inventarios.id_inventario')
                ->join('servicios','servicios.id_servicio','=','inventarios.id_servicio')
                ->join('activos','activos.id_activo','=','detalle_inventarios.id_activo')
                ->select('servicios.nombre as servicio', DB::raw("COUNT(*) as total"))
                ->groupBy('servicios.id_servicio')
                ->orderBy('total','desc')
                ->get();

            return response()->json([
                "title" => "Activos por servicio",
                "data"  => $result
            ]);


        /* ════════════════════════════════════════════
            5) ACTIVOS POR CATEGORÍA
        ════════════════════════════════════════════ */
        case 'assets_by_category':

            $result = DB::table('activos')
                ->join('unidades','unidades.id_unidad','=','activos.id_unidad')
                ->select('unidades.nombre as categoria', DB::raw("COUNT(*) as total"))
                ->groupBy('unidades.id_unidad')
                ->orderBy('total','desc')
                ->get();

            return response()->json([
                "title" => "Activos por categoría",
                "data" => $result
            ]);


        /* ════════════════════════════════════════════
            6) ACTIVOS POR NOMBRE
        ════════════════════════════════════════════ */
        case 'assets_by_name':

            $result = DB::table('activos')
                ->select('nombre', DB::raw("COUNT(*) as total"))
                ->groupBy('nombre')
                ->orderBy('total','desc')
                ->get();

            return response()->json([
                "title" => "Activos por nombre",
                "data" => $result
            ]);


        /* ════════════════════════════════════════════
            7) ACTIVOS POR ADQUISICIÓN
        ════════════════════════════════════════════ */
        case 'assets_by_acquisition':

            $result = DB::table('activos')
                ->select('origen', DB::raw("COUNT(*) as total"))
                ->groupBy('origen')
                ->orderBy('total','desc')
                ->get();

            return response()->json([
                "title" => "Activos por adquisición",
                "data" => $result
            ]);


        /* ════════════════════════════════════════════
            8) LISTA DE SERVICIOS
        ════════════════════════════════════════════ */
        case 'list_services':

            $serv = DB::table('servicios')->select('nombre')->orderBy('nombre')->get();

            return response()->json([
                "title" => "Lista de servicios",
                "data" => $serv
            ]);


        /* ════════════════════════════════════════════
            9) ACTIVOS ASIGNADOS
        ════════════════════════════════════════════ */
        case 'assigned_assets':

            $asignados = DB::table('detalle_entregas as d')
                ->leftJoin('detalle_devoluciones as dv','dv.id_activo','=','d.id_activo')
                ->join('activos as a','a.id_activo','=','d.id_activo')
                ->join('entregas as e','e.id_entrega','=','d.id_entrega')
                ->join('responsables as r','r.id_responsable','=','e.id_responsable')
                ->join('servicios as s','s.id_servicio','=','e.id_servicio')
                ->whereNull('dv.id_activo')
                ->get();

            return response()->json([
                "title" => "Activos asignados",
                "data" => $asignados
            ]);


        /* ════════════════════════════════════════════
            10) ACTIVOS NO ASIGNADOS
        ════════════════════════════════════════════ */
        case 'unassigned_assets':

            $ids = DB::table('detalle_entregas')->pluck('id_activo')->toArray();

            $no = DB::table('activos')
                ->whereNotIn('id_activo',$ids)
                ->select('codigo','nombre')
                ->get();

            return response()->json([
                "title" => "Activos no asignados",
                "data" => $no
            ]);


        /* ════════════════════════════════════════════
            11) ACTIVOS DE BAJA
        ════════════════════════════════════════════ */
        case 'assets_low':

            $bajas = DB::table('bajas')
                ->join('activos','activos.id_activo','=','bajas.id_activo')
                ->join('responsables','responsables.id_responsable','=','bajas.id_responsable')
                ->get();

            return response()->json([
                "title" => "Activos de baja",
                "data" => $bajas
            ]);


        /* ════════════════════════════════════════════
            12) ACTIVOS POR ESTADO
        ════════════════════════════════════════════ */
        case 'assets_by_condition':

            $result = DB::table('activos')
                ->join('estados','estados.id_estado','=','activos.id_estado')
                ->select('estados.nombre as estado', DB::raw("COUNT(*) as total"))
                ->groupBy('estados.id_estado')
                ->get();

            return response()->json([
                "title" => "Activos por estado",
                "data" => $result
            ]);
    }

    return response()->json(["error"=>"Tipo inválido"]);
}


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
