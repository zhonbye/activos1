<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
    use HasFactory;

    protected $table = 'traslados';

    protected $primaryKey = 'id_traslado';

    protected $fillable = [
        'numero_documento',
        'gestion',
        'fecha',
        'id_usuario',
        'id_servicio_origen',
        'id_servicio_destino',
        'observaciones',
        'estado',
        'url',
    ];
    // App\Models\Traslado.php

/**
 * Scope para verificar si el traslado es editable.
 * Retorna solo los traslados que NO estén FINALIZADOS o ELIMINADOS.
 */
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



    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function responsableOrigen()
    {
        return $this->belongsTo(Responsable::class, 'id_responsable_origen', 'id_responsable');
    }

    public function responsableDestino()
    {
        return $this->belongsTo(Responsable::class, 'id_responsable_destino', 'id_responsable');
    }

    public function servicioOrigen()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio_origen', 'id_servicio');
    }

    public function servicioDestino()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio_destino', 'id_servicio');
    }
}
