<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ProveedorController extends Controller
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

    /**
     * Display the specified resource.
     */
    public function show($id = null)
    {

        // Traer usuarios
        $usuarios = Usuario::orderBy('usuario', 'asc')->get();

        // Traer servicios (cambia el modelo según tu proyecto)
        $servicios = Servicio::orderBy('nombre', 'asc')->get();

        // Traer responsables (si tus responsables también están en la tabla users, usa User)
        $responsables = Responsable::orderBy('nombre', 'asc')->get();
    // dd($id);
        return view('user.proveedores.show', compact(
            'id',
            'usuarios',
            'servicios',
            'responsables'
        ));
    }

    public function filtrar(Request $request)
    {
        $query = Proveedor::query();

        // Filtrar por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtrar por lugar
        if ($request->filled('lugar')) {
            $query->where('lugar', 'like', '%' . $request->lugar . '%');
        }

        // Paginación de 10 por página
        $proveedores = $query->orderBy('id_proveedor', 'desc')->paginate(10);

        // Devolver la vista parcial con los proveedores
        return view('user.proveedores.parcial_proveedores', compact('proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        //
    }
}
