<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id('id_area');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        DB::table('areas')->insert([
            ['nombre' => 'Administración', 'descripcion' => 'Área administrativa'],
            ['nombre' => 'Tecnología', 'descripcion' => 'Área de sistemas'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
