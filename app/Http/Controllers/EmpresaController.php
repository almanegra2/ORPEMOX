<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    /**
     * Show empresa data.
     */
    public function index()
    {
        $sql = Empresa::all();
        return view('vistas.empresa.empresa', compact('sql'));
    }
    /**
     * Update basic empresa information.
     */
    public function update(Request $request, $id)
    {
        try {
            $empresa = Empresa::findOrFail($id);
            $empresa->nombre = $request->nombre;
            $empresa->telefono = $request->telefono;
            $empresa->ubicacion = $request->ubicacion;
            $empresa->ruc = $request->ruc;
            $empresa->correo = $request->correo;
            $empresa->save();
            return back()->with('CORRECTO', 'Datos modificados correctamente');
        } catch (\Throwable $th) {
            return back()->with('INCORRECTO', 'Error al modificar');
        }
    }
    /**
     * Replace the empresa logo image.
     */
    public function actualizarLogo(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $file = $request->file('foto');
        $nombrearchivo = 'logo.' . strtolower($file->getClientOriginalExtension());

        $empresa = Empresa::first();
        if ($empresa && $empresa->foto) {
            Storage::delete('public/empresa/' . $empresa->foto);
        }

        $stored = Storage::putFileAs('public/empresa', $file, $nombrearchivo);

        try {
            if ($empresa) {
                $empresa->foto = $nombrearchivo;
                $empresa->save();
            }
        } catch (\Throwable $th) {
            return back()->with('INCORRECTO', 'Error al actualizar el logo');
        }

        if ($stored) {
            return back()->with('CORRECTO', 'Logo actualizado correctamente');
        }

        return back()->with('INCORRECTO', 'Error al actualizar el logo');
    }
/**
     * Delete the current empresa logo.
     */
    public function eliminarLogo()
    {
        $empresa = Empresa::first();
        $deleted = true;
        if ($empresa && $empresa->foto) {
            $deleted = Storage::delete('public/empresa/' . $empresa->foto);
            $empresa->foto = '';
            $empresa->save();
        }
        if ($deleted) {
            return back()->with('CORRECTO', 'Logo eliminado correctamente');
        }
        return back()->with('INCORRECTO', 'Error al eliminar el logo');
    }

    
}   
  