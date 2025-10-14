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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre', 50);
            $table->string('descripcion', 100)->nullable();
            $table->timestamps();
        });

        DB::table('categorias')->insert([
            ['nombre' => 'Mobiliario', 'descripcion' => 'Muebles del hospital'],
            ['nombre' => 'Equipamiento Médico', 'descripcion' => 'Equipos médicos'],
            ['nombre' => 'Informática', 'descripcion' => 'Computadoras, impresoras, etc.'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
