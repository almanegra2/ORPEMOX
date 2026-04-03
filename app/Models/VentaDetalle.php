<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    protected $table = 'venta_detalle';
    protected $primaryKey = 'id_venta_detalle';
    public $timestamps = false;
    protected $fillable = [
        'id_venta',
        'id_producto',
        'precio',
        'cantidad',
        'subtotal',
        'estado',
    ];
}
