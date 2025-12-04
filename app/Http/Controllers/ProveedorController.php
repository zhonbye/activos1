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
        // Validaciones
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            // Lugar: solo letras, espacios y "/" (sin números)
            'lugar' => [
                'nullable',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ \/]+$/',
                'max:255',
            ],

            // Contacto: correo O teléfono de 6 a 8 dígitos
            'contacto' => [
                'nullable',
                'regex:/^(\\d{6,8}|[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,})$/',
                'max:255',
            ],
        ], [
            // Mensajes personalizados
            'nombre.required' => 'El nombre del proveedor es obligatorio.',

            'lugar.regex' => 'El campo lugar solo puede contener letras, espacios o "/", sin números.',

            'contacto.regex' => 'El contacto debe ser un correo válido o un número de 6 a 8 dígitos.',
        ]);

        // Crear proveedor, transformando lugar a mayúsculas
        $proveedor = Proveedor::create([
            // 'nombre' => $request->nombre,
            // 'lugar' => $request->lugar ? strtoupper($request->lugar) : null,
            // 'contacto' => $request->contacto,
        ]);

        return response()->json([
            'message' => 'Proveedor creado correctamente.',
            'proveedor' => $proveedor
        ]);
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
        session(['proveedores_filtrados' => $proveedores]);

        // Devolver la vista parcial con los proveedores
        return view('user.proveedores.parcial_proveedores', compact('proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'lugar' => 'nullable|string|max:255',
            'contacto' => 'nullable|string|max:255',
        ]);

        // Actualizar
        $proveedor->nombre = $request->nombre;
        $proveedor->lugar = $request->lugar;
        $proveedor->contacto = $request->contacto;
        $proveedor->save();

        return response()->json(['message' => 'Proveedor actualizado correctamente']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        //
    }
}
