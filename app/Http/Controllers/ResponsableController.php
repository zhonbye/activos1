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
        $personales = Responsable::with(['usuario', 'cargo'])->paginate(10);

        $servicios = \App\Models\Servicio::select('id_servicio', 'nombre')->orderBy('nombre')->get();
        $cargos = \App\Models\Cargo::select('id_cargo', 'nombre')->orderBy('nombre')->get();

// return view('admin.personales.index');
        return view('admin.responsables.listar', compact('personales', 'servicios', 'cargos'));
    }
    public function filtrarResponsables(Request $request)
    {
        $query = Responsable::with(['usuario', 'cargo']);

        // 🔹 Filtro por cargo
        if ($request->filled('id_cargo')) {
            $query->where('id_cargo', $request->id_cargo);
        }

        // 🔹 Filtro por rol
        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        // 🔹 Filtro por estado (activo/inactivo)
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // 🔸 Ordenar y paginar
        $personales = $query->orderBy('nombre')->paginate(10);

        // 🔸 Si la petición viene por AJAX → retornar solo la tabla
        if ($request->ajax()) {
            return view('admin.responsables.parcial', compact('personales'))->render();
        }

        // 🔸 Si es acceso directo → vista completa
        return view('admin.responsables.listar', compact('personales'));
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
            // 🧩 Validar los datos del formulario
            $validated = $request->validate([
                'nombre'     => 'required|string|max:255',
                'ci'         => 'required|string|max:100|unique:responsables,ci',
                'telefono'   => 'nullable|string|max:30',
                'id_cargo'   => 'required|integer|exists:cargos,id_cargo',
                'rol'        => 'required|string|in:admin,user,tecnico',
            ]);

            // 🧩 Crear el nuevo responsable
            $responsable = Responsable::create([
                'nombre'   => $validated['nombre'],
                'ci'       => $validated['ci'],
                'telefono' => $validated['telefono'] ?? null,
                'id_cargo' => $validated['id_cargo'],
                'rol'      => $validated['rol'],
            ]);

            // 🧩 Cargar relaciones necesarias para mostrar en tabla
            $responsable->load('cargo');

            // 🧩 Añadir campos de formato adicional (fecha, etc.)
            $responsable->fecha_creacion = $responsable->created_at->format('d/m/Y');

            // ✅ Retornar respuesta JSON con todo el modelo
            return response()->json([
                'success' => true,
                'message' => 'Responsable creado correctamente.',
                'responsable' => $responsable
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // ⚠️ Errores de validación
            return response()->json([
                'success' => false,
                'message' => 'Error de validación en responsable.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            // ❌ Error general del servidor
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
