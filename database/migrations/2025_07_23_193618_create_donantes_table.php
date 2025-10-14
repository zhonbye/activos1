<?php

// database/migrations/xxxx_xx_xx_create_donantes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('donantes', function (Blueprint $table) {
            $table->id('id_donante');
            $table->string('nombre', 100);
            $table->string('tipo', 50); // Ej: Persona natural, ONG, Empresa
            $table->string('contacto', 150)->nullable();
            $table->timestamps();
        });

        DB::table('donantes')->insert([
            ['nombre' => 'Fundación Esperanza', 'tipo' => 'ONG', 'contacto' => 'esperanza@fundacion.org'],
            ['nombre' => 'Juan Pérez', 'tipo' => 'Persona natural', 'contacto' => 'juan.perez@gmail.com'],
            ['nombre' => 'Empresa Salud S.A.', 'tipo' => 'Empresa', 'contacto' => 'contacto@saludsa.com'],
        ]);
    }

    public function down(): void {
        Schema::dropIfExists('donantes');
    }
};
