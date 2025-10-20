<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Categoria;
use App\Models\DetalleInventario;
use App\Models\DetalleTraslado;
use App\Models\Inventario;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Traslado;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function prueba()
    {

        // Retornar vista con variables
        return view('user.prueba');
    }
    public function create()
    {
        $servicios = Servicio::all(); // para llenar selects

        // Determinar la gestión actual (sin Carbon, con PHP puro)
        $gestionActual = date('Y');

        // Generar número de documento disponible
        $numeroDisponible = $this->generarNumeroDocumento($gestionActual);

        // Retornar vista con variables
        return view('user.traslados.parcial_nuevo', compact('servicios', 'gestionActual', 'numeroDisponible'));
    }





    public function guardarTraslado(Request $request, $id)
    {
        $traslado = Traslado::find($id);
        if (!$traslado) {
            return response()->json([
                'success' => false,
                'message' => 'Traslado no encontrado.'
            ], 404);
        }

        if ($traslado->estado === 'finalizado') {
            return response()->json([
                'success' => false,
                'message' => 'Este traslado ya está finalizado.'
            ], 422);
        }

        // Buscar último inventario pendiente para el servicio destino y misma gestión
        $inventarioDestino = Inventario::where('id_servicio', $traslado->id_servicio_destino)
            ->where('gestion', $traslado->gestion)
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$inventarioDestino) {
            return response()->json([
                'success' => false,
                'message' => 'No existe inventario pendiente para el servicio destino en la gestión actual.'
            ], 422);
        }

        // Obtener detalles traslado
        $detallesTraslado = DetalleTraslado::where('id_traslado', $id)->get();

        if ($detallesTraslado->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No hay activos asociados a este traslado.'
            ], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($detallesTraslado as $detalle) {
                // Validar que el activo existe en el inventario origen (servicio origen) con estado activo o pendiente y cantidad suficiente
                $detalleInventarioOrigen = DetalleInventario::whereHas('inventario', function ($q) use ($traslado) {
                    $q->where('id_servicio', $traslado->id_servicio_origen)
                      ->where('gestion', $traslado->gestion)
                      ->where('estado', 'pendiente');
                })
                ->where('id_activo', $detalle->id_activo)
                ->where('cantidad', '>=', $detalle->cantidad)
                ->first();

                if (!$detalleInventarioOrigen) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "El activo ID {$detalle->id_activo} no está disponible en el inventario de origen o cantidad insuficiente."
                    ], 422);
                }

                // Reducir cantidad en inventario origen
                $detalleInventarioOrigen->cantidad -= $detalle->cantidad;
                if ($detalleInventarioOrigen->cantidad <= 0) {
                    $detalleInventarioOrigen->delete();
                } else {
                    $detalleInventarioOrigen->save();
                }

                // Agregar o actualizar detalle inventario destino
                $detalleInventarioDestino = DetalleInventario::firstOrNew([
                    'id_inventario' => $inventarioDestino->id_inventario,
                    'id_activo' => $detalle->id_activo,
                ]);
                $detalleInventarioDestino->estado_actual = 'activo'; // o pendiente según lógica
                $detalleInventarioDestino->cantidad = ($detalleInventarioDestino->cantidad ?? 0) + $detalle->cantidad;
                $detalleInventarioDestino->observaciones = $detalle->observaciones ?? '';
                $detalleInventarioDestino->save();

                // Finalmente eliminar el detalle traslado
                $detalle->delete();
            }

            // Cambiar estado traslado a finalizado
            $traslado->estado = 'finalizado';
            $traslado->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Traslado finalizado correctamente y activos movidos al inventario destino.',
                'data' => ['id_traslado' => $id]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al finalizar traslado: ' . $e->getMessage()
            ], 500);
        }
    }












    public function buscar(Request $request)
    {
        try {
            $query = Traslado::query()->noEliminados();

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

            if ($request->id_servicio_origen) {
                $query->where('id_servicio_origen', $request->id_servicio_origen);
            }

            if ($request->id_servicio_destino) {
                $query->where('id_servicio_destino', $request->id_servicio_destino);
            }

            $traslados = $query->orderBy('fecha', 'desc')->get();

            return view('user.traslados.parcial_resultados_busqueda', compact('traslados'));
        } catch (\Exception $e) {
            // \Log::error('Error en búsqueda de traslados: '.$e-_>getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar los traslados.' . $e
            ], 500);
        }
    }
    // public function buscarInventario(Request $request)
    // {
    //     try {
    //         $query = Activo::query()->activos();

    //         // Filtro por servicio (por ejemplo, si tienes activo relacionado con servicio)
    //         if ($request->id_servicio) {
    //             // Supongo que en la tabla activo tienes algún campo id_servicio o alguna relación
    //             // Si no, debes ajustar esto a la relación correcta
    //             $query->where('id_servicio', $request->id_servicio);
    //         }

    //         // Filtro por código (insensible a mayúsculas/minúsculas)
    //         if ($request->codigo_activo) {
    //             $codigo = $request->codigo_activo;
    //             $query->whereRaw('LOWER(codigo) LIKE ?', ['%' . strtolower($codigo) . '%']);
    //         }

    //         // Filtro por nombre
    //         if ($request->nombre_activo) {
    //             $nombre = $request->nombre_activo;
    //             $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($nombre) . '%']);
    //         }

    //         // Filtro por categoría
    //         if ($request->categoria_activo) {
    //             $categoria = $request->categoria_activo;
    //             // Puede ser por id o por nombre, ajusta según cómo envíes el filtro
    //             $query->whereHas('categoria', function ($q) use ($categoria) {
    //                 $q->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($categoria) . '%']);
    //             });
    //         }

    //         $activos = $query->orderBy('nombre')->get();

    //         return view('user.activos.parcial_resultados_busqueda', compact('activos'));
    //     } catch (\Exception $e) {
    //         // \Log::error('Error en búsqueda de activos: '.$e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Ocurrió un error al buscar los activos.'
    //         ], 500);
    //     }
    // }


    public function buscarActivos(Request $request)
    {

        try {
            // Consulta base de inventarios
            $inventariosQuery = Inventario::query();

            if ($request->filled('id_servicio_origen')) {
                $inventariosQuery->where('id_servicio', $request->id_servicio_origen);
            }

            $inventarios = $inventariosQuery->pluck('id_inventario');

            $detalleQuery = DetalleInventario::with(['activo', 'inventario'])
                ->whereIn('id_inventario', $inventarios)
                ->where('estado_actual', '!=', 'eliminado')
                ->whereHas('activo', function ($q) {
                    $q->soloActivos();
                });

            // Filtros opcionales
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

            $detalles = $detalleQuery->get();
            $idTrasladoActual = $request->id_traslado ?? null;

            // Recorrer resultados para agregar estado de disponibilidad y datos del traslado
            foreach ($detalles as $detalle) {
                $idActivo = $detalle->activo->id_activo ?? null;

                if (!$idActivo) {
                    $detalle->estado_asignacion = 'N/D';
                    $detalle->traslado_info = null;
                    continue;
                }

                // Verificar si el activo está en otro traslado
                $trasladoOtro = DetalleTraslado::with('traslado') // trae relación del traslado
                    ->where('id_activo', $idActivo)
                    ->whereHas('activo', function ($q) {
                        $q->soloActivos();
                    })
                    ->when($idTrasladoActual, function ($q) use ($idTrasladoActual) {
                        $q->where('id_traslado', '!=', $idTrasladoActual);
                    })
                    ->first(); // solo trae uno, si quieres todos puedes usar ->get()
                // dd($trasladoOtro->traslado->id_traslado);
                // dd($request->id_traslado ?? 'ec');
                // Verificar si está en el traslado actual
                $trasladoActual = null;
                if ($idTrasladoActual) {
                    $trasladoActual = DetalleTraslado::with('traslado')
                        ->where('id_activo', $idActivo)
                        ->where('id_traslado', $idTrasladoActual)
                        ->whereHas('activo', function ($q) {
                            $q->soloActivos();
                        })
                        ->first();
                }

                // Asignar estado temporal y detalles del traslado
                if ($trasladoActual) {
                    $detalle->estado_asignacion = 'Activo ya agregado en esta acta';
                    $detalle->traslado_info = [
                        'id_traslado' => $trasladoActual->id_traslado,
                        'numero' => $trasladoActual->traslado->numero ?? null,
                        'otros' => $trasladoActual->traslado // puedes mandar toda la info
                    ];
                } elseif ($trasladoOtro) {
                    $detalle->estado_asignacion = 'Activo ya agregado en otro acta';
                    $detalle->traslado_info = [
                        'id_traslado' => $trasladoOtro->traslado->id_traslado,
                        'numero' => $trasladoOtro->traslado->numero_documento ?? null,
                        // 'otros' => $trasladoOtro->traslado
                    ];
                    // dd($trasladoOtro->traslado);
                } else {
                    $detalle->estado_asignacion = 'Disponible';
                    $detalle->traslado_info = null;
                }
            }

            return view('user.traslados.parcial_resultados_inventario', compact('detalles'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al buscar en el inventario: ' . $e->getMessage()
            ], 500);
        }
    }





    public function mostrarBuscar()
    {
        try {
            $servicios = Servicio::all(); // Para llenar los selects
            return view('user.traslados.parcial_buscar', compact('servicios'));
        } catch (\Exception $e) {
            // Opcional: loguear el error
            // \Log::error('Error al cargar parcial de búsqueda: '.$e->getMessage());

            // Si quieres devolver JSON (para AJAX)
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
                ], 500);
            }

            // Para petición normal, devolver vista con mensaje de error
            return view('user.traslados.parcial_buscar')->with(['message' => 'Ocurrió un error al cargar la vista de búsqueda.']);
        }
    }
    public function mostrarInventario()
    {
        try {
            // $servicios = Servicio::all();     // Para llenar selects de servicios
            $categorias = Categoria::all();   // Para llenar selects de categorías

            return view('user.traslados.parcial_inventario', compact('categorias'));
        } catch (\Exception $e) {
            // Opcional: loguear el error
            // \Log::error('Error al cargar parcial de búsqueda: '.$e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ocurrió un error al cargar la vista de búsqueda.'
                ], 500);
            }

            return view('user.traslados.parcial_inventario')->with(['message' => 'Ocurrió un error al cargar la vista de búsqueda.']);
        }
    }




    // use Illuminate\Database\QueryException;

    public function store(Request $request)
    {
       $rules = [
    'numero_documento' => ['required', 'regex:/^\d+$/', 'max:3'],
    'gestion' => ['required', 'digits:4'],
    'fecha' => 'required|date|after_or_equal:' . $request->gestion . '-01-01|before_or_equal:' . $request->gestion . '-12-31',
    'id_servicio_origen' => 'required|exists:servicios,id_servicio',
    'id_servicio_destino' => 'required|exists:servicios,id_servicio|different:id_servicio_origen',
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
    'id_servicio_origen.required' => 'Debe seleccionar un servicio de origen.',
    'id_servicio_destino.required' => 'Debe seleccionar un servicio de destino.',
    'id_servicio_destino.different' => 'El servicio destino no puede ser igual al origen.',
    'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
];


        $validator = Validator::make($request->all(), $rules, $messages);

        // 🔢 Formatear número y gestión
        $numero = str_pad((int) $request->numero_documento, 3, '0', STR_PAD_LEFT);
        $gestion = (int) $request->gestion;

        // 🚫 Verificar si ya existe ese número y gestión
        $existe = Traslado::where('numero_documento', $numero)
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

        // ✅ Si pasó todas las validaciones, guardar
        $traslado = Traslado::create([
            'numero_documento' => $numero,
            'gestion' => $gestion,
            'fecha' => $request->fecha,
            'id_usuario' => auth()->id(),
            'id_servicio_origen' => $request->id_servicio_origen,
            'id_servicio_destino' => $request->id_servicio_destino,
            'observaciones' => $request->observaciones,
            'estado' => 'pendiente',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Traslado guardado correctamente.',
            'data' => $traslado,
        ]);
    }









    // public function store(Request $request)
    // {
    //     try {
    //         // 1️⃣ Reglas y mensajes
    //         $rules = [
    //             'numero_documento' => ['required', 'regex:/^\d+$/', 'max:3'],
    //             'gestion' => 'required|numeric',
    //             'fecha' => 'required|date',
    //             'id_servicio_origen' => 'required|exists:servicios,id_servicio',
    //             'id_servicio_destino' => 'required|exists:servicios,id_servicio',
    //             'observaciones' => 'nullable|string|max:100',
    //         ];

    //         $messages = [
    //             'numero_documento.required' => 'El número de documento es obligatorio.',
    //             'numero_documento.regex' => 'El número de documento solo puede contener números.',
    //             'numero_documento.max' => 'El número de documento no puede superar 3 dígitos.',
    //             'gestion.required' => 'La gestión es obligatoria.',
    //             'fecha.required' => 'La fecha es obligatoria.',
    //             'id_servicio_origen.required' => 'Debe seleccionar un servicio de origen.',
    //             'id_servicio_destino.required' => 'Debe seleccionar un servicio de destino.',
    //             'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
    //         ];

    //         $validator = Validator::make($request->all(), $rules, $messages);

    //         // Verificar número de documento único por gestión (solo registros no eliminados)
    //         $numeroExiste = Traslado::where('numero_documento', $request->numero_documento)
    //             ->where('gestion', $request->gestion)
    //             ->where('estado', '!=', 'ELIMINADO')
    //             ->exists();

    //         if ($numeroExiste) {
    //             $validator->errors()->add('numero_documento', 'El número de documento ya existe para esta gestión.');
    //         }

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $validator->errors()->first() // solo primer mensaje
    //             ], 422);
    //         }

    //         // Verificar que origen y destino no sean iguales
    //         if ($request->id_servicio_origen == $request->id_servicio_destino) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'El servicio de origen y destino no pueden ser iguales.'
    //             ], 422);
    //         }

    //         // Guardar traslado
    //         $traslado = Traslado::create([
    //             'numero_documento' => $request->numero_documento,
    //             'gestion' => $request->gestion,
    //             'fecha' => $request->fecha,
    //             'id_usuario' => auth()->id(),
    //             'id_servicio_origen' => $request->id_servicio_origen,
    //             'id_servicio_destino' => $request->id_servicio_destino,
    //             'observaciones' => $request->observaciones,
    //             'estado' => 'ACTIVO',
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Traslado guardado correctamente.',
    //             'data' => $traslado
    //         ]);
    //     } catch (\Exception $e) {
    //         // Captura cualquier error y devuelve solo el mensaje
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Ocurrió un error: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }


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

    public function generarNumeroDocumento(string $gestion): string
    {
        $maxNumero = 999;

        $numerosExistentes = Traslado::where('gestion', $gestion)
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


    public function show($id)
    {
        $traslado = Traslado::findOrFail($id);
        return view('user.traslados.show', compact('traslado'));
    }
    public function detalleParcial($id)
    {
        $traslado = Traslado::with([
            'responsableOrigen',      // Responsable del servicio de origen
            'responsableDestino',     // Responsable del servicio de destino
            'servicioOrigen',         // Servicio de origen
            'servicioDestino',        // Servicio de destino
            // 'detalles.activo'         // Los activos del traslado
        ])->findOrFail($id);

        return view('user.traslados.parcial_traslado', compact('traslado'));
    }

    // Vista parcial de tabla de activos
    public function tablaActivos($id)
    {
        $detalles = DetalleTraslado::with('activo.unidad', 'activo.estado')
            ->where('id_traslado', $id)->get();
        return view('user.traslados.parcial_activos', compact('detalles'));
    }

    // Agregar activo al traslado
    public function agregarActivo(Request $request, $id)
    {
        try {
            // Traer traslado y verificar si está editable
            $traslado = Traslado::findOrFail($id);
            if (!$traslado->isEditable()) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se puede modificar este traslado (FINALIZADO o ELIMINADO).'
                ], 422);
            }

            // Buscar el activo (solo si está activo)
            $activo = Activo::activos()->findOrFail($request->id_activo);

            // Buscar cantidad desde detalle inventario
            $detalleInventario = DetalleInventario::where('id_activo', $activo->id_activo)
                ->where('estado_actual', '!=', 'eliminado')
                ->first();

            if (!$detalleInventario) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se encontró el detalle de inventario para este activo.'
                ], 404);
            }

            // Evitar duplicados en el traslado
            if (DetalleTraslado::where('id_traslado', $id)->where('id_activo', $activo->id_activo)->exists()) {
                return response()->json([
                    'success' => false,
                    'error' => 'El activo ya fue agregado a este traslado.'
                ], 422);
            }

            // Crear detalle con cantidad real
            $detalle = DetalleTraslado::create([
                'id_traslado' => $id,
                'id_activo' => $activo->id_activo,
                'cantidad' => $detalleInventario->cantidad, // 👈 cantidad real
                'observaciones' => $request->observaciones ?? ''
            ]);

            return response()->json([
                'success' => true,
                'detalle' => $detalle,
                'activo' => $activo,
                'message' => 'Activo agregado correctamente.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Traslado o activo no encontrado.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    // Editar cantidad u observaciones
    public function editarActivo(Request $request, $id)
    {
        $detalle = DetalleTraslado::where('id_traslado', $id)
            ->where('id_activo', $request->id_activo)
            ->first();

        if (!$detalle) {
            return response()->json(['error' => 'Detalle no encontrado'], 404);
        }

        // Validar longitud de observaciones
        if ($request->observaciones !== null) {
            if (strlen($request->observaciones) > 100) {
                return response()->json(['error' => 'El campo observaciones no puede tener más de 100 caracteres'], 422);
            }
            $detalle->observaciones = $request->observaciones;
        }

        if ($request->cantidad !== null) {
            $detalle->cantidad = $request->cantidad;
        }

        $detalle->save();

        return response()->json(['success' => true, 'detalle' => $detalle]);
    }

    // Eliminar activo
    public function eliminarActivo(Request $request, $id)
    {
        try {
            // 1️⃣ Verificar que el traslado exista
            $traslado = Traslado::findOrFail($id);

            // 2️⃣ Comprobar si está editable (pendiente)
            if (!$traslado->isEditable()) {
                return response()->json([
                    'success' => false,
                    'error' => 'No se puede eliminar activos de un traslado FINALIZADO o ELIMINADO.'
                ], 422);
            }
            // 3️⃣ Buscar el detalle del traslado (activo específico)
            $detalle = DetalleTraslado::where('id_traslado', $id)
                ->where('id_activo', $request->id_activo)
                ->first();

            // dd("traslado".$id. " detalle".$detalle);
            // dd($request->id_activo);
            if (!$detalle) {
                return response()->json([
                    'success' => false,
                    'error' => 'El activo no se encuentra en este traslado.'
                ], 404);
            }

            // 4️⃣ Eliminar el detalle
            $detalle->delete();

            // 5️⃣ Respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Activo eliminado correctamente del traslado.'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Traslado no encontrado.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Ocurrió un error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //   return view('user.traslados.registrar');
    // }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Traer el traslado y relaciones necesarias
        $traslado = Traslado::with([
            'responsableOrigen',
            'responsableDestino',
            'servicioOrigen',
            'servicioDestino'
        ])->findOrFail($id);

        // Datos para selects
        $usuarios = Usuario::all();       // Para responsables
        $servicios = Servicio::all();     // Para servicios
        $responsables = Responsable::all();     // Para servicios

        return view('user.traslados.parcial_editar', compact('traslado', 'usuarios', 'servicios', 'responsables'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $traslado = Traslado::editable()->find($id);

            if (!$traslado) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede modificar este acta: está finalizada o eliminada.'
                ], 403);
            }

            $rules = [
                'numero_documento' => [
                    'required',
                    'regex:/^\d{1,20}$/',
                    // Regla para que sea único por gestión, excluyendo el registro actual
                    'unique:traslados,numero_documento,' . $id . ',id_traslado,gestion,' . $request->gestion
                ],
                'gestion' => 'required|digits:4|integer',
                'fecha' => 'required|date|after_or_equal:' . $request->gestion . '-01-01|before_or_equal:' . $request->gestion . '-12-31',
                'observaciones' => 'nullable|string|max:100',
                'id_servicio_origen' => 'required|exists:servicios,id_servicio',
                'id_servicio_destino' => 'required|exists:servicios,id_servicio|different:id_servicio_origen',
            ];

            $messages = [
                'numero_documento.required' => 'El número de traslado es obligatorio.',
                'numero_documento.regex' => 'El número de traslado debe contener solo números.',
                'numero_documento.unique' => 'El número de documento ya existe para esta gestión.',
                'gestion.required' => 'La gestión es obligatoria.',
                'gestion.digits' => 'La gestión debe tener 4 dígitos.',
                'fecha.required' => 'Debe indicar una fecha.',
                'fecha.date' => 'La fecha no es válida.',
                'fecha.after_or_equal' => 'La fecha no puede ser anterior al año de la gestión.',
                'fecha.before_or_equal' => 'La fecha no puede ser posterior al año de la gestión.',
                'observaciones.max' => 'Las observaciones no pueden superar 100 caracteres.',
                'id_servicio_origen.required' => 'Debe seleccionar un servicio de origen.',
                'id_servicio_destino.required' => 'Debe seleccionar un servicio de destino.',
                'id_servicio_destino.different' => 'El servicio destino no puede ser igual al origen.',
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
            $traslado->update([
                'numero_documento' => str_pad((int)$request->numero_documento, 3, '0', STR_PAD_LEFT),
                'gestion' => (int)$request->gestion,
                'fecha' => $request->fecha,
                'observaciones' => $request->observaciones ?? '',
                'id_servicio_origen' => $request->id_servicio_origen,
                'id_servicio_destino' => $request->id_servicio_destino,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'El traslado ha sido actualizado correctamente.',
                'traslado' => $traslado
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
    public function destroy(Traslado $traslado)
    {
        //
    }
}
