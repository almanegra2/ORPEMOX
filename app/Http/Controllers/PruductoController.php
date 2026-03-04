<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PruductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoria = DB::select("select * from categoria");
        // Se cambia a 10 según el final del video 42 y 43 para mejor vista en móvil
        $datos = DB::table("producto")
            ->join("categoria", "producto.id_categoria", "=", "categoria.id_categoria")
            ->select("producto.*", "categoria.nombre as categoria")
            ->paginate(10);

        return view("vistas.productos.indexproducto", compact("datos", "categoria"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoria = DB::select("select * from categoria");
        $datos = DB::table("producto")
            ->join("categoria", "producto.id_categoria", "=", "categoria.id_categoria")
            ->select("producto.*", "categoria.nombre as categoria")
            ->paginate(10);

        return view("vistas.productos.indexproducto", compact("categoria", "datos"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "txtcategoria" => "required",
            "txtcodigoproducto" => "required",
            "txtnombreproducto" => "required",
            "txtprecioproducto" => "required|numeric",
            "txtstock" => "required|numeric",
            "txtfoto" => "mimes:png,jpg,jpeg"
        ]);

        $producto = DB::select("select count(*) as total from producto where codigo=?", [$request->txtcodigoproducto]);

        if ($producto[0]->total > 0) {
            return back()->with("INCORRECTO", "El producto ya se encuentra registrado");
        }

        $registro = DB::table("producto")->insertGetId([
            "id_categoria" => $request->txtcategoria,
            "codigo" => $request->txtcodigoproducto,
            "nombre" => $request->txtnombreproducto,
            "precio" => $request->txtprecioproducto,
            "stock" => $request->txtstock,
            "descripcion" => $request->txtdescripcion,
            "estado" => "1"
        ]);

        try {
            $foto = $request->file("txtfoto");
            if ($foto) {
                $nombreFoto = $registro . "_" . $foto->getClientOriginalName();
                $ruta = storage_path("app/public/FOTO-PRODUCTOS/" . $nombreFoto);
                copy($foto, $ruta);
            } else {
                $nombreFoto = "";
            }
        } catch (\Throwable $th) {
            $nombreFoto = "";
        }

        try {
            DB::update("update producto set foto=? where id_producto=?", [$nombreFoto, $registro]);
        } catch (\Throwable $th) {
            // Error silencioso en foto
        }

        return back()->with("CORRECTO", "Producto registrado correctamente");
    }

    /**
     * Update the specified resource in storage. (Video 41)
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "txtcategoria" => "required",
            "txtcodigoproducto" => "required",
            "txtnombreproducto" => "required",
            "txtprecioproducto" => "required",
            "txtstock" => "required",
        ]);

        $duplicidad = DB::select("select count(*) as total from producto where codigo = ? and id_producto != ?", [
            $request->txtcodigoproducto,
            $id
        ]);

        if ($duplicidad[0]->total > 0) {
            return back()->with("INCORRECTO", "El código ya pertenece a otro producto");
        }

        try {
            DB::update("update producto set id_categoria=?, codigo=?, nombre=?, precio=?, stock=?, descripcion=? where id_producto=?", [
                $request->txtcategoria,
                $request->txtcodigoproducto,
                $request->txtnombreproducto,
                $request->txtprecioproducto,
                $request->txtstock,
                $request->txtdescripcion,
                $id
            ]);
            return back()->with("CORRECTO", "Producto actualizado correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    /**
     * Remove the specified resource from storage. (Video 42)
     */
    public function destroy(string $id)
    {
        // Se usa el código como identificador según el video
        $verificar = DB::select("select count(*) as total from producto where codigo = ?", [$id]);

        if ($verificar[0]->total <= 0) {
            return back()->with("INCORRECTO", "El producto no existe");
        }

        try {
            DB::delete("delete from producto where codigo = ?", [$id]);
            return back()->with("CORRECTO", "Producto eliminado correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al eliminar producto");
        }
    }

    /**
     * Métodos adicionales de búsqueda y gestión de archivos
     */
    public function buscarProducto(Request $request)
    {
        $id = $request->buscar;
        if ($id == null) {
            return response()->json([
                "success" => false,
                "dato" => []
            ]);
        }

        $datos = DB::select("select producto.*, categoria.nombre as categoria from producto 
            inner join categoria ON producto.id_categoria = categoria.id_categoria 
            WHERE codigo like '%$id%' or producto.nombre like '%$id%'");

        return response()->json([
            "success" => true,
            "dato" => $datos
        ]);
    }

    public function registrarFotoProducto(Request $request)
    {
        $id = $request->txtid;
        try {
            $foto = $request->file("txtfoto");
            $nombreFoto = $id . "_" . $foto->getClientOriginalName();
            $foto->move(storage_path("app/public/FOTO-PRODUCTOS"), $nombreFoto);
            DB::update("update producto set foto=? where id_producto=?", [$nombreFoto, $id]);
            return back()->with("CORRECTO", "Foto actualizada correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al registrar la foto");
        }
    }

    public function eliminarFotoProducto($id)
    {
        try {
            $producto = DB::table("producto")->where("id_producto", $id)->first();
            if ($producto && $producto->foto) {
                $ruta = storage_path("app/public/FOTO-PRODUCTOS/" . $producto->foto);
                if (File::exists($ruta)) {
                    File::delete($ruta);
                }
            }
            DB::update("update producto set foto = null where id_producto = ?", [$id]);
            return back()->with("CORRECTO", "Foto eliminada correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al eliminar la foto");
        }
    }
}