<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use Illuminate\Http\Request;

class BajaController extends Controller
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
        return view('user.bajas.realizar');
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
    public function show(Baja $baja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Baja $baja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Baja $baja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Baja $baja)
    {
        //
    }
}
