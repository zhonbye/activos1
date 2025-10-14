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
                'precio' => 1500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
