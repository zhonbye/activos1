<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Categoria;
use App\Models\DetalleDevolucion;
use App\Models\DetalleInventario;
use App\Models\Devolucion;
use App\Models\Estado;
use App\Models\Inventario;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Traslado;
use App\Models\Unidad;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    // Obtener todos los servicios con su responsable (para mostrar en el select)
    $servicios = Servicio::with('responsable')->get();

    // Determinar la gestión actual (sin Carbon)
    $gestionActual = date('Y');

    // Generar número de documento disponible
    $numeroDisponible = $this->generarNumeroDocumento($gestionActual);

    // Retornar vista con variables
    return view('user.devolucion.parcial_nuevo', compact('servicios', 'gestionActual', 'numeroDisponible'));
}

public function mostrarInventario()
{
    try {
        // $servicios = Servicio::all(); // Ya no es necesario si solo hay un servicio
        $categorias = Categoria::all(); // Para llenar selects de categorías

        // Cambiamos la vista a la carpeta de devolucion
        return view('user.devolucion.parcial_inventario', compact('categorias'));
    } catch (\Exception $e) {
        // Opcional: loguear el error
        // \Log::error('Error al cargar parcial de inventario de devolucion: '.$e->getMessage());

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al cargar la vista de inventario de devoluciones.'
            ], 500);
        }

        return view('user.devolucion.parcial_inventario')->with([
            'message' => 'Ocurrió un error al cargar la vista de inventario de devoluciones.'
        ]);
    }
}


