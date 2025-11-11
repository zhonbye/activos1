<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Adquisicion;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\DetalleBaja;
use App\Models\DetalleDevolucion;
use App\Models\DetalleEntrega;
use App\Models\DetalleTraslado;
use App\Models\Docto;
use App\Models\Donacion;
use App\Models\Donante;
use App\Models\Estado;
use App\Models\Proveedor;
use App\Models\Responsable;
use App\Models\Ubicacion;
use App\Models\Unidad;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function historial() {
        return view('user.activos.historial'); // solo carga la vista y filtros
    }

    // public function filtrarHistorial(Request $request)
    // {
    //     $activos = Activo::with(['categoria', 'unidad', 'estado', 'adquisicion'])->get();

    //     $historial = collect();

    //     foreach ($activos as $activo) {
    //         // 🔹 PRIMERA FILA: registro inicial
    //         $historial->push([
    //             'fecha' => $activo->created_at->format('Y-m-d'),
    //             'codigo' => $activo->codigo,
    //             'nombre' => $activo->nombre,
    //             'tipo' => 'Registro',
    //             'origen' => '',
    //             'destino' => '',
    //             'responsable' => '',
    //             'observaciones' => 'Activo registrado en el sistema.',
    //             'estado_situacional' => $activo->estado_situacional,
    //         ]);

    //         // 🔹 ENTREGA
    //         $entregas = DB::table('detalle_entregas')
    //             ->join('entregas', 'detalle_entregas.id_entrega', '=', 'entregas.id_entrega')
    //             ->where('detalle_entregas.id_activo', $activo->id_activo)
    //             ->where('entregas.estado', 'finalizado')
    //             ->select('entregas.fecha', 'entregas.id_responsable', 'entregas.id_servicio', 'entregas.observaciones')
    //             ->get();

    //         foreach ($entregas as $e) {
    //             $servicio = DB::table('servicios')->where('id_servicio', $e->id_servicio)->value('nombre');
    //             $responsable = DB::table('responsables')->where('id_responsable', $e->id_responsable)->value('nombre');

    //             $historial->push([
    //                 'fecha' => $e->fecha,
    //                 'codigo' => $activo->codigo,
    //                 'nombre' => $activo->nombre,
    //                 'tipo' => 'Entrega',
    //                 'origen' => '',
    //                 'destino' => $servicio,
    //                 'responsable' => $responsable,
    //                 'observaciones' => $e->observaciones,
    //                 'estado_situacional' => $activo->estado_situacional,
    //             ]);
    //         }

    //         // 🔹 TRASLADOS
    //         $traslados = DB::table('detalle_traslados')
    //             ->join('traslados', 'detalle_traslados.id_traslado', '=', 'traslados.id_traslado')
    //             ->where('detalle_traslados.id_activo', $activo->id_activo)
    //             ->where('traslados.estado', 'finalizado')
    //             ->select('traslados.fecha', 'traslados.id_servicio_origen', 'traslados.id_servicio_destino', 'traslados.observaciones', 'traslados.id_usuario')
    //             ->get();

    //         foreach ($traslados as $t) {
    //             $origen = DB::table('servicios')->where('id_servicio', $t->id_servicio_origen)->value('nombre');
    //             $destino = DB::table('servicios')->where('id_servicio', $t->id_servicio_destino)->value('nombre');
    //             $responsable = DB::table('usuarios')->where('id_usuario', $t->id_usuario)->value('usuario');

    //             $historial->push([
    //                 'fecha' => $t->fecha,
    //                 'codigo' => $activo->codigo,
    //                 'nombre' => $activo->nombre,
    //                 'tipo' => 'Traslado',
    //                 'origen' => $origen,
    //                 'destino' => $destino,
    //                 'responsable' => $responsable,
    //                 'observaciones' => $t->observaciones,
    //                 'estado_situacional' => $activo->estado_situacional,
    //             ]);
    //         }

    //         // 🔹 DEVOLUCIONES
    //         $devoluciones = DB::table('detalle_devoluciones')
    //             ->join('devoluciones', 'detalle_devoluciones.id_devolucion', '=', 'devoluciones.id_devolucion')
    //             ->where('detalle_devoluciones.id_activo', $activo->id_activo)
    //             ->where('devoluciones.estado', 'finalizado')
    //             ->select('devoluciones.fecha', 'devoluciones.id_servicio', 'devoluciones.id_responsable', 'devoluciones.observaciones')
    //             ->get();

    //         foreach ($devoluciones as $d) {
    //             $origen = DB::table('servicios')->where('id_servicio', $d->id_servicio)->value('nombre');
    //             $responsable = DB::table('responsables')->where('id_responsable', $d->id_responsable)->value('nombre');

    //             $historial->push([
    //                 'fecha' => $d->fecha,
    //                 'codigo' => $activo->codigo,
    //                 'nombre' => $activo->nombre,
    //                 'tipo' => 'Devolución',
    //                 'origen' => $origen,
    //                 'destino' => 'Área de Activos Fijos',
    //                 'responsable' => $responsable,
    //                 'observaciones' => $d->observaciones,
    //                 'estado_situacional' => $activo->estado_situacional,
    //             ]);
    //         }

    //         // 🔹 BAJAS
    //         $bajas = DB::table('detalle_bajas')
    //             ->join('bajas', 'detalle_bajas.id_baja', '=', 'bajas.id_baja')
    //             ->where('detalle_bajas.id_activo', $activo->id_activo)
    //             ->where('bajas.estado', 'finalizado')
    //             ->select('bajas.fecha', 'bajas.id_servicio', 'bajas.observaciones')
    //             ->get();

    //         foreach ($bajas as $b) {
    //             $origen = DB::table('servicios')->where('id_servicio', $b->id_servicio)->value('nombre');

    //             $historial->push([
    //                 'fecha' => $b->fecha,
    //                 'codigo' => $activo->codigo,
    //                 'nombre' => $activo->nombre,
    //                 'tipo' => 'Baja',
    //                 'origen' => $origen,
    //                 'destino' => '-----',
    //                 'responsable' => '',
    //                 'observaciones' => $b->observaciones,
    //                 'estado_situacional' => $activo->estado_situacional,
    //             ]);
    //         }

    //         // 🔹 INVENTARIOS
    //         $inventarios = DB::table('detalle_inventarios')
    //             ->join('inventarios', 'detalle_inventarios.id_inventario', '=', 'inventarios.id_inventario')
    //             ->where('detalle_inventarios.id_activo', $activo->id_activo)
    //             ->where('inventarios.estado', 'finalizado')
    //             ->select('inventarios.fecha', 'inventarios.id_servicio', 'inventarios.observaciones')
    //             ->get();

    //         foreach ($inventarios as $i) {
    //             $servicio = DB::table('servicios')->where('id_servicio', $i->id_servicio)->value('nombre');

    //             $historial->push([
    //                 'fecha' => $i->fecha,
    //                 'codigo' => $activo->codigo,
    //                 'nombre' => $activo->nombre,
    //                 'tipo' => 'Inventario',
    //                 'origen' => $servicio,
    //                 'destino' => 'Inventario',
    //                 'responsable' => '',
    //                 'observaciones' => $i->observaciones,
    //                 'estado_situacional' => $activo->estado_situacional,
    //             ]);
    //         }
    //     }

    //     // Ordenar por fecha (más reciente al final)
    //     $historial = $historial->sortBy('fecha')->values();

    //     return view('user.activos.parcial_historial', compact('historial'));
    // }

    // public function filtrarHistorial(Request $request)
    // {
    //     $activoFiltro = $request->activo;
    //     $tipoFiltro = $request->tipo;
    //     $servicioOrigen = $request->servicio_origen;
    //     $servicioDestino = $request->servicio_destino;
    //     $fechaInicio = $request->fecha_inicio;
    //     $fechaFin = $request->fecha_fin;

    //     $historial = collect();

    //     // 🔹 1. REGISTROS DE ACTIVOS
    //     $activos = DB::table('activos')
    //         ->when($activoFiltro, function ($q) use ($activoFiltro) {
    //             $q->where(function ($sub) use ($activoFiltro) {
    //                 $sub->where('nombre', 'like', "%$activoFiltro%")
    //                     ->orWhere('codigo', 'like', "%$activoFiltro%");
    //             });
    //         })
    //         ->select('codigo', 'nombre', 'estado_situacional', 'created_at')
    //         ->get();

    //     foreach ($activos as $a) {
    //         // ➕ Se inserta al inicio
    //         $historial->prepend([
    //             'fecha' => $a->created_at,
    //             'codigo' => $a->codigo,
    //             'nombre' => $a->nombre,
    //             'tipo' => 'Registro',
    //             'origen' => '',
    //             'destino' => '',
    //             'responsable' => '',
    //             'observaciones' => 'Activo registrado en el sistema.',
    //             'estado_situacional' => $a->estado_situacional,
    //         ]);
    //     }

    //     // 🔹 2. ENTREGAS
    //     $entregas = DB::table('detalle_entregas')
    //         ->join('entregas', 'detalle_entregas.id_entrega', '=', 'entregas.id_entrega')
    //         ->join('activos', 'detalle_entregas.id_activo', '=', 'activos.id_activo')
    //         ->leftJoin('servicios', 'entregas.id_servicio', '=', 'servicios.id_servicio')
    //         ->leftJoin('usuarios', 'entregas.id_usuario', '=', 'usuarios.id_usuario')
    //         ->where('entregas.estado', 'finalizado')
    //         ->when($activoFiltro, function ($q) use ($activoFiltro) {
    //             $q->where(function ($sub) use ($activoFiltro) {
    //                 $sub->where('activos.nombre', 'like', "%$activoFiltro%")
    //                     ->orWhere('activos.codigo', 'like', "%$activoFiltro%");
    //             });
    //         })
    //         ->when($fechaInicio, fn($q) => $q->where('entregas.fecha', '>=', $fechaInicio))
    //         ->when($fechaFin, fn($q) => $q->where('entregas.fecha', '<=', $fechaFin))
    //         ->selectRaw("
    //             entregas.fecha,
    //             activos.codigo,
    //             activos.nombre,
    //             'Entrega' as tipo,
    //             '' as origen,
    //             servicios.nombre as destino,
    //             COALESCE(usuarios.usuario, '') as responsable,
    //             entregas.observaciones,
    //             activos.estado_situacional
    //         ")
    //         ->get();

    //     foreach ($entregas as $e) {
    //         $historial->prepend($e); // se pone al inicio
    //     }

    //     // 🔹 3. TRASLADOS
    //     $traslados = DB::table('detalle_traslados')
    //         ->join('traslados', 'detalle_traslados.id_traslado', '=', 'traslados.id_traslado')
    //         ->join('activos', 'detalle_traslados.id_activo', '=', 'activos.id_activo')
    //         ->leftJoin('servicios as s_origen', 'traslados.id_servicio_origen', '=', 's_origen.id_servicio')
    //         ->leftJoin('servicios as s_destino', 'traslados.id_servicio_destino', '=', 's_destino.id_servicio')
    //         ->leftJoin('usuarios', 'traslados.id_usuario', '=', 'usuarios.id_usuario')
    //         ->where('traslados.estado', 'finalizado')
    //         ->when($activoFiltro, function ($q) use ($activoFiltro) {
    //             $q->where(function ($sub) use ($activoFiltro) {
    //                 $sub->where('activos.nombre', 'like', "%$activoFiltro%")
    //                     ->orWhere('activos.codigo', 'like', "%$activoFiltro%");
    //             });
    //         })
    //         ->when($fechaInicio, fn($q) => $q->where('traslados.fecha', '>=', $fechaInicio))
    //         ->when($fechaFin, fn($q) => $q->where('traslados.fecha', '<=', $fechaFin))
    //         ->selectRaw("
    //             traslados.fecha,
    //             activos.codigo,
    //             activos.nombre,
    //             'Traslado' as tipo,
    //             s_origen.nombre as origen,
    //             s_destino.nombre as destino,
    //             COALESCE(usuarios.usuario, '') as responsable,
    //             traslados.observaciones,
    //             activos.estado_situacional
    //         ")
    //         ->get();

    //     foreach ($traslados as $t) {
    //         $historial->prepend($t);
    //     }

    //     // 🔹 4. DEVOLUCIONES
    //     $devoluciones = DB::table('detalle_devoluciones')
    //         ->join('devoluciones', 'detalle_devoluciones.id_devolucion', '=', 'devoluciones.id_devolucion')
    //         ->join('activos', 'detalle_devoluciones.id_activo', '=', 'activos.id_activo')
    //         ->leftJoin('servicios', 'devoluciones.id_servicio', '=', 'servicios.id_servicio')
    //         ->leftJoin('usuarios', 'devoluciones.id_usuario', '=', 'usuarios.id_usuario')
    //         ->where('devoluciones.estado', 'finalizado')
    //         ->selectRaw("
    //             devoluciones.fecha,
    //             activos.codigo,
    //             activos.nombre,
    //             'Devolución' as tipo,
    //             servicios.nombre as origen,
    //             'Área de Activos Fijos' as destino,
    //             COALESCE(usuarios.usuario, '') as responsable,
    //             devoluciones.observaciones,
    //             activos.estado_situacional
    //         ")
    //         ->get();

    //     foreach ($devoluciones as $d) {
    //         $historial->prepend($d);
    //     }

    //     // 🔹 5. BAJAS
    //     $bajas = DB::table('detalle_bajas')
    //         ->join('bajas', 'detalle_bajas.id_baja', '=', 'bajas.id_baja')
    //         ->join('activos', 'detalle_bajas.id_activo', '=', 'activos.id_activo')
    //         ->leftJoin('servicios', 'bajas.id_servicio', '=', 'servicios.id_servicio')
    //         ->leftJoin('usuarios', 'bajas.id_usuario', '=', 'usuarios.id_usuario')
    //         ->where('bajas.estado', 'finalizado')
    //         ->selectRaw("
    //             bajas.fecha,
    //             activos.codigo,
    //             activos.nombre,
    //             'Baja' as tipo,
    //             servicios.nombre as origen,
    //             '' as destino,
    //             COALESCE(usuarios.usuario, '') as responsable,
    //             bajas.observaciones,
    //             activos.estado_situacional
    //         ")
    //         ->get();

    //     foreach ($bajas as $b) {
    //         $historial->prepend($b);
    //     }

    //     // Retorno directo sin ordenar, ya está al revés (últimos arriba)
    //     return view('user.activos.parcial_historial', compact('historial'));
    // }
    public function filtrarHistorial(Request $request)
    {
        $activoFiltro = $request->activo;
        $tipoFiltro = $request->tipo;
        $servicioOrigen = $request->servicio_origen;
        $servicioDestino = $request->servicio_destino;
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;

        $historial = collect();

        // 🔹 1. REGISTROS DE ACTIVOS
        if (!$tipoFiltro || $tipoFiltro === 'Registro') {
            $activos = DB::table('activos')
                ->when($activoFiltro, function ($q) use ($activoFiltro) {
                    $q->where(function ($sub) use ($activoFiltro) {
                        $sub->where('nombre', 'like', "%$activoFiltro%")
                            ->orWhere('codigo', 'like', "%$activoFiltro%");
                    });
                })
                ->select('codigo', 'nombre', 'created_at')
                ->get();

            foreach ($activos as $a) {
                $historial->prepend([
                    'fecha' => $a->created_at,
                    'codigo' => $a->codigo,
                    'nombre' => $a->nombre,
                    'tipo' => 'Registro',
                    'origen' => '',
                    'destino' => '',
                    'responsable' => '',
                    'observaciones' => 'Activo registrado en el sistema.',
                    'estado_situacional' => 'inactivo',
                ]);
            }
        }

        // 🔹 2. ENTREGAS
        if (!$tipoFiltro || $tipoFiltro === 'Entrega') {
            $entregas = DB::table('detalle_entregas')
                ->join('entregas', 'detalle_entregas.id_entrega', '=', 'entregas.id_entrega')
                ->join('activos', 'detalle_entregas.id_activo', '=', 'activos.id_activo')
                ->leftJoin('servicios', 'entregas.id_servicio', '=', 'servicios.id_servicio')
                ->leftJoin('usuarios', 'entregas.id_usuario', '=', 'usuarios.id_usuario')
                ->where('entregas.estado', 'finalizado')
                ->when($activoFiltro, function ($q) use ($activoFiltro) {
                    $q->where(function ($sub) use ($activoFiltro) {
                        $sub->where('activos.nombre', 'like', "%$activoFiltro%")
                            ->orWhere('activos.codigo', 'like', "%$activoFiltro%");
                    });
                })
                ->when($servicioDestino, fn($q) => $q->where('servicios.id_servicio', $servicioDestino))
                ->when($fechaInicio, fn($q) => $q->where('entregas.fecha', '>=', $fechaInicio))
                ->when($fechaFin, fn($q) => $q->where('entregas.fecha', '<=', $fechaFin))
                ->selectRaw("
                    entregas.fecha,
                    activos.codigo,
                    activos.nombre,
                    'Entrega' as tipo,
                    '' as origen,
                    servicios.nombre as destino,
                    COALESCE(usuarios.usuario, '') as responsable,
                    entregas.observaciones,
                    'activo' as estado_situacional
                ")
                ->get();

            foreach ($entregas as $e) {
                $historial->prepend($e);
            }
        }





        // 🔹 3. TRASLADOSkkkkkkkkkkkkkkkkkkk
        if (!$tipoFiltro || $tipoFiltro === 'Traslado') {
            $traslados = DB::table('detalle_traslados')
                ->join('traslados', 'detalle_traslados.id_traslado', '=', 'traslados.id_traslado')
                ->join('activos', 'detalle_traslados.id_activo', '=', 'activos.id_activo')
                ->leftJoin('servicios as s_origen', 'traslados.id_servicio_origen', '=', 's_origen.id_servicio')
                ->leftJoin('servicios as s_destino', 'traslados.id_servicio_destino', '=', 's_destino.id_servicio')
                ->leftJoin('usuarios', 'traslados.id_usuario', '=', 'usuarios.id_usuario')
                ->where('traslados.estado', 'finalizado')
                ->when($activoFiltro, function ($q) use ($activoFiltro) {
                    $q->where(function ($sub) use ($activoFiltro) {
                        $sub->where('activos.nombre', 'like', "%$activoFiltro%")
                            ->orWhere('activos.codigo', 'like', "%$activoFiltro%");
                    });
                })
                ->when($servicioOrigen, fn($q) => $q->where('s_origen.id_servicio', $servicioOrigen))
                ->when($servicioDestino, fn($q) => $q->where('s_destino.id_servicio', $servicioDestino))
                ->when($fechaInicio, fn($q) => $q->where('traslados.fecha', '>=', $fechaInicio))
                ->when($fechaFin, fn($q) => $q->where('traslados.fecha', '<=', $fechaFin))
                ->selectRaw("
                    traslados.fecha,
                    activos.codigo,
                    activos.nombre,
                    'Traslado' as tipo,
                    s_origen.nombre as origen,
                    s_destino.nombre as destino,
                    COALESCE(usuarios.usuario, '') as responsable,
                    traslados.observaciones,
                    'activo' as estado_situacional
                ")
                ->get();

            foreach ($traslados as $t) {
                $historial->prepend($t);
            }
        }

        // 🔹 4. DEVOLUCIONES
        if (!$tipoFiltro || $tipoFiltro === 'Devolución') {
            $devoluciones = DB::table('detalle_devoluciones')
                ->join('devoluciones', 'detalle_devoluciones.id_devolucion', '=', 'devoluciones.id_devolucion')
                ->join('activos', 'detalle_devoluciones.id_activo', '=', 'activos.id_activo')
                ->leftJoin('servicios', 'devoluciones.id_servicio', '=', 'servicios.id_servicio')
                ->leftJoin('usuarios', 'devoluciones.id_usuario', '=', 'usuarios.id_usuario')
                ->where('devoluciones.estado', 'finalizado')
                ->when($activoFiltro, function ($q) use ($activoFiltro) {
                    $q->where(function ($sub) use ($activoFiltro) {
                        $sub->where('activos.nombre', 'like', "%$activoFiltro%")
                            ->orWhere('activos.codigo', 'like', "%$activoFiltro%");
                    });
                })
                ->when($servicioOrigen, fn($q) => $q->where('servicios.id_servicio', $servicioOrigen))
                ->when($fechaInicio, fn($q) => $q->where('devoluciones.fecha', '>=', $fechaInicio))
                ->when($fechaFin, fn($q) => $q->where('devoluciones.fecha', '<=', $fechaFin))
                ->selectRaw("
                    devoluciones.fecha,
                    activos.codigo,
                    activos.nombre,
                    'Devolución' as tipo,
                    servicios.nombre as origen,
                    'Área de Activos Fijos' as destino,
                    COALESCE(usuarios.usuario, '') as responsable,
                    devoluciones.observaciones,
                    'inactivo' as estado_situacional
                ")
                ->get();

            foreach ($devoluciones as $d) {
                $historial->prepend($d);
            }
        }

        // 🔹 5. BAJAS
        if (!$tipoFiltro || $tipoFiltro === 'Baja') {
            $bajas = DB::table('detalle_bajas')
                ->join('bajas', 'detalle_bajas.id_baja', '=', 'bajas.id_baja')
                ->join('activos', 'detalle_bajas.id_activo', '=', 'activos.id_activo')
                ->leftJoin('servicios', 'bajas.id_servicio', '=', 'servicios.id_servicio')
                ->leftJoin('usuarios', 'bajas.id_usuario', '=', 'usuarios.id_usuario')
                ->where('bajas.estado', 'finalizado')
                ->when($activoFiltro, function ($q) use ($activoFiltro) {
                    $q->where(function ($sub) use ($activoFiltro) {
                        $sub->where('activos.nombre', 'like', "%$activoFiltro%")
                            ->orWhere('activos.codigo', 'like', "%$activoFiltro%");
                    });
                })
                ->when($servicioOrigen, fn($q) => $q->where('servicios.id_servicio', $servicioOrigen))
                ->when($fechaInicio, fn($q) => $q->where('bajas.fecha', '>=', $fechaInicio))
                ->when($fechaFin, fn($q) => $q->where('bajas.fecha', '<=', $fechaFin))
                ->selectRaw("
                    bajas.fecha,
                    activos.codigo,
                    activos.nombre,
                    'Baja' as tipo,
                    servicios.nombre as origen,
                    '' as destino,
                    COALESCE(usuarios.usuario, '') as responsable,
                    bajas.observaciones,
                    'de baja' as estado_situacional
                ")
                ->get();

            foreach ($bajas as $b) {
                $historial->prepend($b);
            }
        }

        return view('user.activos.parcial_historial', compact('historial'));
    }
























    public function update(Request $request, $id)
{
    // Buscar activo, incluyendo su adquisición y relaciones
    $activo = Activo::with(['adquisicion.compra', 'adquisicion.donacion'])->findOrFail($id);

    // Reglas de validación
    $rules = [
        'codigo' => 'required|string|max:50|unique:activos,codigo,' . $activo->id_activo . ',id_activo',
        'nombre' => 'required|string|max:255',
        'detalle' => 'nullable|string|max:500',
        'id_categoria' => 'required|exists:categorias,id_categoria',
        'id_unidad' => 'required|exists:unidades,id_unidad',
        'id_estado' => 'required|exists:estados,id_estado',
        'fecha' => [
        'nullable',
        'date',
        'after_or_equal:2017-01-01',
        'before_or_equal:' . date('Y-m-d'),
    ],
        'comentarios' => 'nullable|string|max:100',
        'sin_datos' => 'nullable|boolean',
        'tipo_adquisicion' => 'nullable|string|in:compra,donacion,otro',
    ];

    if (!$request->boolean('sin_datos') && $request->tipo_adquisicion === 'compra') {
        $rules = array_merge($rules, [
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'precio_compra' => 'required|numeric|min:0',
        ]);
    }

    if (!$request->boolean('sin_datos') && $request->tipo_adquisicion === 'donacion') {
        $rules = array_merge($rules, [
            'id_donante' => 'required|exists:donantes,id_donante',
            'motivo' => 'required|string|max:255',
            'precio_donacion' => 'required|numeric|min:0',
        ]);
    }

    // Mensajes personalizados
    $messages = [
        'codigo.required' => 'El código es obligatorio.',
        'codigo.unique' => 'El código ya está en uso.',
        'nombre.required' => 'El nombre es obligatorio.',
        'id_categoria.required' => 'Debe seleccionar una categoría.',
        'id_categoria.exists' => 'La categoría seleccionada no existe.',
        'id_unidad.required' => 'Debe seleccionar una unidad de medida.',
        'id_unidad.exists' => 'La unidad de medida seleccionada no existe.',
        'id_estado.required' => 'Debe seleccionar un estado.',
        'id_estado.exists' => 'El estado seleccionado no existe.',
        'fecha.date' => 'El valor ingresado no es una fecha válida.',
    'fecha.after_or_equal' => 'La fecha no puede ser anterior al 01/01/2017.',
    'fecha.before_or_equal' => 'La fecha no puede ser futura.',
        'precio_compra.required' => 'El precio de compra es obligatorio.',
        'precio_compra.numeric' => 'El precio de compra debe ser un número válido.',
        'precio_compra.min' => 'El precio de compra debe ser mínimo 0.',
        'id_proveedor.required' => 'Debe seleccionar un proveedor.',
        'id_proveedor.exists' => 'El proveedor seleccionado no existe.',
        'id_donante.required' => 'El donante es obligatorio.',
        'id_donante.exists' => 'El donante seleccionado no existe.',
        'motivo.required' => 'El motivo es obligatorio.',
        'motivo.string' => 'El motivo debe ser texto.',
        'precio_donacion.required' => 'El precio estimado es obligatorio.',
        'precio_donacion.numeric' => 'El precio estimado debe ser un número válido.',
        'precio_donacion.min' => 'El precio estimado debe ser mínimo 0.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
            'message' => 'Errores de validación en los campos.'
        ], 422);
    }
// dd($request->id_unidad);
    DB::beginTransaction();
    try {
        // Actualizar datos del activo
        $activo->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'detalle' => $request->detalle,
            'id_categoria' => $request->id_categoria,
            'id_unidad' => $request->id_unidad,
            'id_estado' => $request->id_estado,
        ]);

        // Actualizar o crear adquisición
        if ($request->tipo_adquisicion === 'compra' || $request->tipo_adquisicion === 'donacion') {
            $adquisicion = $activo->adquisicion;
            if (!$adquisicion) {
                $adquisicion = new Adquisicion();
                $adquisicion->id_adquisicion = null; // Laravel auto increment
                $adquisicion->activo_id = $activo->id_activo;
            }

            $adquisicion->tipo = $request->tipo_adquisicion;
            $adquisicion->fecha = $request->fecha;
            $adquisicion->comentarios = $request->comentarios;
            $adquisicion->save();

            // Actualizar detalles según tipo
            if ($request->tipo_adquisicion === 'compra') {
                // Eliminar donacion si existía
                if ($adquisicion->donacion) $adquisicion->donacion()->delete();

                $compra = $adquisicion->compra ?? new Compra();
                $compra->id_adquisicion = $adquisicion->id_adquisicion;
                $compra->id_proveedor = $request->id_proveedor;
                $compra->precio = $request->precio_compra;
                $compra->save();
            }

            if ($request->tipo_adquisicion === 'donacion') {
                // Eliminar compra si existía
                if ($adquisicion->compra) $adquisicion->compra()->delete();

                $donacion = $adquisicion->donacion ?? new Donacion();
                $donacion->id_adquisicion = $adquisicion->id_adquisicion;
                $donacion->id_donante = $request->id_donante;
                $donacion->motivo = $request->motivo;
                $donacion->precio = $request->precio_donacion;
                $donacion->save();
            }
        } else {
            // Tipo "otro", eliminar compra o donacion si existían
            if ($activo->adquisicion) {
                if ($activo->adquisicion->compra) $activo->adquisicion->compra()->delete();
                if ($activo->adquisicion->donacion) $activo->adquisicion->donacion()->delete();
                // Mantener solo la adquisición básica
                $activo->adquisicion->tipo = 'otro';
                $activo->adquisicion->fecha = $request->fecha;
                $activo->adquisicion->comentarios = $request->comentarios;
                $activo->adquisicion->save();
            }
        }

        DB::commit();

        return response()->json([
        'success' => true,
        'message' => 'Activo actualizado correctamente.',
        'data' => [
            'id_activo' => $activo->id_activo,
            'codigo' => $activo->codigo,
            'nombre' => $activo->nombre,
            'detalle' => $activo->detalle,
            'categoria' => $activo->categoria->nombre ?? 'N/A',
            'unidad' => $activo->unidad->nombre ?? 'N/A',
            'estado' => $activo->estado->nombre ?? 'N/A',
            'situacion' => $activo->estado_situacional ?? 'N/A',
            'fecha' => $activo->created_at->format('d/m/Y'),
        ],
    ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar el activo: ' . $e->getMessage(),
        ], 500);
    }
}

   public function edit($id)
{
    // Traer activo usando scopeActivo (ignora eliminados)
    $activo = Activo::activos()
        ->with([
            'categoria',
            'unidad',
            'estado',
            'adquisicion.compra.proveedor',
            'adquisicion.donacion.donante'
        ])
        ->findOrFail($id);

    // Traer datos para selects
    $categorias = Categoria::all();
    $unidades = Unidad::all();
    $estados = Estado::all();

    return view('user.activos.parcial_editar', compact('activo', 'categorias', 'unidades', 'estados'));
}


    public function index()
    {
        $request = new \Illuminate\Http\Request();

    // Llamar a la función sin código base
    $resultado = $this->obtenerSiguienteCodigo($request);

    // $resultado es un JsonResponse, puedes hacer:
    $json = $resultado->getData();
    $siguienteCodigo = $json->siguiente_codigo;//
        $activos = Activo::activos()->with(['unidad','estado','categoria'])->paginate(2);
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        // sleep(2);
        $estados = Estado::all();
            // $categorias = Categoria::all();
            // $unidadesmed = Unidad::all();
            $proveedores = Proveedor::all();  // o el query que uses
            $donantes = Donante::all();

        return view('user.activos.listar', compact( 'siguienteCodigo','activos','categorias','unidades','estados','proveedores','donantes'));
    }


