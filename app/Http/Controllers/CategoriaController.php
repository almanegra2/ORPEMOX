<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view("vistas/categoria/indexCategoria", compact("categorias"));
    }

    public function create()
    {
        return view("vistas/categoria/registroCategoria");
    }

    public function store(Request $request)
    {
        $request->validate(['txtnombre' => 'required']);

        if (Categoria::where('nombre', $request->txtnombre)->exists()) {
            return back()->with("INCORRECTO", "La categoría ya existe");
        }

        try {
            Categoria::create(['nombre' => $request->txtnombre]);
            return redirect()->route('categoria.index')->with("CORRECTO", "Categoría registrada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate(['txtnombre' => 'required']);

        if (Categoria::where('nombre', $request->txtnombre)->where('id_categoria', '!=', $id)->exists()) {
            return back()->with("INCORRECTO", "El nombre de la categoría ya existe");
        }

        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->nombre = $request->txtnombre;
            $categoria->save();
            return redirect()->route('categoria.index')->with("CORRECTO", "Categoría actualizada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    public function destroy(string $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();
            return back()->with("CORRECTO", "Categoría eliminada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "No se puede eliminar (está siendo usada por productos)");
        }
    }
}   