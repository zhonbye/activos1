<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';

    protected $primaryKey = 'id_cargo';

    protected $fillable = [
        'nombre',
        'abreviatura',
        'created_at',
        'updated_at',
    ];

    public function responsables()
    {
        return $this->hasMany(Responsable::class, 'id_cargo');
    }
}
