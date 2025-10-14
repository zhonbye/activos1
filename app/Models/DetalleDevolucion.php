<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDevolucion extends Model
{
    use HasFactory;

    protected $table = 'detalle_devoluciones';

    protected $primaryKey = 'id_detalle_devolucion';

    protected $fillable = [
        'id_devolucion',
        'id_activo',
        'cantidad',
        'observaciones',
    ];

    public function devolucion()
    {
        return $this->belongsTo(Devolucion::class, 'id_devolucion', 'id_devolucion');
    }

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
