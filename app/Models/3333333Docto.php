<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docto extends Model
{
    use HasFactory;
    protected $table = 'doctos';

    protected $primaryKey = 'id_docto';

    protected $fillable = [
        'numero', 'gestion', 'fecha', 'tipo', 'id_usuario', 'id_servicio', 'id_responsable', 'detalle'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'id_responsable');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }

    public function activos()
    {
        return $this->hasMany(Activo::class, 'id_docto_origen');
    }
}
