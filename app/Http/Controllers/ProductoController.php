<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Listado de productos
     */
    public function index()
    {
        $categoria = DB::select("select * from categoria");
        $datos = DB::table("producto")
            ->join("categoria", "producto.id_categoria", "=", "categoria.id_categoria")
            ->select("producto.*", "categoria.nombre as categoria")
            ->get();

        return view("vistas.productos.indexproducto", compact("datos", "categoria"));
    }

    public function create()
    {
        $categorias = DB::select("select * from categoria");
        return view("vistas.productos.registroProductos", compact("categorias"));
    }

    /**
     * Guardar nuevo producto
     */
    public function store(Request $request)
    {
        $request->validate([
            "txtcategoria" => "required", // Ahora es el NOMBRE de la categoría
            "txtcodigoproducto" => "required",
            "txtnombreproducto" => "required",
            "txtprecioproducto" => "required|numeric",
            "txtstock" => "required|numeric",
            "txtfoto" => "nullable|image|mimes:png,jpg,jpeg|max:2048"
        ]);

        // Resolver Categoría por nombre
        $cat_nombre = trim($request->txtcategoria);
        $categoria = DB::table('categoria')->where('nombre', $cat_nombre)->first();
        if (!$categoria) {
            $disponibles = DB::table('categoria')->limit(5)->pluck('nombre')->implode(', ');
            return back()->with("INCORRECTO", "La categoría '$cat_nombre' no existe. Disponibles: $disponibles... Debes crearla primero.");
        }

        // Verificar duplicidad de código
        $existe = DB::table("producto")->where("codigo", $request->txtcodigoproducto)->exists();
        if ($existe) {
            return back()->with("INCORRECTO", "El código del producto ya existe");
        }

        try {
            $id_producto = DB::table("producto")->insertGetId([
                "id_categoria" => $categoria->id_categoria,
                "codigo" => $request->txtcodigoproducto,
                "nombre" => $request->txtnombreproducto,
                "precio" => $request->txtprecioproducto,
                "stock" => $request->txtstock,
                "descripcion" => $request->txtdescripcion,
                "estado" => "1"
            ]);

            // Manejo de la foto
            if ($request->hasFile("txtfoto")) {
                $foto = $request->file("txtfoto");
                $nombreFoto = $id_producto . "_" . time() . "." . $foto->getClientOriginalExtension();
                $foto->move(public_path("storage/FOTO-PRODUCTOS"), $nombreFoto);
                DB::table("producto")->where("id_producto", $id_producto)->update(["foto" => $nombreFoto]);
            }

            return redirect()->route('productos.index')->with("CORRECTO", "Producto registrado correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al registrar: " . $th->getMessage());
        }
    }

    public function show(string $id)
    {
        $datos = DB::select("select producto.*, categoria.nombre as nombre_categoria from producto 
                            inner join categoria on producto.id_categoria = categoria.id_categoria 
                            where id_producto = ?", [$id]);
        
        $categoria = DB::select("select * from categoria");
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

        // Resolver Categoría
        $cat_nombre = trim($request->txtcategoria);
        $categoria = DB::table('categoria')->where('nombre', $cat_nombre)->first();
        if (!$categoria) {
            return back()->with("INCORRECTO", "Categoría '$cat_nombre' no encontrada.");
        }

        // Verificar código duplicado ignorando el producto actual
        $duplicado = DB::table("producto")
            ->where("codigo", $request->txtcodigoproducto)
            ->where("id_producto", "!=", $id)
            ->exists();

        if ($duplicado) {
            return back()->with("INCORRECTO", "El código ya pertenece a otro producto");
        }

        try {
            DB::table("producto")->where("id_producto", $id)->update([
                "id_categoria" => $categoria->id_categoria,
                "codigo" => $request->txtcodigoproducto,
                "nombre" => $request->txtnombreproducto,
                "precio" => $request->txtprecioproducto,
                "stock" => $request->txtstock,
                "descripcion" => $request->txtdescripcion,
            ]);
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
            // Primero eliminamos la foto física si existe
            $producto = DB::table("producto")->where("id_producto", $id)->first();
            if ($producto && $producto->foto) {
                $ruta = public_path("storage/FOTO-PRODUCTOS/" . $producto->foto);
                if (File::exists($ruta)) { File::delete($ruta); }
            }

            DB::table("producto")->where("id_producto", $id)->delete();
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

        $datos = DB::table("producto")
            ->join("categoria", "producto.id_categoria", "=", "categoria.id_categoria")
            ->select("producto.*", "categoria.nombre as categoria")
            ->where("codigo", "like", "%$term%")
            ->orWhere("producto.nombre", "like", "%$term%")
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
            // Eliminar foto anterior si existe
            $producto = DB::table("producto")->where("id_producto", $id)->first();
            if ($producto->foto) {
                $rutaAnterior = public_path("storage/FOTO-PRODUCTOS/" . $producto->foto);
                if (File::exists($rutaAnterior)) { File::delete($rutaAnterior); }
            }

            $foto = $request->file("txtfoto");
            $nombreFoto = $id . "_" . time() . "." . $foto->getClientOriginalExtension();
            $foto->move(public_path("storage/FOTO-PRODUCTOS"), $nombreFoto);
            
            DB::table("producto")->where("id_producto", $id)->update(["foto" => $nombreFoto]);
            
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
            $producto = DB::table("producto")->where("id_producto", $id)->first();
            if ($producto && $producto->foto) {
                $ruta = public_path("storage/FOTO-PRODUCTOS/" . $producto->foto);
                if (File::exists($ruta)) { File::delete($ruta); }
                DB::table("producto")->where("id_producto", $id)->update(["foto" => null]);
            }
            return back()->with("CORRECTO", "Foto eliminada correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al eliminar la foto");
        }
    }
}