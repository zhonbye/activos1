<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Devolucion;
use App\Models\Estado;
use App\Models\Unidad;
use Illuminate\Http\Request;

class DevolucionController extends Controller
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










    public function mostrarBuscar()
    {
        try {
            // Carga los datos necesarios para los selects
            $categorias = Categoria::all();
            $unidades = Unidad::all();
            $estados = Estado::all();

            // Retorna la vista con los datos
            return view('user.devolucion.parcial_buscar', compact('categorias', 'unidades', 'estados'));

        } catch (\Exception $e) {
            // \Log::error('Error al cargar parcial de búsqueda devoluciones: '.$e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
                ], 500);
            }

            return view('user.devolucion.parcial_buscar')->with('message', 'Ocurrió un error al cargar la vista de búsqueda.');
        }
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
    public function show($id)
    {
        $devolucion = Devolucion::findOrFail($id);
        return view('user.devolucion.show', compact('devolucion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Devolucion $devolucion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Devolucion $devolucion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Devolucion $devolucion)
    {
        //
    }
}
