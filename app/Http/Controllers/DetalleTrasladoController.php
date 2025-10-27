<?php

namespace App\Http\Controllers;

use App\Models\DetalleTraslado;
use App\Models\Traslado;
use Illuminate\Http\Request;

class DetalleTrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
public function limpiarActivos($id)
{
   try {
    $traslado = Traslado::find($id);

    if (!$traslado) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró el traslado especificado.'
        ]);
    }

    // Verificar si el traslado está finalizado o eliminado
    if (in_array(strtolower($traslado->estado), ['finalizado', 'eliminado'])) {
        return response()->json([
            'success' => false,
            'message' => 'No se pueden modificar los activos de este traslado porque está finalizado o eliminado.'
        ]);
    }

    // Obtener todos los detalles del traslado
    $detalles = $traslado->detalles()->get();

    if ($detalles->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No hay activos para eliminar en este traslado.'
        ]);
    }

    // Eliminar los detalles
    $deleted = 0;
    foreach ($detalles as $detalle) {
        $detalle->delete();
        $deleted++;
    }

    return response()->json([
        'success' => true,
        'message' => "Se eliminaron $deleted activos del traslado."
    ]);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Error al eliminar los activos: ' . $e->getMessage()
    ]);
}

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetalleTraslado $detalleTraslado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetalleTraslado $detalleTraslado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleTraslado $detalleTraslado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetalleTraslado $detalleTraslado)
    {
        //
    }
}
