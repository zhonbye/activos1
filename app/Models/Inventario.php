<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventarios';

    protected $primaryKey = 'id_inventario';

    protected $fillable = [
        'numero_documento',
        'gestion',
        'fecha',
        'id_usuario',
        'id_responsable',
        'id_servicio',
        'observaciones',
    ];

    // Laravel manejará automáticamente created_at y updated_at porque existen en la tabla
    public function detalles()
    {
        return $this->hasMany(DetalleInventario::class, 'id_inventario', 'id_inventario');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'id_responsable', 'id_responsable');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }
}