public function buscar(Request $request)
{
    try {
        $query = Devolucion::query()->noEliminados();

        // Búsqueda insensible a mayúsculas/minúsculas
        if ($request->numero_documento) {
            $numero = $request->numero_documento;
            $query->whereRaw('LOWER(numero_documento) LIKE ?', ['%' . strtolower($numero) . '%']);
        }

        if ($request->gestion) {
            $query->where('gestion', $request->gestion);
        }

        if ($request->fecha_desde) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        if ($request->id_servicio) {
            $query->where('id_servicio', $request->id_servicio);
        }

        $devoluciones = $query->orderBy('fecha', 'desc')->get();

        return view('user.devolucion.parcial_resultados_busqueda', compact('devoluciones'));
    } catch (\Exception $e) {
        // \Log::error('Error en búsqueda de devoluciones: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al buscar las devoluciones. ' . $e
        ], 500);
    }
}






 public function buscarActivos(Request $request)
{
    try {
        // 🔹 Consulta base: Inventarios del servicio seleccionado
        $inventariosQuery = Inventario::query();

        if ($request->filled('id_servicio')) {
            $inventariosQuery->where('id_servicio', $request->id_servicio);
        }

        $inventarios = $inventariosQuery->pluck('id_inventario');

        // 🔹 Base de detalle de inventarios con relaciones
        $detalleQuery = DetalleInventario::with(['activo', 'inventario'])
            ->whereIn('id_inventario', $inventarios)
            ->where('estado_actual', '!=', 'eliminado')
            ->whereHas('activo', function ($q) {
                $q->soloActivos();
            });

        // 🔹 Filtros opcionales
        if ($request->filled('codigo_activo')) {
            $codigo = strtolower($request->codigo_activo);
            $detalleQuery->whereHas('activo', function ($q) use ($codigo) {
                $q->soloActivos()
                    ->whereRaw('LOWER(codigo) LIKE ?', ["%{$codigo}%"]);
            });
        }

        if ($request->filled('nombre_activo')) {
            $nombre = strtolower($request->nombre_activo);
            $detalleQuery->whereHas('activo', function ($q) use ($nombre) {
                $q->soloActivos()
                    ->whereRaw('LOWER(nombre) LIKE ?', ["%{$nombre}%"]);
            });
        }

        if ($request->filled('categoria_activo')) {
            $categoria = strtolower($request->categoria_activo);
            $detalleQuery->whereHas('activo.categoria', function ($q) use ($categoria) {
                $q->whereRaw('LOWER(nombre) LIKE ?', ["%{$categoria}%"]);
            });
        }

        // 🔹 Obtener resultados
        $detalles = $detalleQuery->get();
        $idDevolucionActual = $request->id_devolucion ?? null;

        foreach ($detalles as $detalle) {
            $idActivo = $detalle->activo->id_activo ?? null;

            if (!$idActivo) {
                $detalle->cantidad_inventario = 0;
                $detalle->cantidad_restante = 0;
                $detalle->estado_tipo = 'none';
                $detalle->estado_actual = 'N/D';
                continue;
            }

            $cantidadInventario = $detalle->cantidad ?? 0;

            // 🔹 Cantidad usada en otras devoluciones
            $cantidadUsadaOtros = DetalleDevolucion::where('id_activo', $idActivo)
                ->when($idDevolucionActual, fn($q) => $q->where('id_devolucion', '!=', $idDevolucionActual))
                ->sum('cantidad');

            // 🔹 Actas (devoluciones) donde aparece este activo
            $actas = DetalleDevolucion::where('id_activo', $idActivo)
                ->join('devoluciones as d', 'd.id_devolucion', '=', 'detalle_devoluciones.id_devolucion')
                ->select('detalle_devoluciones.id_devolucion', 'd.numero_documento')
                ->distinct()
                ->get()
                ->map(function ($a) {
                    return [
                        'id' => $a->id_devolucion,
                        'numero_documento' => $a->numero_documento,
                    ];
                })
                ->values()
                ->toArray();

            $cantidadActasRegistradas = count($actas);

            $detalle->setAttribute('actas_info', $actas);
            $detalle->setAttribute('cantidad_actas', $cantidadActasRegistradas);

            // 🔹 Cantidad usada en esta devolución
            $cantidadUsadaActual = $idDevolucionActual
                ? DetalleDevolucion::where('id_activo', $idActivo)
                    ->where('id_devolucion', $idDevolucionActual)
                    ->sum('cantidad')
                : 0;

            // 🔹 Calcular restantes
            $cantidadRestante = max(0, $cantidadInventario - $cantidadUsadaOtros - $cantidadUsadaActual);

            $detalle->setAttribute('cantidad_inventario', $cantidadInventario);
            $detalle->setAttribute('cantidad_usada_total', $cantidadUsadaOtros + $cantidadUsadaActual);
            $detalle->setAttribute('cantidad_en_acta', $cantidadUsadaActual);
            $detalle->setAttribute('cantidad_restante', $cantidadRestante);

            $detalle->estado_tipo = $cantidadRestante > 0 ? 'disponible' : 'sin_disponibilidad';
            $detalle->estado_actual = $detalle->activo->detalleInventario->estado_actual ?? 'N/D';
            $detalle->setAttribute('id_devolucion', $idDevolucionActual ?? null);
        }

        return view('user.devolucion.parcial_resultados_inventario', compact('detalles'));

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al buscar en el inventario: ' . $e->getMessage()
        ], 500);
    }
}















public function generarNumeroDocumento(string $gestion): string
{
    $maxNumero = 999;

    $numerosExistentes = Devolucion::where('gestion', $gestion)
        ->where('estado', '!=', 'ELIMINADO')
        ->pluck('numero_documento')
        ->toArray();

    // Asegurarse que no haya espacios
    $numerosExistentesSet = array_flip(array_map('trim', $numerosExistentes));

    for ($i = 1; $i <= $maxNumero; $i++) {
        $numeroFormateado = str_pad($i, 3, '0', STR_PAD_LEFT);
        if (!isset($numerosExistentesSet[$numeroFormateado])) {
            return $numeroFormateado;
        }
    }

    throw new \Exception('No hay números disponibles para la gestión ' . $gestion);
}







    public function detalleParcialDevolucion($id)
    {
        $devolucion = Devolucion::with([
            'responsable', // persona responsable
            'servicio'     // servicio asociado
        ])->findOrFail($id);

        return view('user.devolucion.parcial_devolucion', compact('devolucion'));
    }


