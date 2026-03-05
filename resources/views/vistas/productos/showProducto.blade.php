@extends('layouts/app')
@section('titulo', 'Datos del producto')

@section('content')

{{-- Botón Registrar Nuevo (Minuto 08:33) --}}
<div class="mb-3">
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Registrar nuevo producto
    </a>
</div>

<h4 class="text-center text-secondary">DATOS DEL PRODUCTO</h4>

<div class="mb-0 col-12 bg-white p-5 shadow-sm">
    @foreach ($datos as $producto)
    {{-- Formulario principal apuntando a UPDATE --}}
    <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <label>Categoría</label>
                <select name="txtcategoria" class="form-control">
                    @foreach ($categoria as $cat)
                        <option value="{{ $cat->id_categoria }}" @selected($cat->id_categoria == $producto->id_categoria)>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label>Código</label>
                <input type="text" name="txtcodigoproducto" class="form-control" value="{{ $producto->codigo }}" required>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label>Nombre</label>
                <input type="text" name="txtnombreproducto" class="form-control" value="{{ $producto->nombre }}" required>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label>Precio</label>
                <input type="text" name="txtprecioproducto" class="form-control" value="{{ $producto->precio }}" required>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label>Stock</label>
                <input type="number" name="txtstock" class="form-control" value="{{ $producto->stock }}" required>
            </div>

            <div class="col-12 mb-4">
                <label>Descripción</label>
                <textarea name="txtdescripcion" class="form-control" rows="2">{{ $producto->descripcion }}</textarea>
            </div>

            <div class="col-12 mb-4">
                <label>Foto del producto</label>
                <div class="border p-3 text-center">
                    @if ($producto->foto)
                        <img src="{{ asset('storage/FOTO-PRODUCTOS/' . $producto->foto) }}" width="150" class="img-thumbnail mb-2">
                        <br>
                        <div class="btn-group">
                            <a href="" data-toggle="modal" data-target="#exampleModal{{ $producto->codigo }}" class="btn btn-info btn-sm">Ver Foto</a>
                            <a href="{{ route('producto.eliminarFoto', $producto->id_producto) }}" class="btn btn-danger btn-sm">Eliminar Foto</a>
                        </div>
                    @else
                        <div class="alert alert-secondary py-2">Sin foto registrada</div>
                        <a href="" data-toggle="modal" data-target="#editar{{ $producto->codigo }}" class="btn btn-success btn-sm">
                            <i class="fas fa-camera"></i> Agregar foto
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="text-right mt-3">
            <button type="submit" class="btn btn-warning">Modificar</button>
            
            {{-- ELIMINAR VINCULADO AL FORM DE ABAJO (Minuto 05:45) --}}
            <button type="submit" class="btn btn-danger" form="formEliminar">Eliminar</button>
            
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>

    {{-- Formulario oculto para eliminar --}}
    <form action="{{ route('productos.destroy', $producto->codigo) }}" method="POST" id="formEliminar" class="formulario-eliminar">
        @csrf
        @method('DELETE')
    </form>

    {{-- Tus Modales de Foto se mantienen --}}
    <div class="modal fade" id="exampleModal{{ $producto->codigo }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100">Foto del producto</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body text-center">
                    <img style="width: 80%" src="{{ asset('storage/FOTO-PRODUCTOS/' . $producto->foto) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editar{{ $producto->codigo }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100">Subir foto</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('producto.registrarFotoProducto') }}" id="formFoto{{ $producto->id_producto }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="txtid" value="{{ $producto->id_producto }}">
                        <input class="form-control" type="file" name="txtfoto" accept=".jpg, .png, .jpeg">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="formFoto{{ $producto->id_producto }}">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection