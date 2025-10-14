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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('usuario', 50)->unique(); // nombre de usuario
            $table->string('clave'); // contraseña
            $table->enum('rol', ['administrador', 'desarrollador', 'usuario']); // rol del usuario
            $table->enum('estado', ['activo', 'inactivo'])->default('activo'); // estado del usuario

            // Relación con responsables (opcional, puede ser null)
            $table->unsignedBigInteger('id_responsable')->nullable();
            $table->foreign('id_responsable')->references('id_responsable')->on('responsables')->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();
        });


DB::table('usuarios')->insert([
    'usuario' => 'jhon',
    'clave' => bcrypt('jhon1234'), // recuerda usar bcrypt para la contraseña
    'rol' => 'usuario',
    'estado' => 'activo',
    'id_responsable' => 1,  // Asegúrate que exista un responsable con id 1
    'created_at' => now(),
    'updated_at' => now(),
]);
DB::table('usuarios')->insert([
    'usuario' => 'admin',
    'clave' => bcrypt('admin1234'), // recuerda usar bcrypt para la contraseña
    'rol' => 'administrador',
    'estado' => 'activo',
    'id_responsable' => 1,  // Asegúrate que exista un responsable con id 1
    'created_at' => now(),
    'updated_at' => now(),
]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');

    }
};
