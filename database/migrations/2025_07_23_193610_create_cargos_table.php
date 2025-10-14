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
        Schema::create('cargos', function (Blueprint $table) {
    $table->id('id_cargo');
    $table->string('nombre', 100)->unique();
    $table->string('abreviatura', 10)->nullable(); // Nueva columna
    $table->timestamps();
});

// Insertar datos con abreviaturas
DB::table('cargos')->insert([
    ['nombre' => 'doctor', 'abreviatura' => 'Dr.', 'created_at' => now(), 'updated_at' => now()],
    ['nombre' => 'cirujano', 'abreviatura' => 'Ciru.', 'created_at' => now(), 'updated_at' => now()],
    ['nombre' => 'licenciado', 'abreviatura' => 'Lic.', 'created_at' => now(), 'updated_at' => now()],
    ['nombre' => 'enfermera', 'abreviatura' => 'Enf.', 'created_at' => now(), 'updated_at' => now()],
    ['nombre' => 'anestesiologo', 'abreviatura' => 'Anes.', 'created_at' => now(), 'updated_at' => now()],
]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
