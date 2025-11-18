<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('bajas', function (Blueprint $table) {
        //     $table->id('id_baja');
        //     $table->string('numero_documento')->unique();
        //     $table->integer('gestion');
        //     $table->date('fecha');
        //     $table->unsignedBigInteger('id_usuario');
        //     $table->unsignedBigInteger('id_responsable');
        //     $table->unsignedBigInteger('id_servicio');
        //    $table->string('observaciones', 100)->nullable();

        //     $table->string('estado', 20)->default('pendiente');
        //     $table->string('url', 300)->nullable();
        //     $table->timestamps();

        //     $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        //     $table->foreign('id_responsable')->references('id_responsable')->on('responsables')->onDelete('cascade');
        //     $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
        // });
        Schema::create('bajas', function (Blueprint $table) {
    $table->id('id_baja');

    // Activo dado de baja
    $table->unsignedBigInteger('id_activo');

    // A qué servicio pertenecía y responsable actual
    $table->unsignedBigInteger('id_servicio');
    $table->unsignedBigInteger('id_responsable');

    // Quién registró la baja (usuario del sistema)
    $table->unsignedBigInteger('id_usuario');

    // Datos de la baja
    $table->date('fecha');
    $table->string('motivo', 150);

    // Opcional
    $table->string('observaciones', 200)->nullable();
    // $table->string('estado', 20)->default('pendiente');

    $table->timestamps();

    // Relaciones
    $table->foreign('id_activo')->references('id_activo')->on('activos')->onDelete('cascade');
    $table->foreign('id_servicio')->references('id_servicio')->on('servicios')->onDelete('cascade');
    $table->foreign('id_responsable')->references('id_responsable')->on('responsables')->onDelete('cascade');
    $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
});


        // DB::table('bajas')->insert([
        //     'numero_documento' => 'BAJ-0001',
        //     'gestion' => 2025,
        //     'fecha' => now(),
        //     'id_usuario' => 1,
        //     'id_responsable' => 1,
        //     'id_servicio' => 1,
        //     'observaciones' => 'Baja inicial de prueba',
        //     'estado' => 'pendiente',
        //     'url' => null,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('bajas');
    }
};
