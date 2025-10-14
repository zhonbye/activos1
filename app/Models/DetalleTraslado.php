<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTraslado extends Model
{
    use HasFactory;

    protected $table = 'detalle_traslados';

    protected $primaryKey = 'id_detalle_traslado';

    protected $fillable = [
        'id_traslado',
        'id_activo',
        'cantidad',
        'observaciones',
    ];

    public function traslado()
    {
        return $this->belongsTo(Traslado::class, 'id_traslado', 'id_traslado');
    }

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
