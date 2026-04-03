<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Requerir autenticación para este controlador.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los clientes (no hay columna estado)
        $clientes = Cliente::all();
        return view('vistas.clientes.indexCliente', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // El modal cubre esta funcionalidad en la misma vista index.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $cliente = new Cliente();
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->dni = $request->dni;
            $cliente->correo = $request->correo;
            $cliente->telefono = $request->telefono;
            // No hay columna estado en esta tabla

            $cliente->save();
            DB::commit();
            return back()->with("CORRECTO", "Cliente registrado exitosamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with("INCORRECTO", "Error al registrar cliente: " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // El modal cubre esta funcionalidad en la misma vista index.
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $cliente = Cliente::findOrFail($id);
            $cliente->nombre = $request->nombre;
            $cliente->apellido = $request->apellido;
            $cliente->dni = $request->dni;
            $cliente->correo = $request->correo;
            $cliente->telefono = $request->telefono;

            $cliente->save();
            DB::commit();
            return back()->with("CORRECTO", "Datos del cliente actualizados");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with("INCORRECTO", "Error al actualizar: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $cliente = Cliente::findOrFail($id);
            // Hard delete porque no hay columna de estado
            $cliente->delete();
            DB::commit();
            return back()->with("CORRECTO", "Cliente eliminado correctamente");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with("INCORRECTO", "Error al eliminar: " . $e->getMessage());
        }
    }
}
