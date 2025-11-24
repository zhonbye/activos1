<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Servicio;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
public function actualizarResponsable(Request $request) //pendiente
{
    $validated = $request->validate([
        'servicio_id'    => 'required|exists:servicios,id_servicio',
        'id_responsable' => 'required|exists:responsables,id_responsable',
    ], [
        'id_responsable.required' => 'Debe seleccionar un responsable.',
        'id_responsable.exists'   => 'El responsable seleccionado no es válido.',
    ]);

    try {
        $servicio = Servicio::findOrFail($validated['servicio_id']);
        $servicio->id_responsable = $validated['id_responsable'];
        $servicio->save();

        return response()->json([
            'message'   => 'Responsable actualizado correctamente.',
            'servicio'  => $servicio
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al actualizar el responsable.',
            'error'   => $e->getMessage()
        ], 500);
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
    // VALIDACIÓN
    $validated = $request->validate([
        'nombre'          => 'required|string|max:255',
        'descripcion'     => 'nullable|string|max:500',
        'id_responsable'  => 'required|exists:responsables,id_responsable',
    ], [
        'nombre.required'          => 'El nombre del servicio es obligatorio.',
        'id_responsable.required'  => 'Debe seleccionar un responsable.',
        'id_responsable.exists'    => 'El responsable seleccionado no es válido.',
    ]);

    DB::beginTransaction();

    try {

        // =======================================================
        // 1️⃣ CREAR SERVICIO
        // =======================================================
        $servicio = new Servicio();
        $servicio->nombre = $validated['nombre'];
        $servicio->descripcion = $validated['descripcion'] ?? null;
        $servicio->id_responsable = $validated['id_responsable'];
        $servicio->save();


        // =======================================================
        // 2️⃣ CREAR INVENTARIO INICIAL
        // =======================================================
        $gestion = Carbon::now()->year;   // EJ: 2025
        $hoy = Carbon::now()->format('Y-m-d');

        // --- BUSCAR NÚMEROS EXISTENTES DE LA GESTIÓN ---
        $numeros = Inventario::where('gestion', $gestion)
                    ->orderBy('numero_documento', 'asc')
                    ->pluck('numero_documento')
                    ->toArray();

        // --- ENCONTRAR EL PRIMER HUECO ---
        $nuevoNumero = 1;
        foreach ($numeros as $n) {
            if (intval($n) == $nuevoNumero) {
                $nuevoNumero++;
            } else {
                break; 
            }
        }

        // --- FORMATEAR A 3 DÍGITOS ---
        $numeroDocumento = str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT);

        // --- CREAR INVENTARIO ---
        $inventario = new Inventario();
        $inventario->numero_documento = $numeroDocumento;
        $inventario->gestion = $gestion;
        $inventario->fecha = $hoy;
        $inventario->id_usuario = auth()->id();  // usuario logueado
        $inventario->id_responsable = $validated['id_responsable'];
        $inventario->id_servicio = $servicio->id_servicio;
        $inventario->observaciones = "Inventario inicial";
        $inventario->estado = "vigente";
        $inventario->url = null; // si luego lo actualizas
        $inventario->save();


        DB::commit();

        return response()->json([
            'message' => 'Servicio y su inventario inicial fueron creados correctamente.',
            'servicio' => $servicio,
            'inventario' => $inventario
        ], 200);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'message' => 'Error al guardar los datos.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function responsable($id)
    {
        $servicio = Servicio::with('responsable')->find($id);

        if (!$servicio || !$servicio->responsable) {
            return response()->json(['error' => 'Responsable no encontrado'], 404);
        }

        return response()->json([
            'id' => $servicio->responsable->id_responsable,
            'nombre' => $servicio->responsable->nombre
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Ubicacion $ubicacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ubicacion $ubicacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ubicacion $ubicacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ubicacion $ubicacion)
    {
        //
    }
}