// public function mostrarBuscar()
//     {
//         try {
//             $servicios = Servicio::all(); // Para llenar los selects
//             return view('user.traslados.parcial_buscar', compact('servicios'));
//         } catch (\Exception $e) {
//             // Opcional: loguear el error
//             // \Log::error('Error al cargar parcial de búsqueda: '.$e->getMessage());

//             // Si quieres devolver JSON (para AJAX)
//             if (request()->ajax()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
//                 ], 500);
//             }

//             // Para petición normal, devolver vista con mensaje de error
//             return view('user.traslados.parcial_buscar')->with(['message' => 'Ocurrió un error al cargar la vista de búsqueda.']);
//         }
//     }
    public function mostrarBuscarActa()
    {
        try {
            // Carga los datos necesarios para los selects
            $categorias = Categoria::all();
            $unidades = Unidad::all();
            $estados = Estado::all();
            $servicios = Servicio::all(); // Para llenar los selects

            // Retorna la vista con los datos
            return view('user.devolucion.parcial_buscarActa', compact('categorias', 'unidades', 'estados','servicios'));

        } catch (\Exception $e) {
            // \Log::error('Error al cargar parcial de búsqueda devoluciones: '.$e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
                ], 500);
            }

            return view('user.devolucion.parcial_buscarActa')->with('message', 'Ocurrió un error al cargar la vista de búsqueda.');
        }
    }


public function eliminarActivo(Request $request, $id)
{
    try {
        // 1️⃣ Verificar que la devolución exista
        $devolucion = Devolucion::findOrFail($id);

        if (!$devolucion->isEditable()) {
            return response()->json([
                'success' => false,
                'error' => 'No se puede eliminar activos de una devolución FINALIZADA o ELIMINADA.'
            ], 422);
        }

        // 2️⃣ Buscar el detalle de la devolución (activo específico)
        $detalle = DetalleDevolucion::where('id_devolucion', $id)
            ->where('id_activo', $request->id_activo)
            ->first();

        if (!$detalle) {
            return response()->json([
                'success' => false,
                'error' => 'El activo no se encuentra en esta devolución.'
            ], 404);
        }

        // Guardar la cantidad antes de eliminar
        $cantidadEliminada = $detalle->cantidad;

        // 3️⃣ Eliminar el detalle
        $detalle->delete();

        // 4️⃣ Respuesta exitosa con cantidad eliminada
        return response()->json([
            'success' => true,
            'message' => 'Activo eliminado correctamente de la devolución.',
            'cantidad_eliminada' => $cantidadEliminada
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'error' => 'Devolución no encontrada.'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
        ], 500);
    }
}


