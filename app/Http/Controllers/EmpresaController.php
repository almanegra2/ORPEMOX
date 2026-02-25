<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index()
    {
        try {
            $sql = DB::select('select * from empresa');
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('vistas/empresa/empresa', compact("sql"));
    }
    public function update(Request $request,$id)
    {
        try {
            $sql = DB::update('update empresa set nombre=?, telefono=?, ubicacion=?, ruc=?,correo=? where id_empresa=?', [
                $request->nombre,
                $request->telefono,
                $request->ubicacion,
                $request->ruc,
                $request->correo,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with('CORRECTO', 'Datos modificados correctamente');
        } else {
            return back()->with('INCORRECTO', 'Error al modificar');
        }
        
    }
}
