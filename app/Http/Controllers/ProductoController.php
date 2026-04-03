<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\File;

class ProductoController extends Controller
{
    /**
     * Listado de productos
     */
    public function index()
    {
        $datos = Producto::with('categoria')->get();
        $categoria = Categoria::all();
        return view("vistas.productos.indexproducto", compact("datos", "categoria"));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view("vistas.productos.registroProductos", compact("categorias"));
    }

    /**
     * Guardar nuevo producto
     */
    public function store(Request $request)
    {
        $request->validate([
            "txtcategoria" => "required",
            "txtcodigoproducto" => "required",
            "txtnombreproducto" => "required",
            "txtprecioproducto" => "required|numeric",
            "txtstock" => "required|numeric",
            "txtfoto" => "nullable|image|mimes:png,jpg,jpeg|max:2048"
        ]);

        $cat_nombre = trim($request->txtcategoria);
        $categoria = Categoria::where('nombre', $cat_nombre)->first();
        if (!$categoria) {
            $disponibles = Categoria::limit(5)->pluck('nombre')->implode(', ');
            return back()->with("INCORRECTO", "La categoría '$cat_nombre' no existe. Disponibles: $disponibles... Debes crearla primero.");
        }

        if (Producto::where("codigo", $request->txtcodigoproducto)->exists()) {
            return back()->with("INCORRECTO", "El código del producto ya existe");
        }

        $producto = new Producto([
            "id_categoria" => $categoria->id_categoria,
            "codigo" => $request->txtcodigoproducto,
            "nombre" => $request->txtnombreproducto,
            "precio" => $request->txtprecioproducto,
            "stock" => $request->txtstock,
            "descripcion" => $request->txtdescripcion,
            "estado" => 1
        ]);
        $producto->save();

        if ($request->hasFile("txtfoto")) {
            $foto = $request->file("txtfoto");
            $nombreFoto = $producto->id_producto . "_" . time() . "." . $foto->getClientOriginalExtension();
            $foto->move(public_path("storage/FOTO-PRODUCTOS"), $nombreFoto);
            $producto->foto = $nombreFoto;
            $producto->save();
        }

        return redirect()->route('productos.index')->with("CORRECTO", "Producto registrado correctamente");
    }

    public function show(string $id)
    {
        $datos = Producto::with('categoria')->where('id_producto', $id)->get();
        $categoria = Categoria::all();
        return view("vistas.productos.showProducto", compact("datos", "categoria"));
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "txtcategoria" => "required",
            "txtcodigoproducto" => "required",
            "txtnombreproducto" => "required",
            "txtprecioproducto" => "required|numeric",
            "txtstock" => "required|numeric",
        ]);

        $cat_nombre = trim($request->txtcategoria);
        $categoria = Categoria::where('nombre', $cat_nombre)->first();
        if (!$categoria) {
            return back()->with("INCORRECTO", "Categoría '$cat_nombre' no encontrada.");
        }

        $duplicado = Producto::where("codigo", $request->txtcodigoproducto)
            ->where("id_producto", "!=", $id)
            ->exists();
        if ($duplicado) {
            return back()->with("INCORRECTO", "El código ya pertenece a otro producto");
        }

        try {
            $producto = Producto::findOrFail($id);
            $producto->id_categoria = $categoria->id_categoria;
            $producto->codigo = $request->txtcodigoproducto;
            $producto->nombre = $request->txtnombreproducto;
            $producto->precio = $request->txtprecioproducto;
            $producto->stock = $request->txtstock;
            $producto->descripcion = $request->txtdescripcion;
            $producto->save();
            return redirect()->route('productos.index')->with("CORRECTO", "Producto actualizado correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    /**
     * Eliminar producto
     */
    public function destroy(string $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            if ($producto->foto) {
                $ruta = public_path("storage/FOTO-PRODUCTOS/" . $producto->foto);
                if (File::exists($ruta)) { File::delete($ruta); }
            }
            $producto->delete();
            return redirect()->route('productos.index')->with("CORRECTO", "Producto eliminado correctamente");
        } catch (\Throwable $th) {
            return redirect()->route('productos.index')->with("INCORRECTO", "No se puede eliminar el producto (posiblemente tiene ventas asociadas)");
        }
    }

    /**
     * Buscador AJAX
     */
    public function buscarProducto(Request $request)
    {
        $term = $request->buscar;
        if (!$term) {
            return response()->json(["success" => false, "dato" => []]);
        }

        $datos = Producto::with('categoria')
            ->where('codigo', 'like', "%$term%")
            ->orWhere('nombre', 'like', "%$term%")
            ->get();

        return response()->json(["success" => true, "dato" => $datos]);
    }

    /**
     * Registro/Cambio de foto desde Modal
     */
    public function registrarFotoProducto(Request $request)
    {
        $id = $request->txtid;
        $request->validate(["txtfoto" => "required|image|max:2048"]);

        try {
            $producto = Producto::findOrFail($id);
            if ($producto->foto) {
                $rutaAnterior = public_path("storage/FOTO-PRODUCTOS/" . $producto->foto);
                if (File::exists($rutaAnterior)) { File::delete($rutaAnterior); }
            }

            $foto = $request->file("txtfoto");
            $nombreFoto = $id . "_" . time() . "." . $foto->getClientOriginalExtension();
            $foto->move(public_path("storage/FOTO-PRODUCTOS"), $nombreFoto);
            $producto->foto = $nombreFoto;
            $producto->save();
            return back()->with("CORRECTO", "Foto actualizada correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al procesar la imagen");
        }
    }

    /**
     * Eliminar solo la foto
     */
    public function eliminarFotoProducto($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            if ($producto->foto) {
                $ruta = public_path("storage/FOTO-PRODUCTOS/" . $producto->foto);
                if (File::exists($ruta)) { File::delete($ruta); }
                $producto->foto = null;
                $producto->save();
            }
            return back()->with("CORRECTO", "Foto eliminada correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al eliminar la foto");
        }
    }
}