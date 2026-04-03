<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrada;
use App\Models\Producto;
use App\Models\Proveedor;

class EntradaController extends Controller
{
    public function index()
    {
        $datos = Entrada::with(['producto', 'proveedor'])->get();
        $producto = Producto::select('id_producto', 'nombre')->get();
        $proveedor = Proveedor::select('id_proveedor', 'nombre', 'apellido')->get();
        return view('vistas.entradas.indexEntrada', compact('datos', 'producto', 'proveedor'));
    }

    public function create()
    {
        $producto = Producto::select('id_producto', 'nombre')->get();
        $proveedor = Proveedor::select('id_proveedor', 'nombre', 'apellido')->get();
        return view('vistas.entradas.registroEntrada', compact('producto', 'proveedor'));
    }

    public function store(Request $request)
    {
        try {
            $prod_nombre = trim($request->producto_nombre);
            $prov_nombre = trim($request->proveedor_nombre);

            $producto = Producto::where('nombre', $prod_nombre)->first();
            if (!$producto) {
                $disponibles = Producto::limit(5)->pluck('nombre')->implode(', ');
                return back()->with('INCORRECTO', "El producto '$prod_nombre' no existe en la base de datos. Disponibles: $disponibles...");
            }

            $proveedor = Proveedor::where(function($query) use ($prov_nombre) {
                $query->where('nombre', $prov_nombre)
                      ->orWhereRaw("TRIM(CONCAT(nombre, ' ', IFNULL(apellido, ''))) = ?", [$prov_nombre]);
            })->first();
            if (!$proveedor) {
                $disponibles = Proveedor::limit(5)->selectRaw("TRIM(CONCAT(nombre, ' ', IFNULL(apellido, ''))) as full_name")->pluck('full_name')->implode(', ');
                return back()->with('INCORRECTO', "El proveedor '$prov_nombre' no existe. Registrados: $disponibles... Debes registrarlo primero.");
            }

            Entrada::create([
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

            $producto = Producto::where('nombre', $prod_nombre)->first();
            if (!$producto) {
                $disponibles = Producto::limit(5)->pluck('nombre')->implode(', ');
                return back()->with('INCORRECTO', "El producto '$prod_nombre' no existe. Disponibles: $disponibles...");
            }

            $proveedor = Proveedor::where(function($query) use ($prov_nombre) {
                $query->where('nombre', $prov_nombre)
                      ->orWhereRaw("TRIM(CONCAT(nombre, ' ', IFNULL(apellido, ''))) = ?", [$prov_nombre]);
            })->first();
            if (!$proveedor) {
                $disponibles = Proveedor::limit(5)->selectRaw("TRIM(CONCAT(nombre, ' ', IFNULL(apellido, ''))) as full_name")->pluck('full_name')->implode(', ');
                return back()->with('INCORRECTO', "El proveedor '$prov_nombre' no existe. Registrados: $disponibles...");
            }

            $entrada = Entrada::findOrFail($id);
            $entrada->id_producto = $producto->id_producto;
            $entrada->id_proveedor = $proveedor->id_proveedor;
            $entrada->cantidad = $request->cantidad;
            $entrada->precio = $request->precio;
            $entrada->fecha = $request->fecha;
            $entrada->save();
            return redirect()->route('entradas.index')->with('CORRECTO', 'Entrada actualizada con éxito');
        } catch (\Exception $e) {
            return back()->with('INCORRECTO', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    // ESTA FUNCIÓN ES LA QUE HACE FUNCIONAR EL BOTÓN ROJO
    public function destroy($id)
    {
        try {
            $entrada = Entrada::findOrFail($id);
            $entrada->delete();
            return redirect()->route('entradas.index')->with('CORRECTO', 'Entrada eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('INCORRECTO', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}