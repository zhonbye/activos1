<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $primaryKey = 'id_adquisicion';

    public $incrementing = false; // porque es PK y FK a adquisiciones

    protected $fillable = [
        'id_adquisicion',
        'id_proveedor',
        'precio',
        'created_at',
        'updated_at',
    ];

    
   public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function adquisicion()
    {
        return $this->belongsTo(Adquisicion::class, 'id_adquisicion');
    }
}
