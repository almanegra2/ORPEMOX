<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    // ✅ ESTE MÉTODO FALTABA
    public function index()
    {
        $idUsuario = Auth::user()->id_usuario;
        $datos = DB::select("select * from usuario where id_usuario=$idUsuario");

        return view("vistas.perfil", compact("datos"));
    }

    public function actualizarIMG(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $file = $request->file('foto');
        $idUsuario = Auth::user()->id_usuario;

        $nombreArchivo = $idUsuario . "." . strtolower($file->getClientOriginalExtension());
        $ruta = storage_path("app/public/FOTOS-PERFIL-USUARIO/" . $nombreArchivo);

        // mover imagen correctamente
        $res = move_uploaded_file($file->getPathName(), $ruta);

        try {
            $actualizarFoto = DB::update("update usuario set foto='$nombreArchivo' where id_usuario=$idUsuario");

            if ($actualizarFoto == 0) {
                $actualizarFoto = 1;
            }

        } catch (\Throwable $th) {
            $actualizarFoto = 0;
        }

        if ($res && $actualizarFoto) {
            return back()->with("mensaje", "Imagen de perfil actualizada correctamente");
        } else {
            return back()->with("error", "Error al actualizar la imagen de perfil");
        }
    }

    public function eliminarFotoPerfil()
{
    $usuario = Auth::user();
    $nombreFoto = $usuario->foto;

    if (empty($nombreFoto)) {
        return back()->with("error", "No hay imagen para eliminar");
    }

    $ruta = storage_path("app/public/FOTOS-PERFIL-USUARIO/" . $nombreFoto);

    try {

        if (file_exists($ruta)) {
            unlink($ruta);
        }

        DB::table('usuario')
            ->where('id_usuario', $usuario->id_usuario)
            ->update(['foto' => null]);

        return back()->with("mensaje", "Imagen eliminada correctamente");

    } catch (\Throwable $th) {
        return back()->with("error", "Error al eliminar la imagen");
    }
}
  public function actualizarDatos(Request $request){
        $request->validate([
             "nombre"=> "required",
             "apellido"=> "required",
             "correo"=> "required|email",
            "usuario"=> "required",



        ] );

        $idUsuario = Auth::user()->id_usuario;
        try {
            $modificar=DB::update("update usuario set nombre=?,apellido=?, usuario=?, telefono=?, direccion=?, correo=? where id_usuario=$idUsuario",[
                $request->nombre,
                $request->apellido,
                $request->usuario,
                $request->telefono,
                $request->direccion,
                $request->correo
            ]);
            $modificar=true;
        } catch (\Throwable $th) {
            $modificar=false;

        }
        if ($modificar) {
          return back()->with("mensaje", "Datos actualizados correctamente");
        } else {
            return back()->with("error", "Error al modificar los datos");
            
        }
        

  }
}