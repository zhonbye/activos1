<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    use HasFactory;

    protected $table = 'donaciones';

    protected $primaryKey = 'id_adquisicion';

    public $incrementing = false; // FK a adquisiciones

    protected $fillable = [
        'id_adquisicion',
        'id_donante',
        'motivo',
        'precio',
        'created_at',
        'updated_at',
    ];

    public function adquisicion()
    {
        return $this->belongsTo(Adquisicion::class, 'id_adquisicion');
    }

   public function donante()
    {
        return $this->belongsTo(Donante::class, 'id_donante', 'id_donante');
    }
    
}
