<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adquisicion extends Model
{
    use HasFactory;

    protected $table = 'adquisiciones';  // nombre exacto de la tabla

    protected $primaryKey = 'id_adquisicion';  // clave primaria

    protected $fillable = [
        'fecha',
        'tipo',
        'comentarios',
        'created_at',
        'updated_at',
    ];

    // Si tienes relación con activos (un activo pertenece a una adquisicion)
    public function activos()
    {
        return $this->hasMany(Activo::class, 'id_adquisicion');
    }

    // Si la adquisicion tiene relación con proveedores (en compra)
//    public function proveedor()
// {
//     return $this->belongsTo(Proveedor::class, 'id_proveedor');
// }

// public function donante()
// {
//     return $this->belongsTo(Donante::class, 'id_donante');
// }
 // Relación con Compra
    public function compra() {
    return $this->hasOne(Compra::class, 'id_adquisicion', 'id_adquisicion');
}

public function donacion() {
    return $this->hasOne(Donacion::class, 'id_adquisicion', 'id_adquisicion');
}


}
