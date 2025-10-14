<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
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
    public function createEntrega()
    {
        // $ultimo = Docto::orderBy('id_docto', 'desc')->first();
        // $numeroSiguiente = $ultimo ? str_pad($ultimo->numero + 1, 3, '0', STR_PAD_LEFT) : '001';
    //     $gestion = date('Y'); // o la gestión que quieras por defecto
    // $numeroSiguiente = $this->obtenerSiguienteNumero($gestion);


        return view('user.entregas.registrar', [
            // 'numeroSiguiente' => $numeroSiguiente,
            // 'ubicaciones' => Ubicacion::all(),
            // 'responsables' => Responsable::all(),
            // 'servicios' => Servicio::all(),
        ]);
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
    public function show(Movimiento $movimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimiento $movimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movimiento $movimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimiento $movimiento)
    {
        //
    }
}
