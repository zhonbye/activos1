<?php

namespace App\Http\Controllers;

use App\Models\DetalleEntrega;
use App\Models\DetalleInventario;
use App\Models\Devolucion;
use App\Models\Docto;
use App\Models\Entrega;
use App\Models\Inventario;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Traslado;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EntregaController extends Controller
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
    // public function create()
    // {
    //     $ultimo = Entrega::orderBy('numero_documento', 'desc')->first();

    //     $numeroSiguiente = $ultimo ? str_pad(intval($ultimo->numero_documento) + 1, 3, '0', STR_PAD_LEFT) : '001';
    //     dd($ultimo->numero_documento, intval($ultimo->numero_documento), intval($ultimo->numero_documento) + 1, $numeroSiguiente);


    // //     $gestion = date('Y'); // o la gestión que quieras por defecto
    // // $numeroSiguiente = $this->obtenerSiguienteNumero($gestion);


    //     return view('user.entregas.registrar', [
    //         'numeroSiguiente' => $numeroSiguiente,
    //         // 'ubicaciones' => Ubicacion::all(),
    //         // 'responsables' => Responsable::all(),
    //         // 'servicios' => Servicio::all(),
    //     ]);
    // }
    //     public function create()
    // {
    //     $ultimo = Entrega::orderBy('numero_documento', 'desc')->first();
    //     $numeroSiguiente = $ultimo ? str_pad(intval($ultimo->numero_documento) + 1, 3, '0', STR_PAD_LEFT) : '001';

    //     return view('user.entregas.registrar', compact('numeroSiguiente'));
    // }

public function guardarActivos(Request $request)
{$data = json_decode($request->getContent(), true);

    // Si no hay JSON válido, usar input normal (form-data)
    if (!$data) {
        $data = $request->all();
    }

    $entregaId = $data['entrega_id'] ?? null;
    $activos = $data['activos'] ?? null;

    if (!$entregaId) {
        return response()->json([
            'message' => 'No se recibió el ID de la entrega.',
            'type' => 'danger'
        ], 400);
    }

    if (!$activos || !is_array($activos)) {
        return response()->json([
            'message' => 'No se recibieron activos válidos para guardar.',
            'type' => 'danger'
        ], 400);
    }

    $entrega = Entrega::find($entregaId);
    if (!$entrega) {
        return response()->json([
            'message' => 'No se encontró la entrega especificada.',
            'type' => 'danger'
        ], 404);
    }

    if ($entrega->estado === 'finalizado') {
        return response()->json([
            'message' => 'No se puede modificar una entrega que ya fue finalizada.',
            'type' => 'warning'
        ], 403);
    }
   try {
        DB::transaction(function() use ($entregaId, $activos) {

            // 1️⃣ Obtener todos los IDs actuales de detalle de esta entrega
            // Cambia 'id' por tu PK exacta en detalle_entregas
            $idsActuales = DetalleEntrega::where('id_entrega', $entregaId)
                            ->pluck('id_detalle_entrega') // o 'id_detalle_entrega' si ese es tu PK
                            ->toArray();

            $idsEnviado = []; // IDs que se enviaron desde la interfaz

            foreach ($activos as $activo) {
                // 2️⃣ Datos del activo enviado
                $idDetalle = $activo['id'] ?? null;         // ID del detalle en BD (si existe)
                $idActivo = $activo['id_activo'] ?? null;  // ID del activo
                $cantidad = $activo['cantidad'] ?? 0;      // cantidad
                $comentario = $activo['comentario'] ?? null; // ahora la variable es comentario

                // 3️⃣ Si existe el ID, actualizar registro existente
                if ($idDetalle && is_numeric($idDetalle)) {
                    DetalleEntrega::where('id_detalle_entrega', $idDetalle) // reemplaza 'id' si tu PK es diferente
                        ->update([
                            'cantidad' => $cantidad,
                            'observaciones' => $comentario
                        ]);
                    $idsEnviado[] = $idDetalle;

                // 4️⃣ Si no existe, insertar nuevo registro
                } elseif ($idActivo) {
                    DetalleEntrega::create([
                        'id_entrega' => $entregaId,
                        'id_activo' => $idActivo,
                        'cantidad' => $cantidad,
                        'observaciones' => $comentario,
                    ]);
                }
            }

            // 5️⃣ Eliminar registros que ya no están en la lista
            $idsEliminar = array_diff($idsActuales, $idsEnviado);
            if (!empty($idsEliminar)) {
                DetalleEntrega::whereIn('id_detalle_entrega', $idsEliminar)->delete();
            }

        });

        // 6️⃣ Respuesta exitosa
        return response()->json([
            'message' => 'Activos guardados correctamente',
            'type' => 'success'
        ]);

    } catch (\Exception $e) {
        // 7️⃣ Respuesta de error con mensaje claro
        return response()->json([
            'message' => 'Ocurrió un error al guardar los activos: ' . $e->getMessage(),
            'type' => 'danger'
        ], 500);
    }
    }

    public function activosDeEntrega($entregaId)
    {

        $detalles = DetalleEntrega::where('id_entrega', $entregaId)
            ->with(['activo' => function($query) {
                $query->with([
                    'unidad:id_unidad,nombre',
                    'estado:id_estado,nombre'
                ])->select(
                    'id_activo',
                    'codigo',
                    'nombre',
                    'detalle',
                    'cantidad',
                    'id_unidad',
                    'id_estado'
                );
            }])
            ->get();

        // Formatear para que solo mande lo necesario
        $resultado = $detalles->map(function($detalle) {
            $activo = $detalle->activo;
            return [
                'id_detalle' => $detalle->id_detalle_entrega,
                'id_activo' => $activo->id_activo,
                'codigo' => $activo->codigo,
                'cantidad' => $detalle->cantidad,
                'unidad' => $activo->unidad->nombre ?? 'N/D',
                'nombre' => $activo->nombre,
                'detalle' => $activo->detalle,
                'estado' => $activo->estado->nombre ?? 'N/D',
                        'comentario' => $detalle->observaciones ?? '', // <- Aquí se agrega

            ];
        });

        return response()->json($resultado);
}

