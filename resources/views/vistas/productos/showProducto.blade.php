@extends('layouts/app')
@section('titulo', 'Datos del producto')

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h3 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 700; letter-spacing: 1px;">
            <i class="fas fa-eye mr-2"></i> DETALLES DEL PRODUCTO
        </h3>

        <div class="mb-4">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Volver al listado
            </a>
            <a href="{{ route('productos.create') }}" class="btn btn-primary btn-glow ml-2">
                <i class="fas fa-plus-circle mr-2"></i> Registrar nuevo producto
            </a>
        </div>

        @foreach ($datos as $producto)
        <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-12 col-md-6 mb-4">
                    <label class="text-white">Categoría</label>
                    <input type="text" name="txtcategoria" list="lista_categorias_show" class="form-control input__text" value="{{ $producto->nombre_categoria }}" required>
                    <datalist id="lista_categorias_show">
                        @foreach ($categoria as $cat)
                            <option value="{{ $cat->nombre }}">
                        @endforeach
                    </datalist>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label class="text-white">Código</label>
                    <input type="text" name="txtcodigoproducto" class="form-control input__text" value="{{ $producto->codigo }}" required>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label class="text-white">Nombre</label>
                    <input type="text" name="txtnombreproducto" class="form-control input__text" value="{{ $producto->nombre }}" required>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label class="text-white">Precio</label>
                    <input type="number" step="0.01" name="txtprecioproducto" class="form-control input__text" value="{{ $producto->precio }}" required>
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label class="text-white">Stock Actual</label>
                    <input type="number" name="txtstock" class="form-control input__text" value="{{ $producto->stock }}" required>
                </div>

                <div class="col-12 mb-4">
                    <label class="text-white">Descripción</label>
                    <textarea name="txtdescripcion" class="form-control input__text" rows="3">{{ $producto->descripcion }}</textarea>
                </div>

                <div class="col-12 mb-4">
                    <label class="text-white">Foto del producto</label>
                    <div class="glass-panel p-4 text-center" style="background: rgba(255,255,255,0.02);">
                        @if ($producto->foto)
                            <img src="{{ asset('storage/FOTO-PRODUCTOS/' . $producto->foto) }}" width="200" class="img-thumbnail mb-3" style="background: transparent; border-color: var(--accent-color);">
                            <br>
                            <div class="btn-group">
                                <a href="" data-toggle="modal" data-target="#exampleModal{{ $producto->codigo }}" class="btn btn-primary btn-glow btn-sm">Ver Pantalla Completa</a>
                                <a href="{{ route('producto.eliminarFoto', $producto->id_producto) }}" class="btn btn-danger btn-sm">Eliminar Foto</a>
                            </div>
                        @else
                            <div class="alert alert-dark py-3 mb-3" style="background: rgba(255,255,255,0.05); color: #ccc; border: 1px dashed rgba(255,255,255,0.2);">
                                <i class="fas fa-image fa-2x mb-2 d-block"></i>
                                Sin foto registrada
                            </div>
                            <a href="" data-toggle="modal" data-target="#editar{{ $producto->codigo }}" class="btn btn-primary btn-glow btn-sm">
                                <i class="fas fa-camera mr-1"></i> Agregar foto ahora
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-right mt-3">
                <button type="submit" class="btn btn-warning btn-glow" style="font-weight: 600;">Modificar Datos</button>
                <button type="button" class="btn btn-danger ml-2" id="btnEliminarManual">Eliminar Producto</button>
            </div>
        </form>

        {{-- Formulario oculto para eliminar --}}
        <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" id="formEliminar" class="formulario-eliminar">
            @csrf
            @method('DELETE')
        </form>

        @endforeach
    </div>
</div>

{{-- MODALES FUERA DEL PANEL PARA EVITAR PROBLEMAS DE STACKING CONTEXT --}}
@foreach ($datos as $producto)
    <div class="modal fade" id="exampleModal{{ $producto->codigo }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: #111; border: 1px solid rgba(255,255,255,0.1);">
                <div class="modal-header" style="background: var(--accent-color);">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Vista previa de imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <div class="modal-body text-center bg-black">
                    <img style="max-width: 100%" src="{{ asset('storage/FOTO-PRODUCTOS/' . $producto->foto) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editar{{ $producto->codigo }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background: #111; border: 1px solid rgba(255,255,255,0.1);">
                <div class="modal-header" style="background: var(--accent-color);">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Subir foto del producto</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('producto.registrarFotoProducto') }}" id="formFoto{{ $producto->id_producto }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="txtid" value="{{ $producto->id_producto }}">
                        <label class="text-white mb-2">Seleccione el archivo</label>
                        <input class="form-control input__text" type="file" name="txtfoto" accept=".jpg, .png, .jpeg" required>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="submit" class="btn btn-primary btn-glow" form="formFoto{{ $producto->id_producto }}">Guardar Imagen</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    $(document).ready(function() {
        $('#btnEliminarManual').click(function() {
            $('.formulario-eliminar').submit();
        });

        $(document).on('submit', '.formulario-eliminar', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Este producto se eliminará de forma permanente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush

@endsection