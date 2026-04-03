<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    public function index()
    {
        $datos = DB::select("
            SELECT e.*, p.nombre AS producto_nombre, pr.nombre AS proveedor_nombre, pr.apellido AS proveedor_apellido
            FROM entrada e
            INNER JOIN producto p ON e.id_producto = p.id_producto
            INNER JOIN proveedor pr ON e.id_proveedor = pr.id_proveedor
        ");

        $producto = DB::select("SELECT id_producto, nombre FROM producto");
        $proveedor = DB::select("SELECT id_proveedor, nombre, apellido FROM proveedor");

        return view('vistas.entradas.indexEntrada', compact('datos', 'producto', 'proveedor'));
    }

    public function create()
    {
        $producto = DB::select("SELECT id_producto, nombre FROM producto");
        $proveedor = DB::select("SELECT id_proveedor, nombre, apellido FROM proveedor");
        return view('vistas.entradas.registroEntrada', compact('producto', 'proveedor'));
    }

    public function store(Request $request)
    {
        try {
            $prod_nombre = trim($request->producto_nombre);
            $prov_nombre = trim($request->proveedor_nombre);

            // Resolver producto por nombre
            $producto = DB::table('producto')->where('nombre', $prod_nombre)->first();
            if (!$producto) {
                $disponibles = DB::table('producto')->limit(5)->pluck('nombre')->implode(', ');
                return back()->with('INCORRECTO', "El producto '$prod_nombre' no existe en la base de datos. Disponibles: $disponibles...");
            }

            // Resolver proveedor (Nombre solo o Nombre + Apellido)
            $proveedor = DB::table('proveedor')
                ->where(function($query) use ($prov_nombre) {
                    $query->where('nombre', $prov_nombre)
                          ->orWhereRaw("TRIM(CONCAT(nombre, ' ', IFNULL(apellido, ''))) = ?", [$prov_nombre]);
                })->first();
            
            if (!$proveedor) {
                $disponibles = DB::table('proveedor')->limit(5)->selectRaw("TRIM(CONCAT(nombre, ' ', IFNULL(apellido, ''))) as full_name")->pluck('full_name')->implode(', ');
                return back()->with('INCORRECTO', "El proveedor '$prov_nombre' no existe. Registrados: $disponibles... Debes registrarlo primero.");
            }

            DB::table('entrada')->insert([
                'id_producto' => $producto->id_producto,
                'id_proveedor' => $proveedor->id_proveedor,
                'cantidad' => $request->cantidad,
                'precio' => $request->precio,
                'fecha' => $request->fecha,
            ]);
            return redirect()->route('entradas.index')->with('CORRECTO', 'Entrada registrada con éxito');
        } catch (\Exception $e) {
            return back()->with('INCORRECTO', 'Error al registrar: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $prod_nombre = trim($request->producto_nombre);
            $prov_nombre = trim($request->proveedor_nombre);

            // Resolver producto por nombre
            $producto = DB::table('producto')->where('nombre', $prod_nombre)->first();
            if (!$producto) {
                $disponibles = DB::table('producto')->limit(5)->pluck('nombre')->implode(', ');
                return back()->with('INCORRECTO', "El producto '$prod_nombre' no existe. Disponibles: $disponibles...");
            }

            // Resolver proveedor
            $proveedor = DB::table('proveedor')
                ->where(function($query) use ($prov_nombre) {
                    $query->where('nombre', $prov_nombre)
                          ->orWhereRaw("TRIM(CONCAT(nombre, ' ', IFNULL(apellido, ''))) = ?", [$prov_nombre]);
                })->first();
            
            if (!$proveedor) {
                $disponibles = DB::table('proveedor')->limit(5)->selectRaw("TRIM(CONCAT(nombre, ' ', IFNULL(apellido, ''))) as full_name")->pluck('full_name')->implode(', ');
                return back()->with('INCORRECTO', "El proveedor '$prov_nombre' no existe. Registrados: $disponibles...");
            }

            DB::table('entrada')->where('id_entrada', $id)->update([
                'id_producto' => $producto->id_producto,
                'id_proveedor' => $proveedor->id_proveedor,
                'cantidad' => $request->cantidad,
                'precio' => $request->precio,
                'fecha' => $request->fecha,
            ]);
            return redirect()->route('entradas.index')->with('CORRECTO', 'Entrada actualizada con éxito');
        } catch (\Exception $e) {
            return back()->with('INCORRECTO', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    // ESTA FUNCIÓN ES LA QUE HACE FUNCIONAR EL BOTÓN ROJO
    public function destroy($id)
    {
        try {
            DB::table('entrada')->where('id_entrada', $id)->delete();
            return redirect()->route('entradas.index')->with('CORRECTO', 'Entrada eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('INCORRECTO', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}