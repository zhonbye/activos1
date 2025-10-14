<?php

// database/migrations/xxxx_xx_xx_create_ubicaciones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id('id_ubicacion');
            $table->string('nombre', 100);
            $table->string('descripcion', 200)->nullable();
            $table->timestamps();
        });

        DB::table('ubicaciones')->insert([
            ['nombre' => 'Pediatría', 'descripcion' => 'Área de atención infantil'],
            ['nombre' => 'Emergencias', 'descripcion' => 'Sala de urgencias'],
            ['nombre' => 'Quirófano', 'descripcion' => 'Zona de operaciones']
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('ubicaciones');
    }
};
