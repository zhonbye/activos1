<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleInventario extends Model
{
    use HasFactory;

    protected $table = 'detalle_inventarios';

    protected $primaryKey = 'id_detalle_inventario';

    protected $fillable = [
        'id_inventario',
        'id_activo',
        'estado_actual',
        'cantidad',
        'observaciones',
    ];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario', 'id_inventario');
    }

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
