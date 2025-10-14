<?php

namespace App\Http\Controllers;
use App\Models\Usuario;             // para el modelo User
use Illuminate\Support\Facades\Hash;  // para el Hash
use App\Models\Activo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        // Validar inputs
        $request->validate([
            'usuario' => ['required', 'string'],
            'clave' => ['required', 'string'],
        ]);

        // Buscar usuario por nombre
        $user = Usuario::where('usuario', $request->usuario)->first();

        if (!$user) {
            return back()->withErrors(['usuario' => 'Usuario no encontrado.'])->withInput();
            // return response('<script>window.history.back();</script>')->withErrors(['usuario' => 'Usuario no encontrado.'])->withInput();
            // return response('<script>alert("Usuario no encontrado."); window.history.back();</script>');

        }

        if ($user->estado !== 'activo') {
            return back()->withErrors(['usuario' => 'Usuario inactivo, contacta al administrador.'])->withInput();
        }

        // Verificar password
        if (!Hash::check($request->clave, $user->clave)) {
            return back()->withErrors(['clave' => 'Contraseña incorrecta.'])->withInput();
        }

        // Autenticar usuario
        Auth::login($user, $request->has('remember') && $request->remember === 'on');
        Log::info('Valor de remember:', [$request->remember]);

        $request->session()->regenerate();

///////////////////////////////////////////////////////////////////////////////777

        //codigo agregado despues
       $responsablesDirectivos = DB::table('responsables')
    ->join('cargos', 'responsables.id_cargo', '=', 'cargos.id_cargo')
    ->whereIn('responsables.rol', ['Director', 'Administrador'])
    ->select(
        'responsables.id_responsable',
        'responsables.nombre',
        'cargos.nombre as cargo',
        'cargos.abreviatura'
    )
    ->get()
    ->toArray();

// Guardar en sesión nativa PHP
session_start();
$_SESSION['responsablesDirectivos'] = $responsablesDirectivos;

//tdo eso  esatre al directo ry  admin del hsopital y lo guarda en la sesion
//////////////////////////////////////////////////////////////////////////////////////////


        // Redireccionar según rol
        switch ($user->rol) {
            case 'administrador':
                return redirect()->route('dashboardAdmin');
            case 'desarrollador':
                return redirect()->route('dashboardDev');
            default:
                return redirect()->route('dashboardUser');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function create() {}

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
    public function show(Activo $activo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activo $activo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activo $activo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activo $activo)
    {
        //
    }
}
