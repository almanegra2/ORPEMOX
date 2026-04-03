<?php

namespace App\Http\Controllers;
use App\Models\Usuario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UsuarioController extends Controller
{
    public function index()
    {
        $sql = "SELECT usuario.*, tipo_usuario.tipo 
                FROM usuario 
                INNER JOIN tipo_usuario ON usuario.tipo_usuario = tipo_usuario.id_tipo
                WHERE estado = 1"; 
        $datos = DB::select($sql);
        $tipos = DB::select("SELECT * FROM tipo_usuario");

        return view("vistas/usuario/indexUsuario", compact("datos", "tipos"));
    }

    public function create()
    {
        $tipos = DB::select("SELECT * FROM tipo_usuario");
        return view("vistas/usuario/registroUsuario", compact("tipos"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "txttipo" => "required",
            "txtnombre" => "required",
            "txtusuario" => "required|unique:usuario,usuario",
            "txtcorreo" => "required|email|unique:usuario,correo",
            "txtpassword" => ["required", \Illuminate\Validation\Rules\Password::min(8)->max(12)->mixedCase()->numbers()->symbols()],
            "txtfoto" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);

        try {
            $id = DB::table("usuario")->insertGetId([
                "tipo_usuario" => $request->txttipo,
                "nombre" => $request->txtnombre,
                "apellido" => $request->txtapellido,
                "usuario" => $request->txtusuario,
                "password" => bcrypt($request->txtpassword),
                "telefono" => $request->txttelefono,
                "direccion" => $request->txtdireccion,
                "correo" => $request->txtcorreo,
                "foto" => null,
                "estado" => 1 
            ]);

            if ($request->hasFile("txtfoto")) {
                $foto = $request->file("txtfoto");
                $nombreFoto = $id . "_" . time() . "." . $foto->getClientOriginalExtension();
                $foto->move(public_path("storage/FOTO-USUARIOS"), $nombreFoto);
                DB::table("usuario")->where("id_usuario", $id)->update(["foto" => $nombreFoto]);
            }

            return redirect()->route("usuario.index")->with("CORRECTO", "Usuario registrado con éxito");

        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al registrar: " . $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "txttipo" => "required",
            "txtnombre" => "required",
            "txtusuario" => "required|unique:usuario,usuario," . $id . ",id_usuario",
            "txtcorreo" => "required|email|unique:usuario,correo," . $id . ",id_usuario",
        ]);

        try {
            DB::table("usuario")->where("id_usuario", $id)->update([
                "tipo_usuario" => $request->txttipo,
                "nombre" => $request->txtnombre,
                "apellido" => $request->txtapellido,
                "usuario" => $request->txtusuario,
                "telefono" => $request->txttelefono,
                "direccion" => $request->txtdireccion,
                "correo" => $request->txtcorreo,
            ]);

            return back()->with("CORRECTO", "Datos actualizados correctamente");
        } catch (\Throwable $th) {
            return back()->withErrors(['error_update' => $id])->with("INCORRECTO", "Error al actualizar: " . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            if ($usuario->foto) {
                $rutaFoto = public_path("storage/FOTO-USUARIOS/" . $usuario->foto);
                if (file_exists($rutaFoto)) { unlink($rutaFoto); }
            }
            $usuario->delete();
            return back()->with("CORRECTO", "Usuario borrado permanentemente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "No se puede eliminar: El usuario tiene registros asociados.");
        }
    }

    public function registrarFotoUsuario(Request $request)
    {
        $request->validate(["txtfoto" => "required|image|max:2048"]);

        try {
            $usuario = Usuario::findOrFail($request->txtid);
            $foto = $request->file("txtfoto");
            $nombreFoto = "usuario_" . $usuario->id_usuario . "_" . time() . "." . $foto->getClientOriginalExtension();
            if ($usuario->foto && file_exists(public_path("storage/FOTO-USUARIOS/" . $usuario->foto))) {
                unlink(public_path("storage/FOTO-USUARIOS/" . $usuario->foto));
            }
            $foto->move(public_path("storage/FOTO-USUARIOS"), $nombreFoto);
            $usuario->foto = $nombreFoto;
            $usuario->save();
            return back()->with("CORRECTO", "Foto actualizada");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error: " . $th->getMessage());
        }
    }

    public function eliminarFotoUsuario(Request $request)
    {
        try {
            $usuario = Usuario::findOrFail($request->id);
            if ($usuario->foto) {
                $ruta = public_path("storage/FOTO-USUARIOS/" . $usuario->foto);
                if (file_exists($ruta)) { unlink($ruta); }
                $usuario->foto = null;
                $usuario->save();
                return back()->with("CORRECTO", "Foto eliminada");
            }
            return back()->with("INCORRECTO", "No hay foto para eliminar");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al eliminar la foto");
        }
    }
}