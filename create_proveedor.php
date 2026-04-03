<?php
try {
    DB::table('proveedor')->insert([
        'nombre' => 'Samuel',
        'apellido' => 'Ortiz',
        'telefono' => '3001234567',
        'direccion' => 'SENA',
        'ruc' => '12345678901',
        'dni' => '12345678',
        'estado' => 1
    ]);
    echo "Proveedor creado exitosamente.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