public function agregarActivo(Request $request, $id)
{
    try {
        // 1️⃣ Verificar devolución
        $devolucion = Devolucion::findOrFail($id);
        if (!$devolucion->isEditable()) {
            return response()->json([
                'success' => false,
                'error' => 'No se puede modificar esta devolución (FINALIZADA o ELIMINADA).'
            ], 422);
        }

        // 2️⃣ Buscar el activo
        $activo = Activo::activos()->findOrFail($request->id_activo);

        // 3️⃣ Buscar detalle inventario
        $detalleInventario = DetalleInventario::where('id_activo', $activo->id_activo)
            ->where('estado_actual', '!=', 'eliminado')
            ->first();

        if (!$detalleInventario) {
            return response()->json([
                'success' => false,
                'error' => 'No se encontró el detalle de inventario para este activo.'
            ], 404);
        }

        // 4️⃣ Evitar duplicados
        if (DetalleDevolucion::where('id_devolucion', $id)->where('id_activo', $activo->id_activo)->exists()) {
            return response()->json([
                'success' => false,
                'error' => 'El activo ya fue agregado a esta devolución.'
            ], 422);
        }

        // 5️⃣ Validar cantidad enviada
        $cantidadSolicitada = (int) $request->cantidad;
        if ($cantidadSolicitada <= 0) {
            return response()->json([
                'success' => false,
                'error' => 'La cantidad debe ser mayor a 0.'
            ], 422);
        }

        // 6️⃣ Calcular cantidad disponible (restante real)
        $cantidadUsadaEnOtros = DetalleDevolucion::where('id_activo', $activo->id_activo)
            ->where('id_devolucion', '!=', $id)
            ->sum('cantidad');

        $cantidadDisponible = max(0, $detalleInventario->cantidad - $cantidadUsadaEnOtros);

        // 7️⃣ Validar disponibilidad
        if ($cantidadSolicitada > $cantidadDisponible) {
            return response()->json([
                'success' => false,
                'error' => "Cantidad solicitada no disponible. Solo hay {$cantidadDisponible} unidades disponibles."
            ], 422);
        }

        // 8️⃣ Crear el detalle con la cantidad solicitada
        $detalle = DetalleDevolucion::create([
            'id_devolucion' => $id,
            'id_activo' => $activo->id_activo,
            'cantidad' => $cantidadSolicitada,
            'observaciones' => $request->observaciones ?? ''
        ]);

        return response()->json([
            'success' => true,
            'detalle' => $detalle,
            'activo' => $activo,
            'message' => "Activo agregado correctamente con {$cantidadSolicitada} unidades."
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'error' => 'Devolución o activo no encontrado.'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
        ], 500);
    }
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🧩 Reglas de validación
        $rules = [
            'numero_documento' => ['required', 'regex:/^\d+$/', 'max:3'],
            'gestion' => ['required', 'digits:4'],
            'fecha' => 'required|date|after_or_equal:' . $request->gestion . '-01-01|before_or_equal:' . $request->gestion . '-12-31',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'observaciones' => 'nullable|string|max:100',
        ];

        $messages = [
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.regex' => 'El número de documento solo puede contener números.',
            'numero_documento.max' => 'El número de documento no puede superar 3 dígitos.',
            'gestion.required' => 'La gestión es obligatoria.',
            'gestion.digits' => 'La gestión debe tener exactamente 4 dígitos.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al año de la gestión.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior al año de la gestión.',
            'id_servicio.required' => 'Debe seleccionar un servicio.',
            'id_servicio.exists' => 'El servicio seleccionado no es válido.',
            'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
        ];

        // 🔍 Validar datos
        $validator = Validator::make($request->all(), $rules, $messages);

        // 🔢 Formatear número y gestión
        $numero = str_pad((int) $request->numero_documento, 3, '0', STR_PAD_LEFT);
        $gestion = (int) $request->gestion;

        // 🚫 Verificar si ya existe una devolución con ese número y gestión
        $existe = Devolucion::where('numero_documento', $numero)
            ->where('gestion', $gestion)
            ->where('estado', '!=', 'ELIMINADO')
            ->exists();

        if ($existe) {
            $validator->errors()->add('numero_documento', 'El número de documento ya existe para esta gestión.');
        }

        // ❌ Si hay errores, retornar sin guardar
        if ($validator->fails() || $existe) {
            return response()->json([
                'success' => false,
                'message' => $existe
                    ? 'No se puede registrar: el número de documento ya existe para esta gestión.'
                    : 'Existen errores en el formulario.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // 🧭 Obtener responsable del servicio seleccionado
        $servicio = Servicio::with('responsable')->find($request->id_servicio);
        $id_responsable = $servicio->responsable->id_responsable ?? null;

        // ✅ Crear la devolución
        $devolucion = Devolucion::create([
            'numero_documento' => $numero,
            'gestion' => $gestion,
            'fecha' => $request->fecha,
            'id_usuario' => auth()->id(),
            'id_servicio' => $request->id_servicio,
            'id_responsable' => $id_responsable,
            'observaciones' => $request->observaciones,
            'estado' => 'pendiente',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nueva Devolución registrada correctamente.',
            'data' => $devolucion,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $devolucion = Devolucion::findOrFail($id);
        return view('user.devolucion.show', compact('devolucion'));
    }
    public function tablaActivos($id)
    {
        $detalles = DetalleDevolucion::with('activo.unidad', 'activo.estado', 'activo.detalleInventario')
        ->where('id_devolucion', $id)
        ->get()
        ->map(function ($detalle) {
            $idActivo = $detalle->id_activo;

            $cantidadDisponible = $detalle->activo->detalleInventario->cantidad ?? 0;
            $cantidadUsada = DetalleDevolucion::where('id_activo', $idActivo)->sum('cantidad');
            $cantidadEnActa = $detalle->cantidad ?? 0;

            // Obtener todos los traslados donde aparece este mismo activo
            $actasInfo = DetalleDevolucion::where('id_activo', $idActivo)
                ->with('devolucion')
                ->get()
                ->map(function ($d) {
                    return [
                        'id_devolucion' => $d->id_devolucion,
                        'numero_documento' => $d->devolucion->numero_documento ?? null,
                        'cantidad' => $d->cantidad ?? 0,
                    ];
                });

            // Agregar propiedades dinámicas correctamente
            $detalle->setAttribute('cantidad_disponible', $cantidadDisponible);
            $detalle->setAttribute('cantidad_usada', $cantidadUsada);
            $detalle->setAttribute('cantidad_en_acta', $cantidadEnActa);
            $detalle->setAttribute('actas_info', $actasInfo);

            return $detalle;
        });

    return view('user.devolucion.parcial_activos', compact('detalles'));

    }



    public function generarNumeroAjax($gestion)
    {
        try {
            $numero = $this->generarNumeroDocumento($gestion);
            return response()->json([
                'success' => true,
                'numero' => $numero
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }











    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    // Traer la devolución y relaciones necesarias
    $devolucion = Devolucion::with([
        'responsable',
        'servicio'
    ])->findOrFail($id);

    // Datos para selects
    $usuarios = Usuario::all();       // Para responsables
    $servicios = Servicio::all();     // Para servicios
    $responsables = Responsable::all(); // Para selects de responsables si aplica

    return view('user.devolucion.parcial_editar', compact('devolucion', 'usuarios', 'servicios', 'responsables'));
}



    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    try {
        $devolucion = Devolucion::editable()->find($id);

        if (!$devolucion) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede modificar esta acta: está finalizada o eliminada.'
            ], 403);
        }

        $rules = [
            'numero_documento' => [
                'required',
                'regex:/^\d{1,20}$/',
                // Único por gestión, excluyendo el registro actual
                'unique:devoluciones,numero_documento,' . $id . ',id_devolucion,gestion,' . $request->gestion
            ],
            'gestion' => 'required|digits:4|integer',
            'fecha' => 'required|date|after_or_equal:' . $request->gestion . '-01-01|before_or_equal:' . $request->gestion . '-12-31',
            'observaciones' => 'nullable|string|max:100',
            'id_servicio' => 'required|exists:servicios,id_servicio',
        ];

        $messages = [
            'numero_documento.required' => 'El número de devolución es obligatorio.',
            'numero_documento.regex' => 'El número de devolución debe contener solo números.',
            'numero_documento.unique' => 'El número de documento ya existe para esta gestión.',
            'gestion.required' => 'La gestión es obligatoria.',
            'gestion.digits' => 'La gestión debe tener 4 dígitos.',
            'fecha.required' => 'Debe indicar una fecha.',
            'fecha.date' => 'La fecha no es válida.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior al año de la gestión.',
            'fecha.before_or_equal' => 'La fecha no puede ser posterior al año de la gestión.',
            'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
            'id_servicio.required' => 'Debe seleccionar un servicio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Existen errores en el formulario.',
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ Actualizar datos
        $devolucion->update([
            'numero_documento' => str_pad((int)$request->numero_documento, 3, '0', STR_PAD_LEFT),
            'gestion' => (int)$request->gestion,
            'fecha' => $request->fecha,
            'observaciones' => $request->observaciones ?? '',
            'id_servicio' => $request->id_servicio,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'La devolución ha sido actualizada correctamente.',
            'devolucion' => $devolucion
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error inesperado al actualizar: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Devolucion $devolucion)
    {
        //
    }
}
