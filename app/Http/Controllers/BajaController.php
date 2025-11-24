<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Baja;
use App\Models\DetalleDevolucion;
use App\Models\DetalleEntrega;
use App\Models\DetalleInventario;
use App\Models\DetalleTraslado;
use App\Models\Devolucion;
use App\Models\Entrega;
use App\Models\Inventario;
use App\Models\Responsable;
use App\Models\Traslado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.bajas.realizar');
    }

public function buscarActivo(Request $request)
{
   $id_activo = $request->id_activo;

    // Traer detalles de inventarios donde esté el activo
    $detalle = DetalleInventario::with(['inventario', 'inventario.servicio', 'activo'])
                ->where('id_activo', $id_activo)
                ->orderByDesc('id_detalle_inventario')
                ->get();
// dd($detalle->map(function($d) {
//     return [
//         'id_detalle_inventario' => $d->id_detalle_inventario,
//         'id_inventario' => $d->id_inventario,
//         'estado_inventario' => optional($d->inventario)->estado,
//         'id_servicio' => optional($d->inventario->servicio)->id_servicio ?? null,
//         'nombre_servicio' => optional($d->inventario->servicio)->nombre ?? null,
//         'activo_id' => $d->id_activo,
//     ];
// }));
    if ($detalle->isEmpty()) {
        return response()->json(['error' => 'Activo no encontrado en inventarios'], 404);
    }

    // Buscar inventario vigente
    $detalle_vigente = $detalle->firstWhere('inventario.estado', 'vigente');
    if (!$detalle_vigente) {
        $detalle_vigente = $detalle->first();
    }

    $activo = $detalle_vigente->activo;
    $servicio = $detalle_vigente->inventario->servicio;
    $responsable_id = $detalle_vigente->inventario->id_responsable;
    $id_servicio = $servicio->id_servicio ?? null; // ⚠ aquí obtienes el ID
    // Traer todos los responsables para el select
    // dd($id_servicio);
    $responsables = Responsable::orderBy('nombre', 'asc')->get();
    // Retornar vista parcial renderizada
    return view('user.activos.registrarBaja', compact('activo', 'servicio', 'id_servicio','responsables', 'responsable_id'))->render();
}



public function store(Request $request)
{
    $request->validate([
        'id_activo' => 'required|exists:activos,id_activo',
        'id_responsable' => 'required|exists:responsables,id_responsable',
        'id_servicio' => 'required|exists:servicios,id_servicio',
        'motivo' => 'required|string|max:255',
        'observaciones' => 'nullable|string|max:255'
    ]);

    try {

        DB::beginTransaction(); // 🚀 INICIA TRANSACCIÓN SEGURA

        $activo = Activo::findOrFail($request->id_activo);
        $eliminados = [];

        // ============================================================
        // 1️⃣ ELIMINAR DETALLE DE TRASLADO PENDIENTES
        // ============================================================
        $detalles = DetalleTraslado::where('id_activo', $activo->id_activo)->get();

        foreach ($detalles as $d) {
            $padre = Traslado::find($d->id_traslado);
            if ($padre && strtolower($padre->estado) === 'pendiente') {
                $d->delete();
                $eliminados[] = 'detalle_traslado';
            }
        }

        // ============================================================
        // 2️⃣ ELIMINAR DETALLE DE ENTREGA PENDIENTES
        // ============================================================
        $detalles = DetalleEntrega::where('id_activo', $activo->id_activo)->get();

        foreach ($detalles as $d) {
            $padre = Entrega::find($d->id_entrega);
            if ($padre && strtolower($padre->estado) === 'pendiente') {
                $d->delete();
                $eliminados[] = 'detalle_entrega';
            }
        }

        // ============================================================
        // 3️⃣ ELIMINAR DETALLE DE DEVOLUCIÓN PENDIENTES
        // ============================================================
        $detalles = DetalleDevolucion::where('id_activo', $activo->id_activo)->get();

        foreach ($detalles as $d) {
            $padre = Devolucion::find($d->id_devolucion);
            if ($padre && strtolower($padre->estado) === 'pendiente') {
                $d->delete();
                $eliminados[] = 'detalle_devolucion';
            }
        }

        // ============================================================
        // 4️⃣ ELIMINAR DETALLE DE INVENTARIO PENDIENTES
        // ============================================================
        $detalles = DetalleInventario::where('id_activo', $activo->id_activo)->get();

        foreach ($detalles as $d) {
            $padre = Inventario::find($d->id_inventario);
            if ($padre && strtolower($padre->estado) === 'pendiente') {
                $d->delete();
                $eliminados[] = 'detalle_inventario';
            }
        }

        // ============================================================
        // 5️⃣ CAMBIAR ESTADO DEL ACTIVO
        // ============================================================
        $activo->estado_situacional = 'baja';
        $activo->save();

        // ============================================================
        // 6️⃣ REGISTRAR LA BAJA
        // ============================================================
        Baja::create([
            'id_activo' => $activo->id_activo,
            'id_servicio' => $request->id_servicio,
            'id_responsable' => $request->id_responsable,
            'id_usuario' => $request->id_usuario,
            'fecha' => now()->toDateString(),
            'motivo' => $request->motivo,
            'observaciones' => $request->observaciones
        ]);

        DB::commit(); // 🟢 TODO OK → CONFIRMAR CAMBIOS


        return response()->json([
            'message' => "El activo '{$activo->nombre}' fue dado de baja correctamente.",
            'eliminados' => $eliminados ?: 'No se eliminó ningún registro pendiente.'
        ]);

    } catch (\Exception $e) {

        DB::rollBack(); // 🔴 ALGO FALLÓ → REVERSA TODO

        return response()->json([
            'error' => 'Ocurrió un error y no se realizó la baja.',
            'detalles' => $e->getMessage()
        ], 500);
    }
}




    /**
     * Display the specified resource.
     */
    public function show(Baja $baja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Baja $baja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Baja $baja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Baja $baja)
    {
        //
    }
}
