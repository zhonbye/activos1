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
        Schema::create('estados', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre', 50);
            $table->string('descripcion', 100)->nullable();
            $table->timestamps();
        });


        DB::table('estados')->insert([
            ['nombre' => 'NUEVO', 'descripcion' => 'En perfecto estado'],
            ['nombre' => 'REGULAR', 'descripcion' => 'Con uso moderado'],
            ['nombre' => 'MALO', 'descripcion' => 'Dañado o con fallas'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
