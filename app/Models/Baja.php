<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
   
    use HasFactory;

    protected $table = 'bajas';
    protected $primaryKey = 'id_baja';

    protected $fillable = [
        'id_activo',        // Falta incluir para poder asignar activo
        'id_servicio',
        'id_responsable',
        'id_usuario',
        'fecha',
        'motivo',
        'observaciones',
        // 'estado', // ya no existe en la tabla
        'created_at',
        'updated_at',
    ];

    // Relación con usuario que registró la baja
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Relación con responsable del activo al momento de la baja
    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'id_responsable', 'id_responsable');
    }

    // Relación con el servicio del activo al momento de la baja
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    // Relación con el activo dado de baja
    public function activo()
    {
        return $this->belongsTo(Activo::class, 'id_activo', 'id_activo');
    }
}
