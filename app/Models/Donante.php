<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donante extends Model
{
    use HasFactory;

    protected $table = 'donantes';

    protected $primaryKey = 'id_donante';

    protected $fillable = [
        'nombre',
        'tipo',
        'contacto',
        'created_at',
        'updated_at',
    ];

    public function donaciones()
    {
        return $this->hasMany(Donacion::class, 'id_donante');
    }
}