public function guardarEntregaRealizada(Request $request)
{
    $data = json_decode($request->getContent(), true);

    if (!$data) {
        $data = $request->all();
    }

    $entregaId = $data['entrega_id'] ?? null;
    $inventarioId = $data['inventario_id'] ?? null;
    $activos = $data['activos'] ?? [];

    if (!$entregaId || !$inventarioId) {
        return response()->json([
            'message' => 'Faltan datos obligatorios: entrega_id o inventario_id.',
            'type' => 'danger'
        ], 400);
    }

    if (!is_array($activos) || empty($activos)) {
        return response()->json([
            'message' => 'No se recibieron activos válidos.',
            'type' => 'danger'
        ], 400);
    }

    // 🔍 Verificar estado actual de la entrega
    $entrega = Entrega::find($entregaId);
    if (!$entrega) {
        return response()->json([
            'message' => 'No se encontró la entrega especificada.',
            'type' => 'danger'
        ], 404);
    }

    if ($entrega->estado === 'finalizado') {
        return response()->json([
            'message' => 'No se puede modificar una entrega que ya fue finalizada.',
            'type' => 'warning'
        ], 403);
    }
    // 🔍 Verificar estado actual del inventario
$inventario = Inventario::find($inventarioId);
if (!$inventario) {
    return response()->json([
        'message' => 'No se encontró el inventario especificado.',
        'type' => 'danger'
    ], 404);
}

if ($inventario->estado === 'finalizado') {
    return response()->json([
        'message' => 'No se puede modificar un inventario que ya fue finalizado.',
        'type' => 'warning'
    ], 403);
}


    try {
        DB::transaction(function () use ($entregaId, $inventarioId, $activos, $entrega) {
            // 1️⃣ Guardar o actualizar los activos en detalle_entregas
            $idsActuales = DetalleEntrega::where('id_entrega', $entregaId)
                ->pluck('id_detalle_entrega')
                ->toArray();

            $idsEnviados = [];

            foreach ($activos as $activo) {
                $idDetalle = $activo['id'] ?? null;
                $idActivo = $activo['id_activo'] ?? null;
                $cantidad = $activo['cantidad'] ?? 0;
                $comentario = $activo['comentario'] ?? null;

                if ($idDetalle && is_numeric($idDetalle)) {
                    DetalleEntrega::where('id_detalle_entrega', $idDetalle)
                        ->update([
                            'cantidad' => $cantidad,
                            'observaciones' => $comentario
                        ]);
                    $idsEnviados[] = $idDetalle;
                } elseif ($idActivo) {
                    DetalleEntrega::create([
                        'id_entrega' => $entregaId,
                        'id_activo' => $idActivo,
                        'cantidad' => $cantidad,
                        'observaciones' => $comentario,
                    ]);
                }

                // 2️⃣ Insertar o actualizar en detalle_inventarios
                DetalleInventario::updateOrCreate(
                    [
                        'id_inventario' => $inventarioId,
                        'id_activo' => $idActivo
                    ],
                    [
                        'cantidad' => $cantidad,
                        'observaciones' => $comentario,
                        'estado_actual' => 'nuevo'
                            // 'estado_actual' => $activo['id_estado']
                    ]
                );
            }

            // 3️⃣ Eliminar detalles de entrega no enviados
            $idsEliminar = array_diff($idsActuales, $idsEnviados);
            if (!empty($idsEliminar)) {
                DetalleEntrega::whereIn('id_detalle_entrega', $idsEliminar)->delete();
            }

            // 4️⃣ Marcar entrega como finalizada
            $entrega->estado = 'finalizado'; // cambia a número si usas estado = 2 por ejemplo
            $entrega->save();
        });

        return response()->json([
            'message' => 'Entrega finalizada y activos registrados correctamente.',
            'type' => 'success'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al guardar: ' . $e->getMessage(),
            'type' => 'danger'
        ], 500);
    }
}



    // public function storeDetalles(Request $request)
    // {
    //     $request->validate([
    //         'id_entrega' => 'required|exists:entregas,id_entrega',
    //         'id_inventario' => 'required|exists:inventarios,id_inventario',
    //         'activos' => 'required|array|min:1',
    //         'activos.*.id' => 'required|exists:activos,id_activo',
    //         'activos.*.cantidad' => 'required|integer|min:1',
    //     ], [
    //         'activos.required' => 'Debes proporcionar al menos un activo.',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $idEntrega = $request->id_entrega;
    //         $idInventario = $request->id_inventario;
    //         $activos = $request->activos;

    //         // 1. Eliminar detalles anteriores
    //         DetalleEntrega::where('id_entrega', $idEntrega)->delete();

    //         // 2. Insertar nuevos en detalle_entrega y detalle_inventario
    //         foreach ($activos as $item) {
    //             DetalleEntrega::create([
    //                 'id_entrega' => $idEntrega,
    //                 'id_activo' => $item['id'],
    //                 'cantidad' => $item['cantidad'],
    //                 'observaciones' => null
    //             ]);

    //             DetalleInventario::create([
    //                 'id_inventario' => $idInventario,
    //                 'id_activo' => $item['id'],
    //                 'cantidad' => $item['cantidad'],
    //                 'observaciones' => null
    //             ]);
    //         }
    //         Entrega::where('id_entrega', $idEntrega)->first()->update(['estado' => 'finalizado']);

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Activos vinculados correctamente a la entrega e inventario.'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al guardar los detalles: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }











    public function generarNumeroDocumento(string $gestion): string
    {
        $maxNumero = 999;

$numerosExistentes = Entrega::where('gestion', $gestion)
        ->where('estado', '!=', 'eliminado') // excluye eliminados
        ->pluck('numero_documento')
        ->toArray();

    $numerosExistentesSet = array_flip($numerosExistentes);

    for ($i = 1; $i <= $maxNumero; $i++) {
        $numeroFormateado = str_pad($i, 3, '0', STR_PAD_LEFT);
        if (!isset($numerosExistentesSet[$numeroFormateado])) {
            return $numeroFormateado;
        }
    }

    throw new \Exception('No hay números disponibles para la gestión ' . $gestion);
    }
   public function getDatosActa(Request $request)
{
    try {
        $gestion = $request->input('gestion');
        $numero = $request->input('numero_documento');

        if ($gestion && $numero) {
            // Buscar acta según gestión y número
            $entrega = Entrega::with(['servicio', 'responsable'])
                ->where('estado', '!=', 'eliminado')
                ->where('gestion', $gestion)
                ->where('numero_documento', $numero)
                ->first();

            if (!$entrega) {
                return response()->json(['error' => 'No se encontró acta con esos datos.'], 404);
            }
        } else {
            // No envió parámetros, devolver última entrega
            $entrega = Entrega::with(['servicio', 'responsable'])
                ->latest('created_at')
                ->first();

            if (!$entrega) {
                return response()->json(['error' => 'No hay entregas registradas aún.'], 404);
            }
        }

        // Datos básicos de la entrega
        $datosEntrega = [
            'id_entrega'        => $entrega->id_entrega,
            'numero_documento'  => $entrega->numero_documento,
            'gestion'           => $entrega->gestion,
            'fecha'             => $entrega->fecha,
            'id_servicio'       => $entrega->id_servicio,
            'nombre_servicio'   => $entrega->servicio->nombre ?? 'N/D',
            'id_responsable'    => $entrega->id_responsable,
            'nombre_responsable'=> $entrega->responsable->nombre ?? 'N/D',
            'observaciones'     => $entrega->observaciones,
            'estado'            => $entrega->estado,
        ];

        return response()->json([
            'datosEntrega' => $datosEntrega
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error interno: ' . $e->getMessage()
        ], 500);
    }
}


    public function createEntrega()
    {
        $servicios = Servicio::all();

        // Usamos el método para obtener datos (sin parámetros para que traiga último)
        // $response = $this->getDatosActa(new \Illuminate\Http\Request());

        // if ($response->getStatusCode() != 200) {
        //     // No hay datos, enviar variables vacías
        //     $datosEntrega = [];
        //     $detallesActivos = collect();
        // } else {
        //     $json = $response->getData();
        //     $datosEntrega = (array) $json->datosEntrega;
        //     $detallesActivos = collect($json->detallesActivos);
        // }
$ultimoNumero = Entrega::latest('created_at')->value('numero_documento');

        return view('user.entregas.realizar', compact('ultimoNumero'));
    }




    public function create()
    {
        // $ultimo = Docto::orderBy('id_docto', 'desc')->first();
        // $numeroSiguiente = $ultimo ? str_pad($ultimo->numero + 1, 3, '0', STR_PAD_LEFT) : '001';
    //     $gestion = date('Y'); // o la gestión que quieras por defecto
    // $numeroSiguiente = $this->obtenerSiguienteNumero($gestion);


        // return view('user.actas.registrar', [
        //     'numeroSiguiente' => $numeroSiguiente,
        //     'ubicaciones' => Ubicacion::all(),
        //     'responsables' => Responsable::all(),
        //     'servicios' => Servicio::all(),
        // ]);
        $servicios = Servicio::all(); // trae todos los servicios con id_responsable
        $numeroSiguiente = $this->generarNumeroDocumento('2025');
        return view('user.entregas.registrar', compact('numeroSiguiente', 'servicios'));
    }
    // public function mostrarEntrega(Request $request)
    // {
    //     $numeroDocumento = $request->input('numero_documento');
    //     $gestion = $request->input('gestion');

    //     // Obtener todos los servicios (para dropdown o información)
    //     $servicios = Servicio::all();

    //     if ($numeroDocumento && $gestion) {
    //         // Buscar entrega según número de documento y gestión
    //         $entrega = Entrega::where('numero_documento', $numeroDocumento)
    //             ->where('gestion', $gestion)
    //             ->first();
    //     } else {
    //         // Obtener la última entrega registrada (por ejemplo, la más reciente)
    //         $entrega = Entrega::latest('created_at')->first();
    //     }

    //     if (!$entrega) {
    //         // Si no hay ninguna entrega, preparar para nueva entrega sin datos previos
    //         $numeroSiguiente = $this->generarNumeroDocumento(date('Y'));
    //         return view('user.entregas.realizar', compact('numeroSiguiente', 'servicios'));
    //     }

    //     // Obtener datos básicos de la entrega
    //    $datosEntrega = [
    //             'id_entrega' => $entrega->id_entrega,
    //             'numero_documento' => $entrega->numero_documento,
    //             'gestion'          => $entrega->gestion,
    //             'fecha'            => $entrega->fecha,
    //             'id_servicio'      => $entrega->id_servicio,
    //             'nombre_servicio'  => $entrega->servicio->nombre ?? 'N/D',
    //             'id_responsable'   => $entrega->id_responsable,
    //             'nombre_responsable' => $entrega->responsable->nombre ?? 'N/D',
    //             'observaciones'    => $entrega->observaciones,
    //             'estado'    => $entrega->estado,
    //         ];

    //     // Obtener nombre del responsable
    //     $responsable = Responsable::find($entrega->id_responsable);
    //     $datosEntrega['nombre_responsable'] = $responsable ? $responsable->nombre : 'N/A';

    //     // Obtener nombre del servicio
    //     $servicio = Servicio::find($entrega->id_servicio);
    //     $datosEntrega['nombre_servicio'] = $servicio ? $servicio->nombre : 'N/A';

    //     // Obtener detalles (activos) relacionados a esa entrega
    //     $detallesActivos = DetalleEntrega::where('id_entrega', $entrega->id_entrega)
    //         ->with('activo') // si tienes relación definida para traer datos del activo
    //         ->get();

    //     return view('user.entregas.realizar', compact('datosEntrega', 'servicios', 'detallesActivos'));
    // }


   // use Illuminate\Http\Request;  <-- Asegúrate de importar esto

