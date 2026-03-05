<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    /**
     * Muestra la vista del perfil con los datos del usuario
     */
    public function index()
    {
        $idUsuario = Auth::user()->id_usuario;
        $datos = DB::select("select * from usuario where id_usuario=$idUsuario");

        return view("vistas.perfil", compact("datos"));
    }

    /**
     * Actualiza la imagen de perfil del usuario
     */
    public function actualizarIMG(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $file = $request->file('foto');
        $idUsuario = Auth::user()->id_usuario;

        $nombreArchivo = $idUsuario . "." . strtolower($file->getClientOriginalExtension());
        $ruta = storage_path("app/public/FOTOS-PERFIL-USUARIO/" . $nombreArchivo);

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

    /**
     * Elimina la foto de perfil del usuario y del servidor
     */
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

    /**
     * Actualiza los datos generales (nombre, correo, etc) del usuario
     */
    public function actualizarDatos(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "apellido" => "required",
            "correo" => "required|email",
            "usuario" => "required",
        ]);

        $idUsuario = Auth::user()->id_usuario;
        try {
            DB::update("update usuario set nombre=?, apellido=?, usuario=?, telefono=?, direccion=?, correo=? where id_usuario=$idUsuario", [
                $request->nombre,
                $request->apellido,
                $request->usuario,
                $request->telefono,
                $request->direccion,
                $request->correo
            ]);
            $modificar = true;
        } catch (\Throwable $th) {
            $modificar = false;
        }

        if ($modificar) {
            return back()->with("mensaje", "Datos actualizados correctamente");
        } else {
            return back()->with("error", "Error al modificar los datos");
        }
    }

    // ==========================================================
    // MÉTODOS DEL VIDEO 45: CAMBIO DE CONTRASEÑA
    // ==========================================================

    /**
     * Retorna la vista para cambiar la contraseña
     */
    public function cambiarClave()
    {
        return view("vistas.cambiarClave");
    }

    /**
     * Procesa el cambio de contraseña validando la actual
     */
    public function actualizarClave(Request $request)
    {
        // 1. Validar campos (Usando nombres con guion bajo para que coincidan con la vista corregida)
        $request->validate([
            'clave_actual' => 'required',
            'clave_nueva' => 'required'
        ]);

        $idUsuario = Auth::user()->id_usuario;
        $claveActualForm = $request->clave_actual;
        $claveNuevaForm = $request->clave_nueva;

        // 2. Obtener clave actual de la BD
        $usuario = DB::select("select password from usuario where id_usuario = ?", [$idUsuario]);
        
        if (empty($usuario)) {
             return back()->with("INCORRECTO", "Usuario no encontrado");
        }

        $claveBD = $usuario[0]->password;

        // 3. Verificar si la clave actual escrita coincide con la encriptada en la BD
        if (Hash::check($claveActualForm, $claveBD)) {
            try {
                // 4. Encriptar nueva clave y actualizar
                $nuevaClaveHash = Hash::make($claveNuevaForm);
                DB::update("update usuario set password = ? where id_usuario = ?", [$nuevaClaveHash, $idUsuario]);
                
                return back()->with("CORRECTO", "La contraseña se ha actualizado correctamente");
            } catch (\Throwable $th) {
                return back()->with("INCORRECTO", "Error al actualizar la contraseña en la base de datos");
            }
        } else {
            // Si el Hash::check falla
            return back()->with("INCORRECTO", "La contraseña actual no es correcta");
        }
    }
}