<?php

namespace App\Http\Controllers;

use App\Models\Responsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
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
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'ci' => 'required|string|max:100|unique:responsables,ci',
                'telefono' => 'required|string|max:30',
                'id_cargo' => 'required|integer|exists:cargos,id_cargo',
            ]);

            $responsable = Responsable::create($validated);

            return response()->json([
                'success' => true,
                'responsable_id' => $responsable->id_responsable,
                'message' => 'Responsable creado correctamente.'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Error de validación en responsable.'.$e
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo insertar responsable: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function store2(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'ci' => 'required|string|max:100|unique:responsables,ci',
                'telefono' => 'required|string|max:30',
                'id_cargo' => 'required|integer|exists:cargos,id_cargo',
            ]);

            $responsable = new Responsable();
            $responsable->nombre = $validated['nombre'];
            $responsable->ci = $validated['ci'];
            $responsable->telefono = $validated['telefono'];
            $responsable->id_cargo = $validated['id_cargo'];
            $responsable->save();

            // return back()->route('responsables.index')->with('success', 'Responsable creado correctamente.');
        echo "se inserto responsable";
        } catch (\Exception $e) {
            // Log::error('Error al guardar responsable: '.$e->getMessage());
            // return back()->with('error', 'Ocurrió un error al guardar el responsable.');
            echo "no se inserto responsable".$e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {
        $responsable = Responsable::find($id);
        if (!$responsable) {
            return response()->json(['error' => 'No encontrado'], 404);
        }
        return response()->json($responsable);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Responsable $responsable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Responsable $responsable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Responsable $responsable)
    {
        //
    }
}
