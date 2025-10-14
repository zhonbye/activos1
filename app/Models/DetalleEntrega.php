<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEntrega extends Model
{
    use HasFactory;

    protected $table = 'detalle_entregas';

    protected $primaryKey = 'id_detalle_entrega';

    protected $fillable = [
        'id_entrega',
        'id_activo',
        'cantidad',
        'observaciones',
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'id_entrega', 'id_entrega');
    }

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
