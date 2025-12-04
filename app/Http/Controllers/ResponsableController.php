<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Responsable;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $personales = Responsable::with(['usuario', 'cargo'])->paginate(10);
       $personales = Responsable::with(['usuario', 'cargo', 'servicio'])
    ->orderBy('created_at', 'desc')
    ->paginate(20);



        $servicios = \App\Models\Servicio::select('id_servicio', 'nombre')->orderBy('nombre')->get();
        $cargos = \App\Models\Cargo::select('id_cargo', 'nombre')->orderBy('nombre')->get();

        // return view('admin.personales.index');
        return view('admin.responsables.listar', compact('personales', 'servicios', 'cargos'));
    }
    public function filtrarResponsables(Request $request)
    {
        $query = Responsable::with(['usuario', 'cargo']);


        // 🔍 Filtro por texto (nombre, CI o teléfono)
if ($request->filled('search')) {
    $query->where(function ($q) use ($request) {
        $search = $request->search;
        $q->where('nombre', 'like', "%$search%")
          ->orWhere('ci', 'like', "%$search%")
          ->orWhere('telefono', 'like', "%$search%");
    });
}

        //  Filtro por cargo
        if ($request->filled('id_cargo')) {
            $query->where('id_cargo', $request->id_cargo);
        }

        //  Filtro por rol
        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        //  Filtro por estado (activo/inactivo)
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        //  Ordenar y paginar
        $personales = $query->orderBy('created_at', 'desc')->paginate(20);


        //  Si la petición viene por AJAX → retornar solo la tabla
        if ($request->ajax()) {
            return view('admin.responsables.parcial', compact('personales'))->render();
        }

        // Si es acceso directo → vista completa
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
        // 🔹 Validar los datos con mensajes personalizados
     $validated = $request->validate(

    [
        'nombre' => [
            'required',
            'string',
            'max:255',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/',          // solo letras y espacios
            'regex:/^(\S+\s+){1,4}\S+$/',                // entre 2 y 5 palabras
        ],

        'ci' => [
            'required',
            'digits_between:6,8',
            'regex:/^[0-9]+$/',
            'unique:responsables,ci',
        ],

        'telefono' => [
            'nullable',
            'digits_between:6,8',
            'regex:/^[0-9]+$/',
        ],

        'id_cargo' => 'required|integer|exists:cargos,id_cargo',
        'rol'       => 'required|string|max:255',
    ],

    /* ------------------------------
       ⚠️ MENSAJES PERSONALIZADOS
    ------------------------------- */
    [
        'required' => 'El campo :attribute es obligatorio.',
        'string'   => 'El campo :attribute debe ser texto.',
        'unique'   => 'El :attribute ya está registrado.',
        'exists'   => 'El :attribute seleccionado no es válido.',
        'max'      => 'El campo :attribute no debe superar :max caracteres.',

        // Nombre solo letras
        'nombre.regex' => 'El nombre solo debe contener letras y debe tener entre 2 y 5 palabras.',

        // CI
        'ci.regex'            => 'El CI solo puede contener números.',
        'ci.digits_between'   => 'El CI debe tener entre 6 y 8 dígitos.',

        // Teléfono
        'telefono.regex'          => 'El teléfono solo puede contener números.',
        'telefono.digits_between' => 'El teléfono debe tener entre 6 y 8 dígitos.',
    ],

    /* ------------------------------
       🏷️ Alias amigables
    ------------------------------- */
    [
        'nombre'   => 'nombre del responsable',
        'ci'       => 'CI',
        'telefono' => 'teléfono',
        'id_cargo' => 'cargo',
        'rol'      => 'rol del usuario',
    ]
);

$responsable= null;
        // Crear el nuevo responsable
        $responsable = Responsable::create([
            'nombre'   => $validated['nombre'],
            'ci'       => $validated['ci'],
            'telefono' => $validated['telefono'] ?? null,
            'id_cargo' => $validated['id_cargo'],
            'rol'      => $validated['rol'],
        ]);

        $responsable->load('cargo');
        $responsable = [
            'id_responsable'   => $responsable->id_responsable,
            'nombre'   => $responsable->nombre,
            'ci'       => $responsable->ci,
            'telefono' => $responsable->telefono,
            'cargo'    => $responsable->cargo->nombre ?? 'Sin cargo',
            'rol'      => ucwords(strtolower($responsable->rol)) ?? 'Sin rol',
            'estado'   => 'activo',
            'fecha'    => $responsable->created_at->format('d/m/Y'),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Responsable creado correctamente.',
            'responsable' => $responsable
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error de validación en responsable.',
            'errors'  => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'No se pudo insertar responsable: ' . $e->getMessage(),
        ], 500);
    }
}



    // public function store2(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'nombre' => 'required|string|max:255',
    //             'ci' => 'required|string|max:100|unique:responsables,ci',
    //             'telefono' => 'required|string|max:30',
    //             'id_cargo' => 'required|integer|exists:cargos,id_cargo',
    //         ]);

    //         $responsable = new Responsable();
    //         $responsable->nombre = $validated['nombre'];
    //         $responsable->ci = $validated['ci'];
    //         $responsable->telefono = $validated['telefono'];
    //         $responsable->id_cargo = $validated['id_cargo'];
    //         $responsable->save();

    //         // return back()->route('responsables.index')->with('success', 'Responsable creado correctamente.');
    //         // echo "se inserto responsable";
    //     } catch (\Exception $e) {
    //         // Log::error('Error al guardar responsable: '.$e->getMessage());
    //         // return back()->with('error', 'Ocurrió un error al guardar el responsable.');
    //         // echo "no se inserto responsable".$e->getMessage();
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $responsable = Responsable::find($id);
        if (!$responsable) {
            return response()->json(['error' => 'No encontrado'], 404);
        }
        return response()->json($responsable);
    }
