<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'id_venta';
    public $timestamps = false;
    protected $fillable = [
        'id_cliente',
        'id_usuario',
        'fecha',
        'total',
        'descuento',
        'pagoTotal',
        'estado',
    ];
}
