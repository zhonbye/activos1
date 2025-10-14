<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctos', function (Blueprint $table) {
            $table->id('id_docto');
            $table->string('numero',10);
            $table->integer('gestion');
            $table->date('fecha');
            $table->enum('tipo', ['ENTREGA','DEVOLUCIÓN','TRASLADO','INVENTARIO','BAJA']);
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_servicio');
            $table->unsignedBigInteger('id_responsable');
            $table->string('detalle', 200)->nullable();
            $table->timestamps();
        });
        DB::table('doctos')->insert([
            'id_docto' => 1,
            'numero' => 001,
            'gestion' => date('Y'),
            'fecha' => date('Y-m-d'),
            'tipo' => 'ENTREGA',
            'id_usuario' => 1,      // Debe existir el usuario con id 1
            'id_servicio' => 1,    // Debe existir ubicación con id 1
            'id_responsable' => 1,  // Debe existir responsable con id 1
            'detalle' => 'Registro inicial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctos');
    }
};