public function detalle($id)
{
    $activo = Activo::activos()->with([
        'categoria',
        'unidad',
        'estado',
        'adquisicion.compra.proveedor', // compras
        'adquisicion.donacion.donante'  // donaciones
    ])->findOrFail($id);
//  dd($activo->adquisicion, $activo->adquisicion->compra, $activo->adquisicion->donacion);
// $activo = Activo::with([
//     'adquisicion.compra',
//     'adquisicion.donacion'
// ])->findOrFail($id);

// dd($activo->adquisicion->compra, $activo->adquisicion->donacion);


    return view('user.activos.parcial_detalle', compact('activo'))->render();
}

public function filtrar(Request $request)
{
    $query = Activo::activos()->with(['unidad', 'estado', 'categoria']);

    // Filtros existentes
    if ($request->filled('codigo')) {
        $query->where('codigo','like', "%{$request->codigo}%");
    }
    if ($request->filled('nombre')) {
        $query->where('nombre', 'like', "%{$request->nombre}%");
    }
    if ($request->filled('detalle')) {
        $query->where('detalle', 'like', "%{$request->detalle}%");
    }
    if ($request->filled('categoria') && $request->categoria != 'all') {
        $query->where('id_categoria', $request->categoria);
    }
    if ($request->filled('unidad') && $request->unidad != 'all') {
        $query->where('id_unidad', $request->unidad);
    }
    if ($request->filled('estado') && $request->estado != 'all') {
        $query->where('id_estado', $request->estado);
    }
    if ($request->filled('estado_situacional') && $request->estado_situacional != 'all') {
        $query->where('estado_situacional', $request->estado_situacional);
    }

    // Fecha de creación (rango)
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $fechaInicio = $request->fecha_inicio . ' 00:00:00';
        $fechaFin    = $request->fecha_fin . ' 23:59:59';
        $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    // Ordenamiento dinámico
    $ordenarPor = $request->input('ordenar_por', 'created_at'); // default
    $direccion  = $request->input('direccion', 'desc');         // default
    $query->orderBy($ordenarPor, $direccion);

    // Paginación
    $activos = $query->paginate(10)->withQueryString();

    return view('user.activos.parcial', compact('activos'))->render();
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           $request = new \Illuminate\Http\Request();

    // Llamar a la función sin código base
    $resultado = $this->obtenerSiguienteCodigo($request);

    // $resultado es un JsonResponse, puedes hacer:
    $json = $resultado->getData();
    $siguienteCodigo = $json->siguiente_codigo;//

// dd($siguienteCodigo);
        $estados = Estado::all();
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $proveedores = Proveedor::all();  // o el query que uses
        $donantes = Donante::all();

        return view('user.activos.registrar', compact('siguienteCodigo','estados', 'categorias', 'unidades', 'proveedores', 'donantes'));
    }


    public function obtenerSiguienteCodigo(Request $request)
{
    $codigoBase = $request->input('codigo_base');

    // Si no se pasa código base, buscar el último código activo no eliminado
    if (!$codigoBase) {
        $ultimoCodigo = Activo::where('estado_situacional', '!=', 'eliminado')
            ->orderByDesc('id_activo')
            ->value('codigo');

        if (!$ultimoCodigo) {
            // Si no hay ningún activo, iniciamos desde AMD-001
            $prefijo = 'AMD-';
            $longitudNumero = 3;
            $siguienteNumero = 1;
            $siguienteCodigo = $prefijo . str_pad($siguienteNumero, $longitudNumero, '0', STR_PAD_LEFT);

            return response()->json([
                'success' => true,
                'siguiente_codigo' => $siguienteCodigo
            ]);
        }

        // ✅ Aquí asignamos correctamente el último código encontrado
        $codigoBase = $ultimoCodigo;
    }

    // Separar prefijo (letras y guiones) y número al final
    if (!preg_match('/^(.*?)(\d+)$/', $codigoBase, $matches)) {
        // No tiene número al final → comenzamos desde 1
        $prefijo = $codigoBase;
        $numero = 1;
        $longitudNumero = 3;
    } else {
        $prefijo = $matches[1];
        $numero = intval($matches[2]);
        $longitudNumero = strlen($matches[2]);
    }

    // Buscar todos los códigos con el mismo prefijo (activos y no eliminados)
    $codigos = Activo::where('codigo', 'like', $prefijo . '%')
        ->where('estado_situacional', '!=', 'eliminado')
        ->pluck('codigo')
        ->toArray();

    // Extraer los números existentes de esos códigos
    $numerosExistentes = [];
    foreach ($codigos as $codigo) {
        if (preg_match('/^' . preg_quote($prefijo, '/') . '(\d+)$/', $codigo, $m)) {
            $numerosExistentes[] = intval($m[1]);
        }
    }

    // Si hay números, buscar el siguiente al mayor
    if (!empty($numerosExistentes)) {
        $siguienteNumero = max($numerosExistentes) + 1;
    } else {
        $siguienteNumero = 1;
    }

    // Formatear con ceros a la izquierda
    $formatoNumero = str_pad($siguienteNumero, $longitudNumero, '0', STR_PAD_LEFT);
    $siguienteCodigo = $prefijo . $formatoNumero;

    return response()->json([
        'success' => true,
        'siguiente_codigo' => $siguienteCodigo
    ]);
}

    public function buscar(Request $request)
    {
        $codigo = $request->input('codigo');

        if (!$codigo) {
            return response()->json(['error' => 'Debe proporcionar un código o nombre.'], 422);
        }

        $activo = Activo::with(['unidad', 'estado'])
            ->where('estado_situacional', 'activo')
            ->whereRaw('LOWER(codigo) = ?', [$codigo    ])
            ->first();
        if (!$activo) {
            return response()->json(['error' => 'No se encontró activo con ese código o nombre.'], 404);
        }

        // Construimos el objeto con IDs y nombres
        $data = [
            'id_activo' => $activo->id_activo,
            'codigo' => $activo->codigo,
            'nombre' => $activo->nombre,
            'detalle' => $activo->detalle,
            'id_unidad' => $activo->id_unidad,
            'unidad' => $activo->unidad->nombre,   // nombre de la unidad
            'id_estado' => $activo->id_estado,
            'estado' => $activo->estado->nombre,   // nombre del estado
            'created_at' => $activo->created_at,
            'updated_at' => $activo->updated_at,
        ];

        return response()->json(['activo' => $data]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'codigo' => 'required|string|max:50',
            'nombre' => 'required|string|max:255',
            'detalle' => 'nullable|string|max:500',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_unidad' => 'required|exists:unidades,id_unidad',
            'id_estado' => 'required|exists:estados,id_estado',
           'fecha' => [
    'required',
    'date',
    'after_or_equal:2017-01-01', // no menor que 2017
    'before_or_equal:' . date('Y-m-d'), // no futura
],

            'comentarios' => 'nullable|string|max:500',
            'sin_datos' => 'nullable|boolean',
            'tipo_adquisicion' => 'nullable|string|in:compra,donacion',
        ];

        // Verifica si sin_datos no está marcado y tipo_adquisicion es 'compra'
        if (!$request->boolean('sin_datos') && $request->tipo_adquisicion === 'compra') {
            $rules = array_merge($rules, [
                'id_proveedor' => 'required|exists:proveedores,id_proveedor',
                'precio_compra' => 'required|numeric|min:0',
            ]);
        }

        // Verifica si sin_datos no está marcado y tipo_adquisicion es 'donacion'
        if (!$request->boolean('sin_datos') && $request->tipo_adquisicion === 'donacion') {
            $rules = array_merge($rules, [
                'id_donante' => 'required|exists:donantes,id_donante',
                'motivo' => 'required|string|max:255',
                'precio_donacion' => 'required|numeric|min:0',
            ]);
        }

        // Mensajes de validación personalizados
        $messages = [
            'codigo.required' => 'El código es obligatorio.',
            // 'codigo.unique' => 'El código ya está en uso.',
            'nombre.required' => 'El nombre es obligatorio.',
            'id_categoria.required' => 'Debe seleccionar una categoría.',
            'id_categoria.exists' => 'La categoría seleccionada no existe.',
            'id_unidad.required' => 'Debe seleccionar una unidad de medida.',
            'id_unidad.exists' => 'La unidad de medida seleccionada no existe.',
            'id_estado.required' => 'Debe seleccionar un estado.',
            'id_estado.exists' => 'El estado seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
           'fecha.date' => 'El valor ingresado no es una fecha válida.',
    'fecha.after_or_equal' => 'La fecha no puede ser anterior al 01/01/2017.',
    'fecha.before_or_equal' => 'La fecha no puede ser futura.',
            'precio_compra.required' => 'El precio de compra es obligatorio.',
            'precio_compra.numeric' => 'El precio de compra debe ser un número válido.',
            'precio_compra.min' => 'El precio de compra debe ser mínimo 0.',
            'id_proveedor.required' => 'Debe seleccionar un proveedor.',
            'id_proveedor.exists' => 'El proveedor seleccionado no existe.',
            'id_donante.required' => 'Debe seleccionar un donante.',
            'id_donante.exists' => 'El donante seleccionado no existe.',
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.string' => 'El motivo debe ser texto.',
            'precio_donacion.required' => 'El precio estimado es obligatorio.',
            'precio_donacion.numeric' => 'El precio estimado debe ser un número válido.',
            'precio_donacion.min' => 'El precio estimado debe ser mínimo 0.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        // dd($request->all());


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Errores de validación en los campos.'
            ], 422);
        }
       // ✅ Verifica duplicados solo en activos con estado "activo"
