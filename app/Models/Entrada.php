<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'entrada';
    protected $primaryKey = 'id_entrada';
    public $timestamps = false;
    protected $fillable = [
        'id_producto',
        'id_proveedor',
        'cantidad',
        'precio',
        'fecha',
    ];
}
