<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false; // Existing tables usually don't have created_at/updated_at unless checked

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'correo',
        'telefono'
    ];
}