if (Activo::Activos()->where('codigo', $request->codigo)->exists()) {
    return response()->json([
        'success' => false,
        'message' => 'El código ya está en uso por un activo con estado activo.'
    ], 422);
}

        DB::beginTransaction();

        try {
            $validated = $validator->validated();

            $sinDatos = $request->boolean('sin_datos');
            $tipoAdquisicion = $sinDatos ? 'otro' : ($validated['tipo_adquisicion'] ?? 'otro');

            // Guardar adquisición
            $adquisicion = new Adquisicion();
            $adquisicion->fecha = $validated['fecha'] ?? null;
            $adquisicion->comentarios = $validated['comentarios'] ?? null;
            $adquisicion->tipo = $tipoAdquisicion;
            $adquisicion->save();

            // Guardar activo con la adquisición recién creada
            $activo = new Activo();
            $activo->codigo = $validated['codigo'];
            $activo->nombre = $validated['nombre'];
            $activo->detalle = $validated['detalle'] ?? null;
            $activo->id_categoria = $validated['id_categoria'];
            $activo->id_unidad = $validated['id_unidad'];
            $activo->id_estado = $validated['id_estado'];
            $activo->estado_situacional = 'inactivo'; // o 'libre', según corresponda

            $activo->id_adquisicion = $adquisicion->id_adquisicion; // importante, asignar el ID
            $activo->save();

            // Guardar compra o donación si aplica
            if (!$sinDatos) {
                if ($tipoAdquisicion === 'compra') {
                    Compra::create([
                        'id_adquisicion' => $adquisicion->id_adquisicion, // CORRECTO
                        'id_proveedor' => $validated['id_proveedor'],
                        'precio' => $validated['precio_compra'],
                    ]);
                } elseif ($tipoAdquisicion === 'donacion') {
                    Donacion::create([
                        'id_adquisicion' => $adquisicion->id_adquisicion, // CORRECTO
                        'id_donante' => $validated['id_donante'],
                        'motivo' => $validated['motivo'],
                        'precio_estimado' => $validated['precio_donacion'],
                    ]);
                }
            }


            DB::commit();
            $activo->load(['categoria', 'unidad', 'estado']);

            return response()->json([
                'success' => true,
                'message' => 'Activo registrado correctamente.',
                'activo' => [
                    'id' => $activo->id_activo,
                    'codigo' => $activo->codigo,
                    'nombre' => $activo->nombre,
                    'detalle' => $activo->detalle,
                    'categoria' => $activo->categoria->nombre ?? '',
                    'unidad' => $activo->unidad->nombre ?? '',
                    'estado_fisico' => $activo->estado->nombre ?? '',
                    'situacion' => $activo->estado_situacional ?? 'LIbre',
                    'fecha' => $activo->created_at->format('d/m/Y'),
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el activo: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Activo $activo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activo $activo)
    {
        //
    }
}
