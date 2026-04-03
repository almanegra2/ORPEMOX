<?php
use Illuminate\Support\Facades\DB;

try {
    $exists = DB::table('proveedor')->where('nombre', 'Samuel')->where('apellido', 'Ortiz')->exists();
    if (!$exists) {
        DB::table('proveedor')->insert([
            'nombre' => 'Samuel',
            'apellido' => 'Ortiz',
            'dni' => '12345678',
            'telefono' => '3001234567',
            'direccion' => 'SENA',
            'ruc' => '12345678901'
        ]);
        echo "SUCCESS: Proveedor Samuel Ortiz creado.\n";
    } else {
        echo "SKIP: Proveedor Samuel Ortiz ya existe.\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
