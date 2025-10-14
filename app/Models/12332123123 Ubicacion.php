<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'unidades'; // Nombre correcto de la tabla
    protected $primaryKey = 'id_unidad';

    protected $fillable = [
        'nombre',
        'abreviatura',
    ];

}
