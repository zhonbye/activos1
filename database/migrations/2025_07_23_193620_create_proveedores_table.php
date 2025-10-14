<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('id_proveedor');
            $table->string('nombre', 100);
            $table->string('lugar', 20);
            $table->string('contacto', 100)->nullable();
            $table->timestamps();
        });

        // Datos por defecto
        DB::table('proveedores')->insert([
            ['nombre' => 'Meditek S.R.L.', 'lugar' => 'ORURO', 'contacto' => 'meditek@proveedores.com', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Hospital Solutions', 'lugar' => 'SANTA CRUZ', 'contacto' => 'ventas@hosol.com', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};

