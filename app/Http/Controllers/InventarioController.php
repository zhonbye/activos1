<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\DetalleInventario;
use App\Models\Estado;
use App\Models\Inventario;
use App\Models\Responsable;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function consultar()
    // {
    //     $servicios = Servicio::orderBy('nombre')->get();
    //     $responsables = Responsable::orderBy('nombre')->get();

    //     // Carga los 20 primeros sin filtros
    //     $inventarios = Inventario::orderBy('fecha', 'desc')->paginate(20);

    //     return view('user.inventario.consultar', compact('inventarios', 'servicios', 'responsables'));
    // }



public function actualizarDetalles(Request $request)
{
    $request->validate([
        'id_detalle_inventario' => 'required|integer',
        'estado_actual' => 'required',
        'observaciones' => 'nullable|string'
    ]);

    $detalle = DetalleInventario::find($request->id_detalle_inventario);

    if (!$detalle) {
        return response()->json(['error' => 'Detalle no encontrado'], 404);
    }

    $detalle->estado_actual = $request->estado_actual;
    $detalle->observaciones = $request->observaciones;
    $detalle->save();

    return response()->json(['success' => true]);
}




    public function actualizar(Request $request)
{
    $request->validate([
        'id_inventario_actualizar' => 'required|integer',
        'id_inventario_original' => 'required|integer'
    ]);
        if (!$request->filled('id_inventario_actualizar')) {
        return response()->json([
            'status' => 'error',
            'message' => 'El inventario pendiente no fue recibido.'
        ], 400);
    }

    if (!$request->filled('id_inventario_original')) {
        return response()->json([
            'status' => 'error',
            'message' => 'El inventario vigente no fue recibido.'
        ], 400);
    }

    $id_inventario_actualizar = $request->id_inventario_actualizar;
    $idOriginal = $request->id_inventario_original;

    DB::beginTransaction();

    try {

        // ================================
        // 1. INVENTARIO A ACTUALIZAR
        // ================================
        $inventario = Inventario::find($id_inventario_actualizar);

        if (!$inventario) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'El inventario solicitado no existe.'
            ], 404);
        }

        if ($inventario->estado !== 'pendiente') {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Solo se puede actualizar un inventario con estado pendiente.'
            ], 400);
        }


        // ================================
        // 2. INVENTARIO ORIGINAL
        // ================================
        $invOriginal = Inventario::find($idOriginal);

        if (!$invOriginal) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'El inventario original no existe.'
            ], 404);
        }

        if ($invOriginal->estado !== 'vigente') {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'El inventario original debe estar en estado vigente.'
            ], 400);
        }

        // Verificar si está vacío el inventario original
        $detalleOriginal = DetalleInventario::where('id_inventario', $idOriginal)->count();

        if ($detalleOriginal == 0) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'El inventario vigente está vacío. No se puede continuar.'
            ], 400);
        }


        // ================================
        // 3. VERIFICAR DETALLE INVENTARIO NUEVO
        // ================================
        $detalleNuevo = DetalleInventario::where('id_inventario', $id_inventario_actualizar)->count();

        if ($detalleNuevo == 0) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'El inventario que intenta actualizar está vacío.'
            ], 400);
        }


        // ================================
        // 4. VERIFICAR CAMBIO DE RESPONSABLE
        // ================================
        $idServicio = $inventario->id_servicio;
        $idResponsableInventario = $inventario->id_responsable;

        $servicio = Servicio::find($idServicio);

        if (!$servicio) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'El servicio relacionado al inventario no existe.'
            ], 404);
        }

        if ($servicio->id_responsable != $idResponsableInventario) {
            // Actualizar responsable
            $servicio->id_responsable = $idResponsableInventario;
            $servicio->save();

            $mensajeResp = "El responsable del servicio ha sido actualizado.";
        } else {
            $mensajeResp = "El responsable del servicio no cambió.";
        }


        // ================================
        // 5. ACTUALIZAR ESTADOS
        // ================================
        $invOriginal->estado = 'finalizado';
        $invOriginal->save();

        $inventario->estado = 'vigente';
        $inventario->save();






