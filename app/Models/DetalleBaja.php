<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleBaja extends Model
{
    use HasFactory;

    protected $table = 'detalle_bajas';

    protected $primaryKey = 'id_detalle_baja';

    protected $fillable = [
        'id_baja',
        'id_activo',
        'cantidad',
        'observaciones',
    ];

    public function baja()
    {
        return $this->belongsTo(Baja::class, 'id_baja', 'id_baja');
    }

    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
