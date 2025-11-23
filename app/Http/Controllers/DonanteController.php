<?php

namespace App\Http\Controllers;

use App\Models\Donante;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;

class DonanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
public function filtrar(Request $request)
    {
        $query = Donante::query();

        // Filtrar por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtrar por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', 'like', '%' . $request->tipo . '%');
        }

        // Paginación de 10 por página
        $donantes = $query->orderBy('id_donante', 'desc')->paginate(10);
        session(['donantes_filtrados' => $donantes]);

        // Devolver la vista parcial con los donantes
        return view('user.donantes.parcial_donantes', compact('donantes'));
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
        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'contacto' => 'nullable|string|max:255',
        ]);

        // Crear nuevo donante con tipo en mayúsculas
        $donante = Donante::create([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo ? strtoupper($request->tipo) : null,
            'contacto' => $request->contacto,
        ]);

        return response()->json(['message' => 'Donante creado correctamente', 'donante' => $donante]);
    }
   public function show($id = null)
    {

        // Traer usuarios
        $usuarios = Usuario::orderBy('usuario', 'asc')->get();

        // Traer servicios (cambia el modelo según tu proyecto)
        $servicios = Servicio::orderBy('nombre', 'asc')->get();

        // Traer responsables (si tus responsables también están en la tabla users, usa User)
        $responsables = Responsable::orderBy('nombre', 'asc')->get();
    // dd($id);
        return view('user.donantes.show', compact(
            'id',
            'usuarios',
            'servicios',
            'responsables'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donante $donante)
    {
        //
    }

 public function update(Request $request, $id)
    {
        $donante = Donante::findOrFail($id);

        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'contacto' => 'nullable|string|max:255',
        ]);

        // Actualizar
        $donante->nombre = $request->nombre;
        $donante->tipo = $request->tipo;
        $donante->contacto = $request->contacto;
        $donante->save();

        return response()->json(['message' => 'Donante actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donante $donante)
    {
        //
    }
}
