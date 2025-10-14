<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class ServicioController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