public function getDocto(Request $request)
{
    try {
        $gestion = $request->query('gestion');

        if (!$gestion) {
            return response()->json(['error' => 'El parámetro "gestion" es requerido.'], 400);
        }

        $maxNumero = 999;

        // Obtiene todos los números de documento existentes para esa gestión
        $numerosExistentes = Entrega::where('gestion', $gestion)
            ->pluck('numero_documento')
            ->toArray();

        $numerosExistentesSet = array_flip($numerosExistentes);

        // Busca el primer número libre entre 001 y 999
        for ($i = 1; $i <= $maxNumero; $i++) {
            $numeroFormateado = str_pad($i, 3, '0', STR_PAD_LEFT);
            if (!isset($numerosExistentesSet[$numeroFormateado])) {
                return response()->json(['numero' => $numeroFormateado]);
            }
        }

        // Si no hay ningún número libre
        return response()->json([
            'error' => 'No hay números disponibles para la gestión ' . $gestion
        ], 500);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error interno: ' . $e->getMessage()
        ], 500);
    }
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'numero_documento' => 'required|string|max:10|unique:entregas,numero_documento',
            'gestion' => 'required|integer|min:2000|max:2100',
            'fecha' => 'required|date',
            'id_responsable' => 'required|exists:responsables,id_responsable',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'observaciones' => 'nullable|string|max:100',
        ], [
            'numero_documento.required' => 'El número de documento es obligatorio.',
            'numero_documento.unique' => 'El número de documento ya está en uso.',
            'gestion.required' => 'La gestión es obligatoria.',
            'gestion.integer' => 'La gestión debe ser un número entero.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'id_responsable.required' => 'Debe seleccionar un responsable.',
            'id_responsable.exists' => 'El responsable no existe.',
            'id_servicio.required' => 'Debe seleccionar un servicio.',
            'id_servicio.exists' => 'El servicio no existe.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Errores de validación en los campos.'
            ], 422);
        }

        try {
            $validated = $validator->validated();

            $entrega = Entrega::create([
                'numero_documento' => $validated['numero_documento'],
                'gestion' => $validated['gestion'],
                'fecha' => $validated['fecha'],
                'id_usuario' => auth()->id(), // usuario autenticado
                'id_responsable' => $validated['id_responsable'],
                'id_servicio' => $validated['id_servicio'],
                'observaciones' => $validated['observaciones'] ?? null,
                'estado' => "pendiente",
            ]);
            // Si tienes método para generar siguiente número según gestión:
            $numeroSiguiente = $this->generarNumeroDocumento(strval($validated['gestion'])) ?? ' error';

            return response()->json([
                'success' => true,
                'message' => 'Acta creada correctamente.',
                'entrega_id' => $entrega->id_entrega,
                'numeroSiguiente' => $numeroSiguiente
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el acta: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Entrega $entrega)
    {
        //
    }
    public function buscarActaPorTipo($tipo, $numero, $gestion)
    {
        $tipo = strtolower($tipo);
        $acta = null;
        $id = null;

        switch ($tipo) {
            case 'entrega':
                $acta = Entrega::where('numero_documento', $numero)
                    ->activas()
                    ->where('gestion', $gestion)
                    ->first();
                if ($acta) {
                    $id = $acta->id_entrega;  // O el nombre correcto de tu PK en la tabla entregas
                }
                break;

            case 'devolucion':
                $acta = Devolucion::where('numero_documento', $numero)
                    ->where('gestion', $gestion)
                    ->first();
                if ($acta) {
                    $id = $acta->id_devolucion;  // Ajusta al nombre correcto PK
                }
                break;

            case 'traslado':
                $acta = Traslado::where('numero_documento', $numero)
                    ->where('gestion', $gestion)
                    ->first();
                if ($acta) {
                    $id = $acta->id_traslado;  // Ajusta al nombre correcto PK
                }
                break;

            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de acta no válido'
                ], 400);
        }

        if (!$acta) {
            return response()->json([
                'success' => false,
                'message' => 'Acta no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'acta' => [
                'id' => $id,
                'numero' => $acta->numero_documento,
                'gestion' => $acta->gestion,
                'estado' => $acta->estado,
                'fecha' => $acta->fecha,
                'tipo' => $tipo,
                'detalle' => $acta->observaciones ?? '',
            ]
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entrega $entrega)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entrega $entrega)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entrega $entrega)
    {
        //
    }
}