// ================================
// 6. ACTUALIZAR ESTADOS DE ACTIVOS SEGÚN DETALLE INVENTARIO
// ================================

// Buscar todos los detalles del inventario actualizado
$detalles = DetalleInventario::where('id_inventario', $id_inventario_actualizar)->get();

foreach ($detalles as $det) {

    // Obtener el texto del estado_actual (puede venir en may/min)
    $estadoTexto = trim($det->estado_actual);

    // Buscar el estado en la tabla estados
    $estadoBD = Estado::whereRaw('LOWER(nombre) = ?', [strtolower($estadoTexto)])->first();

    if ($estadoBD) {
        // Actualizar el activo asociado
        Activo::where('id_activo', $det->id_activo)
            ->update([
                'id_estado' => $estadoBD->id_estado
            ]);
    }
}









        DB::commit();

        return response()->json([
            'status' => 'success',
            'mensaje' => 'Inventario actualizado correctamente.',
            'detalle' => $mensajeResp
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'mensaje' => 'Ocurrió un error inesperado.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function actualizarResponsable(Request $request)
{
    // VALIDACIÓN
    $validated = $request->validate([
        'inventario_id'  => 'required|exists:inventarios,id_inventario',
        'id_responsable' => 'required|exists:responsables,id_responsable',
    ], [
        'inventario_id.required'  => 'No se encontró el inventario.',
        'inventario_id.exists'    => 'El inventario indicado no es válido.',
        
        'id_responsable.required' => 'Debe seleccionar un responsable.',
        'id_responsable.exists'   => 'El responsable seleccionado no es válido.',
    ]);

    try {

        // OBTENER INVENTARIO
        $inventario = Inventario::findOrFail($validated['inventario_id']);

        // ACTUALIZAR RESPONSABLE
        $inventario->id_responsable = $validated['id_responsable'];
        $inventario->save();

        return response()->json([
            'message'    => 'Responsable actualizado correctamente.',
            'inventario' => $inventario
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al actualizar el responsable.',
            'error'   => $e->getMessage()
        ], 500);
    }
}


    public function detalle($id)
    {
        // Traer inventario con relaciones
        $inventario = Inventario::with(['usuario', 'responsable', 'servicio', 'detalles.activo'])->findOrFail($id);

        $idServicio = $inventario->id_servicio;

        // Buscar inventario pendiente de este servicio
    $inventarioPendiente = Inventario::where('id_servicio', $idServicio)
                                    ->where('estado', 'pendiente')
                                    ->orderBy('created_at', 'desc')
                                    ->first();

    // Ver si encontró algo
    // dd($inventarioPendiente);

        // Construir tabla de detalles
        $tabla = '';
        foreach ($inventario->detalles as $i => $detalle) {

            $tabla .= '<tr>';
            if ($detalle->activo->estado_situacional === 'baja') {
        
                $tabla .= '<tr class="table-danger bg-danger">'; 
            }
            $tabla .= '<td>'.($i+1).'</td>';
            $tabla .= '<td>'.$detalle->activo->codigo.'</td>';
            $tabla .= '<td>'.$detalle->activo->nombre.'</td>';
            $tabla .= '<td>'.$detalle->activo->detalle.'</td>';
            $tabla .= '<td>'.$detalle->estado_actual.'</td>';
            $tabla .= '<td>'.$detalle->observaciones.'</td>';
            $tabla .= '<td>';


            if ($detalle->activo->estado_situacional === 'baja') {
        $tabla .= '
            <button class="btn btn-sm btn-primary ver-activo-btn" 
                    title="Ver detalles del activo"
                    data-id="'.$detalle->activo->id_activo.'">
                <i class="bi bi-eye"></i>
            </button>
        ';
    } else {
            // Botón VER (siempre)
            $tabla .= '
                <button class="btn btn-sm btn-primary  ver-activo-btn" 
                        title="Ver detalles del activo"
                        data-id="'.$detalle->activo->id_activo.'">
                    <i class="bi bi-eye"></i>
                </button>
            ';

            if ($inventario->estado == 'vigente') {
                $yaEnPendiente = false;
                if ($inventarioPendiente) {
                    $yaEnPendiente = DetalleInventario::where('id_inventario', $inventarioPendiente->id_inventario)
                                        ->where('id_activo', $detalle->id_activo)
                                        ->exists();
                }
    $tabla .= '
                    <button class="btn btn-sm btn-dark baja-activo-btn ms-1" data-bs-toggle="modal" 
            data-bs-target="#modalDarBaja"
                            title="Dar de baja este activo"
                            data-id="'.$detalle->activo->id_activo.'">
                        <i class="bi bi-arrow-down-circle"></i>
                    </button>
                ';
                // Mostrar ambos botones siempre pero desactivar según condición
                $tabla .= '
                <button class="btn btn-sm btn-danger regresar-activo-btn ms-1" 
                        title="Regresar activo" '.(!$yaEnPendiente ? 'disabled' : '').'
                        data-id="'.$detalle->activo->id_activo.'">
                    <i class="bi bi-arrow-left-circle"></i>
                </button>
                    <button class="btn btn-sm btn-success mover-activo-btn ms-1" 
                            title="Mover activo" '.($yaEnPendiente ? 'disabled' : '').'
                            data-id="'.$detalle->activo->id_activo.'">
                        <i class="bi bi-arrow-right-circle"></i>
                    </button>
                ';

                // Botón DAR DE BAJA (siempre en vigente)
            
            }

            $tabla .= '</td>';
            $tabla .= '</tr>';
        }
        }

        return response()->json([
            'id_inventario' => $inventario->id_inventario,
            'numero' => $inventario->numero_documento,
            'gestion' => $inventario->gestion,
            'fecha' => $inventario->fecha,
            'estado' => $inventario->estado,
            'creado' => $inventario->created_at->format('d/m/Y'),
            'usuario' => $inventario->usuario->usuario ?? '',
            'responsable' => $inventario->responsable->nombre ?? '',
            'servicio' => $inventario->servicio->nombre ?? '',
            'tablaDetalle' => $tabla,
            'id_inventario_pendiente' => $inventarioPendiente->id_inventario ?? null,
        ]);
    }







public function regresarActivo(Request $request)
{
    $request->validate([
        'id_activo' => 'required|integer',
        'id_inventario_origen' => 'required|integer',
        'id_inventario_pendiente' => 'required|integer',
    ]);

    $idActivo = $request->id_activo;
    $idOrigen = $request->id_inventario_origen;     // Inventario vigente
    $idPendiente = $request->id_inventario_pendiente; // Inventario destino (pendiente)

    // 1️⃣ Verificar que el activo existe en inventario pendiente
    $detallePendiente = DetalleInventario::where('id_inventario', $idPendiente)
        ->where('id_activo', $idActivo)
        ->first();

    if (!$detallePendiente) {
        return response()->json([
            'success' => false,
            'mensaje' => 'El activo no está en el inventario pendiente.'
        ]);
    }

    // 2️⃣ Eliminar el registro del inventario pendiente
    $detallePendiente->delete();

    // 3️⃣ Verificar si en el inventario original está desactivado el botón mover
    $detalleOrigen = DetalleInventario::where('id_inventario', $idOrigen)
        ->where('id_activo', $idActivo)
        ->first();

    return response()->json([
        'success' => true,
        'mensaje' => 'Activo regresado correctamente.',
        'id_activo' => $idActivo
    ]);
}

public function moverActivo(Request $request)
{
    $request->validate([
        'id_activo' => 'required|integer',
        'id_inventario_actual' => 'required|integer',
        'id_inventario_destino' => 'required|integer',
    ]);

    $idActivo = $request->id_activo;
    $idActual = $request->id_inventario_actual;
    $idDestino = $request->id_inventario_destino;

    // Verificar que el activo existe en inventario actual
    $detalleActual = DetalleInventario::where('id_inventario', $idActual)
        ->where('id_activo', $idActivo)
        ->first();

    if (!$detalleActual) {
        return response()->json(['success' => false, 'mensaje' => 'El activo no pertenece al inventario actual.']);
    }

    // Verificar que el inventario actual esté vigente
    $inventarioActual = Inventario::find($idActual);
    if (!$inventarioActual || $inventarioActual->estado !== 'vigente') {
        return response()->json(['success' => false, 'mensaje' => 'El inventario actual no está vigente.']);
    }

    // Verificar que el inventario destino esté pendiente
    $inventarioDestino = Inventario::find($idDestino);
    if (!$inventarioDestino || $inventarioDestino->estado !== 'pendiente') {
        return response()->json(['success' => false, 'mensaje' => 'El inventario destino no está pendiente.']);
    }

    // Verificar si ya existe en el inventario destino
    if (DetalleInventario::where('id_inventario', $idDestino)->where('id_activo', $idActivo)->exists()) {
        return response()->json(['success' => false, 'mensaje' => 'El activo ya está en el inventario destino.']);
    }

    // Número correlativo en inventario destino
    $numero = DetalleInventario::where('id_inventario', $idDestino)->count() + 1;

    // Crear nuevo detalle copiando estado y observaciones
    $detalleNuevo = DetalleInventario::create([
        'id_inventario' => $idDestino,
        'id_activo' => $idActivo,
        'estado_actual' => $detalleActual->estado_actual,
        'observaciones' => $detalleActual->observaciones,
    ]);

    // Traer estados para el select
    $estados = Estado::all();
    $estadoActual = strtolower(trim($detalleNuevo->estado_actual));
    $options = "";
    foreach ($estados as $estado) {
        $selected = (strtolower($estado->nombre) === $estadoActual) ? 'selected' : '';
        $options .= "<option value='{$estado->id_estado}' {$selected}>{$estado->nombre}</option>";
    }
// dd($detalleNuevo);
    // Retornar todo listo para insertar en la tabla
    return response()->json([
        'success' => true,
        'mensaje' => 'Activo movido correctamente.',
        'detalle' => [
            'id_detalle' => $detalleNuevo->id_detalle,
            'id_detalle_inventario' => $detalleNuevo->id_detalle_inventario,
            'id_activo' => $detalleNuevo->id_activo,
            'numero' => $numero,
            'codigo' => $detalleNuevo->activo->codigo ?? '--Codigo--',
            'nombre' => $detalleNuevo->activo->nombre ?? '--Nombre--',
            'detalle' => $detalleNuevo->activo->nombre ?? '--Detalle--',
            'observaciones' => $detalleNuevo->observaciones,
            'estados_html' => $options
        ]
    ]);
}














public function generarInventarioPendiente(Request $request)
{
    $idInventario = $request->id_inventario;

    // 1️⃣ Obtener inventario original
    $inventarioOriginal = Inventario::findOrFail($idInventario);

    $idServicio = $inventarioOriginal->id_servicio;
    $idResponsable = $inventarioOriginal->id_responsable;

    // 2️⃣ Año actual para la gestión
    $gestionActual = Carbon::now()->year;

    // 3️⃣ Generar número de documento disponible
    $numeroDocumento = $this->generarNumeroDocumento($gestionActual);

    // 4️⃣ Crear nuevo inventario pendiente
    $nuevoInventario = Inventario::create([
        'numero_documento' => $numeroDocumento,
        'gestion'          => $gestionActual,
        'fecha'            => Carbon::now()->format('Y-m-d'),
        'id_usuario'       => auth()->user()->id_usuario,
        'usuario'       => auth()->user()->usuario,
        'id_responsable'   => $idResponsable,
        'id_servicio'      => $idServicio,
        'observaciones'    => 'Generado automáticamente',
        'estado'           => 'pendiente',
    ]);

    // Cargar relaciones para que devuelva nombres también
    $nuevoInventario->load(['responsable', 'servicio','usuario']);

    return response()->json([
        'mensaje' => 'Inventario pendiente generado correctamente',
        'inventario' => $nuevoInventario,
        'responsable' => $nuevoInventario->responsable->nombre,
        'servicio' => $nuevoInventario->servicio->nombre,
    ]);
}







   public function generarNumeroDocumento(string $gestion): string
    {
        $maxNumero = 999;

        $numerosExistentes = Inventario::where('gestion', $gestion)
            ->where('estado', '!=', 'eliminado')
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











public function getPendiente($id)
{
    // Buscar el inventario que queremos actualizar
    $inventarioActual = Inventario::findOrFail($id);
    $idServicio = $inventarioActual->id_servicio;

    // Buscar el inventario pendiente de ese servicio
    $inventarioPendiente = Inventario::with(['usuario', 'responsable', 'servicio', 'detalles.activo'])
        ->where('id_servicio', $idServicio)
        ->where('estado', 'pendiente')
        ->orderBy('created_at', 'desc') 
        ->first(); // Devuelve null si no existe pendiente
$estados = Estado::all(); // id_estado, nombre

    if ($inventarioPendiente) {
        // Ya existe un pendiente → retornamos sus datos
       $tabla = '';

foreach ($inventarioPendiente->detalles as $i => $detalle) {

    // Estado actual del detalle
    $estadoActual = strtolower(trim($detalle->estado_actual));
// dd($detalle);
    $tabla .= '<tr data-id='.$detalle->id_detalle_inventario.'>';
    $tabla .= '<td>'.($i+1).'</td>';
    $tabla .= '<td>'.$detalle->activo->codigo.'</td>';
    $tabla .= '<td>'.$detalle->activo->nombre.'</td>';
    $tabla .= '<td>'.$detalle->activo->detalle.'</td>';

    // --------------------------
    // SELECT DE ESTADOS
    // --------------------------
    $tabla .= '<td>';
    $tabla .= '<select class="form-select form-select-sm estado-select estadoActualizar " data-id="'.$detalle->id_detalle.'">';
    
    foreach ($estados as $estado) {
        $selected = (strtolower($estado->nombre) == $estadoActual) ? 'selected' : '';
        $tabla .= '<option value="'.$estado->id_estado.'" '.$selected.'>'.$estado->nombre.'</option>';
    }

    $tabla .= '</select>';
    $tabla .= '</td>';

    // --------------------------
    // INPUT OBSERVACIONES
    // --------------------------
    $tabla .= '<td>';
    $tabla .= '<input type="text" class="form-control form-control-sm observacion-input observacionActualizar" 
                    value="'.$detalle->observaciones.'" 
                    data-id="'.$detalle->id_detalle.'">';
    $tabla .= '</td>';

    // --------------------------
    // BOTÓN REGRESAR
    // --------------------------
    $tabla .= '<td>
        <button class="btn btn-sm btn-danger regresar-activo-btn ms-1"
            title="Regresar activo"
            data-id="'.$detalle->activo->id_activo.'">
            <i class="bi bi-arrow-left-circle"></i>
        </button>
   <button data-id='.$detalle->id_detalle_inventario.' 
        class="btn btn-sm btn-success guardar-cambios-btn ms-1 d-none" 
        title="Guardar cambios">
    <i class="bi bi-check"></i>
</button>



    </td>';

    $tabla .= '</tr>';
}
// dd($inventarioPendiente->usuario->usuario);

        return response()->json([
            'encontrado' => true,
            'id_inventario' => $inventarioPendiente->id_inventario,
            'numero'        => $inventarioPendiente->numero_documento,
            'gestion'       => $inventarioPendiente->gestion,
            'fecha'         => $inventarioPendiente->fecha,
            'estado'        => $inventarioPendiente->estado,
            'observaciones'        => $inventarioPendiente->observaciones,
            'usuario'       => $inventarioPendiente->usuario->usuario ?? '',
            'id_responsable'   => $inventarioPendiente->responsable->id_responsable ?? '',
            'responsable'   => $inventarioPendiente->responsable->nombre ?? '',
            'servicio'      => $inventarioPendiente->servicio->nombre ?? '',
            'id_servicio'      => $inventarioPendiente->servicio->id_servicio ?? '',
            'tablaDetalle'  => $tabla,
        ]);
    }

    // Si no hay inventario pendiente → indicar que debe generarse
    return response()->json([
            'encontrado' => false,
        'mensaje' => 'No se encontró inventario pendiente para este servicio.',
        'tablaDetalle' => '<tr><td colspan="6" class="text-center">No hay detalles</td></tr>'
    ]);
}









    public function activosInventario($id_inventario)
    {
        // Busca el inventario con sus detalles y activos relacionados
        $inventario = Inventario::with('detalles.activo')->findOrFail($id_inventario);

        // Pagina los detalles con sus activos
        $detalles = $inventario->detalles()->with('activo')->paginate(20);

        // Devuelve la vista con los detalles paginados
        return view('user.inventario.activos', compact('detalles', 'id_inventario'));
    }



    public function consultar()
{
    $servicios = Servicio::orderBy('nombre')->get();
    $responsables = Responsable::orderBy('nombre')->get();

    // No carga inventarios aquí
    return view('user.inventario.consultar', compact('servicios', 'responsables'));
}

//     public function filtrar(Request $request)
// {
//     $query = Inventario::orderBy('fecha', 'desc');

//     if ($request->filled('servicio') && !in_array($request->servicio, ['0', 'all'])) {
//         $query->where('id_servicio', $request->servicio);
//     }

//     if ($request->filled('responsable') && !in_array($request->responsable, ['0', 'all'])) {
//         $query->where('id_responsable', $request->responsable);
//     }

//     // 🔁 Solo uno de los dos: gestión o rango de fechas
//     if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
//         $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
//     } elseif ($request->filled('gestion') && !in_array($request->gestion, ['0', 'all'])) {
//         $query->where('gestion', $request->gestion);
//     }

//     $inventarios = $query->paginate(20)->withQueryString();

//     return view('user.inventario.parcial', compact('inventarios'))->render();
// }



public function filtrar(Request $request)
{

if ($request->filled('id_inventario')) {
    // dd($request->id_inventario);
    $inventario = Inventario::with(['usuario','responsable','servicio','detalles.activo'])
                            ->where('id_inventario', $request->id_inventario)
                            ->paginate(10); // 👈 PAGINADOR, NO COLLECTION

    return view('user.inventario.parcial', [
        'inventarios' => $inventario
    ])->render();
}

    // $query = Inventario::query()->with(['usuario', 'responsable', 'servicio']);
  $query = Inventario::query()->with(['usuario', 'responsable', 'servicio', 'detalles.activo']);

    // 📌 Numero de documento
    if ($request->filled('numero_documento')) {
        $query->where('numero_documento', 'like', "%{$request->numero_documento}%");
    }

    // 📌 Gestión
    if ($request->filled('gestion')) {
        $query->where('gestion', $request->gestion);
    }

    // 📌 Usuario
    if ($request->filled('id_usuario') && $request->id_usuario !== 'all') {
        $query->where('id_usuario', $request->id_usuario);
    }

    // 📌 Responsable
    if ($request->filled('id_responsable') && $request->id_responsable !== 'all') {
        $query->where('id_responsable', $request->id_responsable);
    }

    // 📌 Servicio
    if ($request->filled('id_servicio') && $request->id_servicio !== 'all') {
        $query->where('id_servicio', $request->id_servicio);
    }

    // 📌 Estado (activo / cerrado / anulado)
    if ($request->filled('estado') && $request->estado !== 'all') {
        $query->where('estado', $request->estado);
    }

    // 📌 Observaciones
    if ($request->filled('observaciones')) {
        $query->where('observaciones', 'like', "%{$request->observaciones}%");
    }

    // 📅 Rango de fechas
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $inicio = $request->fecha_inicio . " 00:00:00";
        $fin    = $request->fecha_fin . " 23:59:59";
        $query->whereBetween('fecha', [$inicio, $fin]);
    }
if ($request->filled('busqueda')) {
    $query->where(function($q) use ($request) {
        $q->where('numero_documento', 'like', "%{$request->busqueda}%")
          ->orWhere('gestion', 'like', "%{$request->busqueda}%")
          ->orWhereHas('servicio', function($s) use ($request) {
              $s->where('nombre', 'like', "%{$request->busqueda}%");
          })
          ->orWhereHas('responsable', function($r) use ($request) {
              $r->where('nombre', 'like', "%{$request->busqueda}%");
          });
    });
}




 if ($request->filled('busquedaActivo')) {
        $busquedaActivo = $request->busquedaActivo;

        // Filtra inventarios que tengan al menos un activo que coincida
        $query->whereHas('detalles.activo', function($q) use ($busquedaActivo) {
            $q->where('codigo', 'like', "%{$busquedaActivo}%")
              ->orWhere('nombre', 'like', "%{$busquedaActivo}%")
              ->orWhere('detalle', 'like', "%{$busquedaActivo}%");
        });
    }





    // 📌 Orden
    $ordenarPor = $request->input('ordenar_por', 'fecha');
    $direccion  = $request->input('direccion', 'desc');

    $query->orderBy($ordenarPor, $direccion);

    // 📌 PAGINACIÓN
    // $inventarios = $query->paginate(10)->withQueryString();
    $inventarios = $query->paginate(20);
foreach ($inventarios->items() as $inv) {
    $inv->total_activos = $inv->detalles->count();
}
    // 📌 RETORNO A TU PARCIAL
    return view('user.inventario.parcial', compact('inventarios'))->render();
}



    public function ultimoInventario(Request $request)
    {
        $servicioId = $request->input('servicio_id');

        if (!$servicioId) {
            return response()->json(null, 400); // Bad Request si no se pasa el servicio
        }

        // Obtener el último inventario filtrando por servicio_id y ordenando por gestión descendente
        $inventario = Inventario::where('id_servicio', $servicioId)
            ->orderByDesc('gestion')
            ->latest('created_at')
            ->first();

        if (!$inventario) {
            return response()->json(null);
        }

        $cantidadActivos = DetalleInventario::where('id_inventario', $inventario->id_inventario)
            ->sum('cantidad');
              $nombreResponsable = $inventario->responsable ? $inventario->responsable->nombre : 'No asignado';

        // Contar los activos asociados
        // $cantidadActivos = $inventario->activos()->count();

        // Convertir todo el inventario a array
        $data = $inventario->toArray();

        // Agregar la cantidad de activos
        $data['cantidad_activos'] = $cantidadActivos;
        $data['nombre_responsable'] = $nombreResponsable;
        return response()->json($data);
    }
    // public function generarNumeroDocumento()
    // {
    //     $maxNumero = 999; // máximo permitido
    //     // Trae todos los numeros_documento existentes (solo esa columna)
    //     $numerosExistentes = Inventario::pluck('numero_documento')->toArray();

    //     // Convertimos a un set para búsqueda rápida
    //     $numerosExistentesSet = array_flip($numerosExistentes);

    //     for ($i = 1; $i <= $maxNumero; $i++) {
    //         $numeroFormateado = str_pad($i, 3, '0', STR_PAD_LEFT);
    //         if (!isset($numerosExistentesSet[$numeroFormateado])) {
    //             return $numeroFormateado;
    //         }
    //     }

    //     throw new \Exception('No hay números disponibles');
    // }
    // Generar un nuevo inventario
    // public function generarVacio(Request $request)
    // {
    //     $request->validate([
    //         'id_servicio' => 'required|exists:servicios,id_servicio',
    //         'id_responsable' => 'required|exists:responsables,id_responsable',
    //         'gestion' => 'required',
    //         'fecha' => 'required|date',
    //     ]);

    //     try {
    //         $inventario = Inventario::create([
    //             'numero_documento' => $this->generarNumeroDocumento(),
    //             'gestion' => $request->input('gestion'),
    //             'fecha' => $request->input('fecha'),
    //             'id_usuario' => Auth::id(),
    //             'id_responsable' => $request->input('id_responsable'),
    //             'id_servicio' => $request->input('id_servicio'),
    //             'observaciones' => "generado automaticamente" ?? null,
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'inventario' => $inventario
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'error' => 'Error al generar inventario: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    /**
     * Show the form for creating a new resource.
     */
    // public function consultar(Request $request)
    // {
    //     $query = Inventario::orderBy('fecha', 'desc');

    //     if ($request->filled('servicio') && !in_array($request->servicio, ['0', 'all'])) {
    //         $query->where('id_servicio', $request->servicio);
    //     }

    //     if ($request->filled('responsable') && !in_array($request->responsable, ['0', 'all'])) {
    //         $query->where('id_responsable', $request->responsable);
    //     }

    //     if ($request->filled('gestion') && !in_array($request->gestion, ['0', 'all'])) {
    //         $query->where('gestion', $request->gestion);
    //     }

    //     if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
    //         $query->whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin]);
    //     }

    //     $inventarios = $query->paginate(20)->withQueryString();

    //     $servicios = Servicio::orderBy('nombre')->get();
    //     $responsables = Responsable::orderBy('nombre')->get();
    //     $gestiones = Inventario::select('gestion')->distinct()->orderByDesc('gestion')->pluck('gestion');

    //     if ($request->ajax() && (
    //         $request->has('servicio') ||
    //         $request->has('responsable') ||
    //         $request->has('gestion') ||
    //         $request->has('fecha_inicio') ||
    //         $request->has('page') // para paginación
    //     )) {
    //         return view('user.inventario.parcial', compact('inventarios'))->render();
    //     }

    //     return view('user.inventario.consultar', compact('inventarios', 'servicios', 'responsables', 'gestiones'));
    // }




     // public function consultar()
    // {
    //     // Últimos 20 inventarios
    //     $inventarios = Inventario::orderBy('fecha', 'desc')->take(20)->get();

    //     // Todos los servicios
    //     $servicios = Servicio::orderBy('nombre')->get();

    //     // Todos los responsables
    //     $responsables = Responsable::orderBy('nombre')->get();

    //     // Gestiones disponibles desde Inventario (esto sí lo tomamos desde inventarios)
    //     $gestiones = Inventario::select('gestion')->distinct()->orderByDesc('gestion')->pluck('gestion');

    //     return view('user.inventario.consultar', compact('inventarios', 'servicios', 'responsables', 'gestiones'));
    // }

//     public function filtrar(Request $request)
// {
//     $query = Inventario::query();

//     if ($request->filled('servicio')) {
//         $query->where('id_servicio', $request->servicio);
//     }

//     if ($request->filled('gestion')) {
//         $query->where('gestion', $request->gestion);
//     }

//     if ($request->filled('responsable')) {
//         $query->where('id_responsable', $request->responsable);
//     }

//     if ($request->filled('fecha_inicio')) {
//         $query->whereDate('fecha', '>=', $request->fecha_inicio);
//     }

//     if ($request->filled('fecha_fin')) {
//         $query->whereDate('fecha', '<=', $request->fecha_fin);
//     }

//     $inventarios = $query->orderBy('numero_documento', 'desc')->take(100)->get();

//     // 👇 Aquí retornamos solo la tabla renderizada
//     return view('inventarios.partials.tabla', compact('inventarios'));
// }










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
 $responsables = Responsable::activos()
    ->orderBy('nombre', 'asc')
    ->get();

// dd($id);
    return view('user.inventario.show', compact(
        'id',
        'usuarios',
        'servicios',
        'responsables'
    ));
}




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        //
    }
}
