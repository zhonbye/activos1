<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use App\Models\Cargo;
use App\Models\Responsable;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $responsables = Responsable::all();
        $usuarios = Usuario::with('responsable')->get();
        return view('admin.usuarios.listar',compact('usuarios','responsables'));
    }

    public function create()
    {
        $cargos = Cargo::all();
        $responsables = Responsable::all();

        // Retorna la vista con la variable $cargos
        // return view('responsables.create', compact('cargos'));
        return view('admin.usuarios.registrar', compact('cargos', 'responsables'));
    }









public function listarParcial()
{
    // Cargar usuarios con su responsable relacionado
    $usuarios = Usuario::with('responsable')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

    return view('admin.usuarios.parcial', compact('usuarios'));
}


    // public function roles() {
    //     return view('usuarios.roles');
    // }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */










    public function store(Request $request)
{
    // Validaciones
    $validated = $request->validate([
    'usuario' => 'required|string|max:50|unique:usuarios,usuario',
    'clave' => 'required|string|min:6|confirmed', // ✅ usa "clave_confirmation"
    'rol' => 'required|string|in:administrador,usuario',
    'id_responsable' => 'required|exists:responsables,id_responsable',
]);

    try {
        $usuario = new Usuario();
        $usuario->usuario = $validated['usuario'];
        $usuario->clave = bcrypt($validated['clave']);
        $usuario->rol = $validated['rol'];
        $usuario->estado = 'activo';
        $usuario->id_responsable = $validated['id_responsable'];
        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'usuario' => $usuario
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al crear usuario: ' . $e->getMessage()
        ], 500);
    }
}

    // public function store(Request $request)
    // {
    //      $validator = Validator::make($request->all(), [
    //     'usuario' => 'required|string|max:50|unique:usuarios,usuario',
    //     'clave' => 'required|string|min:8',
    //     'rol' => 'required|string|in:desarrollador,administrador,usuario',
    //     'remember_token' => 'nullable|string|max:100',
    //     'id_responsable' => 'required|exists:responsables,id_responsable',
    // ], [
    //     'usuario.required' => 'El campo usuario es obligatorio.',
    //     'usuario.unique' => 'El usuario ya está en uso.',
    //     'usuario.max' => 'El usuario no puede exceder 50 caracteres.',
    //     'clave.required' => 'El campo clave es obligatorio.',
    //     'clave.min' => 'La clave debe tener al menos 8 caracteres.',
    //     'rol.required' => 'El campo rol es obligatorio.',
    //     'rol.in' => 'El rol seleccionado no es válido.',
    //     // 'remember_token.max' => 'El token no puede exceder 100 caracteres.',
    //     'id_responsable.required' => 'Debe seleccionar un responsable.',
    //     'id_responsable.exists' => 'El responsable seleccionado no existe.',
    // ]);

    // if ($validator->fails()) {
    //     return response()->json([
    //         'success' => false,
    //         'errors' => $validator->errors(),
    //         'message' => 'Errores de validación en los campos.'
    //     ], 422);
    // }

    // try {
    //     $validated = $validator->validated();

    //     $usuario = Usuario::create([
    //         'usuario' => $validated['usuario'],
    //         'clave' => bcrypt($validated['clave']),
    //         'rol' => $validated['rol'],
    //         'estado' => 'activo',
    //         'id_responsable' => $validated['id_responsable'],
    //         'remember_token' => $validated['remember_token'] ?? null,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Usuario creado correctamente.',
    //         'usuario_id' => $usuario->id_usuario
    //     ], 201);

    // } catch (\Exception $e) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Error al crear usuario: ' . $e->getMessage(),
    //     ], 500);
    // }
    // }











    public function store2(Request $request)
    {
        try {
            $validated = $request->validate([
                'usuario' => 'required|string|max:50|unique:usuarios,usuario',
                'clave' => 'required|string|min:8',
                'rol' => 'required|string|in:desarrollador,administrador,usuario',
                'remember_token' => 'nullable|string|max:100',
                // No validamos id_responsable porque se controla abajo
            ]);

            // Verificamos si viene el id_responsable, si no, buscamos el último insertado
            // $idResponsable = $request->input('id_responsable');

            // if (empty($idResponsable)) {
            //     $ultimoResponsable = Responsable::latest()->first(); // ordena por created_at desc
            //     if (!$ultimoResponsable) {
            //     echo " error no se encotro ultimo id del responasble";
            //         // return back()->with('error', 'No se encontró ningún responsable para asignar al usuario.');
            //     }
            //     $idResponsable = $ultimoResponsable->id_responsable;
            //     echo $ultimoResponsable->id_responsable;
            // }

            $usuario = new Usuario();
            $usuario->usuario = $validated['usuario'];
            $usuario->clave = bcrypt($validated['clave']);
            $usuario->rol = $validated['rol'];
            $usuario->estado = 'activo';
            $usuario->id_responsable;
            $usuario->remember_token = $validated['remember_token'] ?? null;
            $usuario->save();
            echo "se inserto";
            // return back()->with('success', 'Usuario creado. ID: ' . $usuario->id);
        } catch (\Exception $e) {
            // Log::error('Error al guardar usuario: ' . $e->getMessage());
            // return back()->with('error', 'Ocurrió un error al guardar el usuario.');
            echo "no se inserto" . $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_usuario)
    {
         // Buscar usuario con su responsable relacionado
        $usuario = Usuario::with('responsable')->findOrFail($id_usuario);

        // Retorna la vista parcial que contiene el formulario de edición
        return view('admin.usuarios.parcial_editar', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_usuario)
{
    $usuario = Usuario::findOrFail($id_usuario);

    // Validar datos
    $request->validate([
        'usuario' => 'required|string|max:50',
        'rol' => 'required|string',
        'estado' => 'required|in:activo,inactivo',
        'clave' => 'nullable|string|min:6|confirmed', // solo si cambia
    ]);

    // Actualizar campos
    $usuario->usuario = $request->usuario;
    $usuario->rol = $request->rol;
    $usuario->estado = $request->estado;
    // $usuario->id_responsable = $request->id_responsable;

    // Cambiar contraseña solo si se ingresó
    if ($request->filled('clave')) {
        $usuario->clave = bcrypt($request->clave);
    }

    $usuario->save();

    return response()->json([
        'success' => true,
        'mensaje' => 'Usuario actualizado correctamente'
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
