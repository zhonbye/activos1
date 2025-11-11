<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $primaryKey = 'id_entrega';

    protected $fillable = [
        'numero_documento',
        'gestion',
        'fecha',
        'id_usuario',
        // 'id_responsable',
        'id_servicio',
        'observaciones',
        'estado',
        'url',
    ];

    public function scopeEditable($query)
{
    return $query->whereRaw('LOWER(estado) NOT IN (?, ?)', ['finalizado', 'eliminado']);
}



/**
 * Método helper para usar en un traslado específico.
 * Devuelve true si se puede modificar.
 */
public function isEditable()
{
    return !in_array(strtolower($this->estado), ['finalizado', 'eliminado']);
}

public function scopeNoEliminados($query)
{
    return $query->where('estado', '!=', 'ELIMINADO');
}


public function detalles() {
    return $this->hasMany(DetalleEntrega::class, 'id_entrega');

}
 public function scopeActivas($query)
    {
        return $query->where('estado', '!=', 'eliminado');
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
