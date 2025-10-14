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
        Schema::create('unidades', function (Blueprint $table) {
            $table->id('id_unidad');
            $table->string('nombre', 50);
            $table->string('abreviatura', 10);
            $table->timestamps();
        });

        DB::table('unidades')->insert([
            ['nombre' => 'Unidad', 'abreviatura' => 'u.'],
            ['nombre' => 'Pieza', 'abreviatura' => 'pza.'],
            ['nombre' => 'Caja', 'abreviatura' => 'cj.'],
            ['nombre' => 'Par', 'abreviatura' => 'par'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidads');
    }
};
