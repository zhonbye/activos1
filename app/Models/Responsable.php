<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;

    protected $table = 'responsables';

    protected $primaryKey = 'id_responsable';

  protected $fillable = [
        'nombre',
        'ci',
        'telefono',
        'id_cargo',
        'rol',
        'estado',
    ];
    public function usuario()
{
    return $this->hasOne(Usuario::class, 'id_responsable');
}

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo', 'id_cargo');
    }
    public function servicio()
{
    return $this->hasOne(Servicio::class, 'id_responsable', 'id_responsable');
}
public function scopeActivos($query)
{
    return $query->where('estado', 'ACTIVO');
}
}
