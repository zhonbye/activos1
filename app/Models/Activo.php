<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    use HasFactory;

    protected $table = 'activos';

    protected $primaryKey = 'id_activo';

    protected $fillable = [
        'codigo',
        'nombre',
        'detalle',
        'cantidad',
        'estado_situacional',
        'id_categoria',
        'id_unidadmed',
        'id_estado',
        'id_adquisicion',
        'created_at',
        'updated_at',
    ];
    public function scopeSoloActivos($query)
{
    return $query->where('estado_situacional', 'activo');
}

    public function scopeActivos($query)
    {
        return $query->where('estado_situacional', '!=', 'eliminado');
    }
    public function detalles()
    {
        return $this->hasMany(DetalleInventario::class, 'id_activo', 'id_activo');
    }
    public function detalleEntregas() {
    return $this->hasMany(DetalleEntrega::class, 'id_activo');
}

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function adquisicion()
    {
        return $this->belongsTo(Adquisicion::class, 'id_adquisicion');
    }
    public function detalleInventario()
    {
        return $this->hasOne(DetalleInventario::class, 'id_activo', 'id_activo');
    }

}
