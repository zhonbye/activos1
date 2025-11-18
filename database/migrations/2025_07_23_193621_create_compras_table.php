<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id('id_adquisicion'); // PK
            $table->unsignedBigInteger('id_proveedor');
            $table->decimal('precio', 10, 2);
            $table->timestamps();

            // Definir la relación foreign key después de los campos
            $table->foreign('id_proveedor')
                ->references('id_proveedor')->on('proveedores')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        DB::table('compras')->insert([
    [
        'id_adquisicion' => 1,
        'id_proveedor' => 1,
        'precio' => 1200.00,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'id_adquisicion' => 2,
        'id_proveedor' => 2,
        'precio' => 1800.00,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
    [
        'id_adquisicion' => 3,
        'id_proveedor' => 1,
        'precio' => 1000.00,
        'created_at' => '2025-01-03 00:00:00',
        'updated_at' => '2025-01-03 00:00:00',
    ],
]);

    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
