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
        Schema::create('responsables', function (Blueprint $table) {
            $table->id('id_responsable');
            $table->string('nombre', 100);
            $table->string('ci', 30)->unique();
            $table->string('telefono', 30)->nullable();

            $table->unsignedBigInteger('id_cargo');
            $table->string('rol', 50)->default('personal operativo')->nullable();
            $table->foreign('id_cargo')->references('id_cargo')->on('cargos')->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
        });

       DB::table('responsables')->insert([
    // Personal operativo
    [
        'nombre' => 'Divar Guiterrez',
        'ci' => '7435345678',
        'telefono' => '73718313',
        'rol' => 'personal operativo',
        'id_cargo' => 1,  // Doctor por ejemplo
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'nombre' => 'María Gómez',
        'ci' => '87654321',
        'telefono' => '74392142',
        'rol' => 'personal operativo',
        'id_cargo' => 2, // Licenciada por ejemplo
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // Director del hospital
    [
        'nombre' => 'Franz Gutiérrez Choque',
        'ci' => '00000001',
        'telefono' => '70000001',
        'rol' => 'Director',
        'id_cargo' => 1, // Doctor
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // Administrador del hospital
    [
        'nombre' => 'Julio Cesar Rivero Pacheco',
        'ci' => '00000002',
        'telefono' => '70000002',
        'rol' => 'Administrador',
        'id_cargo' => 3, // Licenciado
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsables');
    }
};