public function edit($id)
{
    // Traer responsable con su cargo y usuario del sistema
    $responsable = Responsable::with('cargo')
        ->findOrFail($id);

    // Traer datos para selects (si necesitas en el modal)
    $cargos = Cargo::all();

    return view('admin.responsables.parcial_editar', compact('responsable', 'cargos'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $request->validate(

        [
            // NOMBRE: mínimo 2 palabras y máximo 5, solo letras
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/',     // solo letras + espacios
                'regex:/^(\S+\s+){1,4}\S+$/'            // entre 2 y 5 palabras
            ],

            // CI: solo números, 6 a 8 dígitos, único excepto su propio registro
            'ci' => [
                'required',
                'regex:/^[0-9]+$/',
                'digits_between:6,8',
                'unique:responsables,ci,' . $id . ',id_responsable'
            ],

            // TELEFONO: solo números, 6 a 8 dígitos
            'telefono' => [
                'nullable',
                'regex:/^[0-9]+$/',
                'digits_between:6,8'
            ],

            'id_cargo' => 'required|exists:cargos,id_cargo',
            'rol'      => 'required|string|max:255',
            'estado'   => 'required|in:activo,inactivo',
        ],

        /* ------------------------------
           MENSAJES PERSONALIZADOS
        ------------------------------- */
        [
            'required' => 'El campo :attribute es obligatorio.',
            'string'   => 'El campo :attribute debe ser un texto.',
            'max'      => 'El campo :attribute no debe exceder :max caracteres.',
            'unique'   => 'El :attribute ya está registrado.',
            'exists'   => 'El :attribute seleccionado no es válido.',
            'in'       => 'El :attribute seleccionado no es válido.',

            // Nombre
            'nombre.regex' => 'El nombre solo debe contener letras y debe tener entre 2 y 5 nombres.',

            // CI
            'ci.regex'            => 'El CI solo puede contener números.',
            'ci.digits_between'   => 'El CI debe tener entre 6 y 8 dígitos.',

            // Teléfono
            'telefono.regex'          => 'El teléfono solo puede contener números.',
            'telefono.digits_between' => 'El teléfono debe tener entre 6 y 8 dígitos.',
        ],

        /* ------------------------------
           ALIAS AMIGABLES
        ------------------------------- */
        [
            'nombre'   => 'nombre del responsable',
            'ci'       => 'CI',
            'telefono' => 'teléfono',
            'id_cargo' => 'cargo',
            'rol'      => 'rol del usuario',
            'estado'   => 'estado',
        ]
    );

    // --- ACTUALIZAR ---
    $responsable = Responsable::findOrFail($id);

    $responsable->update([
        'nombre'    => $request->nombre,
        'ci'        => $request->ci,
        'telefono'  => $request->telefono,
        'id_cargo'  => $request->id_cargo,
        'rol'       => ucwords(strtolower($request->rol)),
        'estado'    => ucwords(strtolower($request->estado)),
    ]);

    $responsable->load('cargo');

    return response()->json([
        'success'     => true,
        'message'     => 'Responsable actualizado correctamente.',
        'responsable' => [
            'id_responsable' => $responsable->id_responsable,
            'nombre'         => $responsable->nombre,
            'ci'             => $responsable->ci,
            'telefono'       => $responsable->telefono,
            'cargo'          => $responsable->cargo->nombre ?? 'Sin cargo',
            'rol'            => $responsable->rol,
            'estado'         => $responsable->estado,
            'usuario'        => $responsable->usuario->name ?? 'N/A',
        ]
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Responsable $responsable)
    {
        //
    }
}
