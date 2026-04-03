@extends('layouts/app')
@section('titulo', 'Lista de productos')

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h3 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 700; letter-spacing: 1px;">
            <i class="fas fa-th-list mr-2"></i> PRODUCTOS
        </h3>

{{-- BOTÓN REGISTRAR NUEVO PRODUCTO --}}
<div class="mb-3">
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Registrar nuevo producto
    </a>
</div>

{{-- TABLA PRINCIPAL --}}
<div id="tablaPrincipal">
    <section class="card">
        <div class="card-block">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead class="table-primary">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoria</th>
                        <th>Foto</th>
                        <th width="120px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $item)
                    <tr>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->precio }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->categoria }}</td>
                        <td>
                            @if ($item->foto == "" || $item->foto == null)
                                <a data-toggle="modal" data-target="#subirFoto{{ $item->id_producto }}" class="btn btn-warning btn-glow btn-sm" style="width: 100px;">Agregar foto</a>
                            @else
                                <a data-toggle="modal" data-target="#verFoto{{ $item->id_producto }}" class="btn btn-primary btn-glow btn-sm" style="width: 100px;">Ver foto</a>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                <a href="{{ route('productos.show',$item->id_producto) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" data-toggle="modal" data-target="#editProducto{{ $item->id_producto }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('productos.destroy',$item->id_producto) }}" method="POST" class="formulario-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    </div>
</div>

{{-- MODALES FUERA DE LA TABLA --}}
@foreach ($datos as $item)
    {{-- MODAL VER FOTO --}}
    <div class="modal fade" id="verFoto{{ $item->id_producto }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background: #111; border: 1px solid rgba(255,255,255,0.1);">
                <div class="modal-header" style="background: var(--accent-color);">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Foto del producto</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <div class="modal-body text-center bg-black">
                    <img width="80%" src="{{ asset('storage/FOTO-PRODUCTOS/'.$item->foto) }}">
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="{{ route('producto.eliminarFoto',$item->id_producto) }}" class="btn btn-danger">Eliminar Foto</a>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL SUBIR FOTO --}}
    <div class="modal fade" id="subirFoto{{ $item->id_producto }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background: #111; border: 1px solid rgba(255,255,255,0.1);">
                <div class="modal-header" style="background: var(--accent-color);">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Subir foto de producto</h5>
                    <button class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="formFoto{{ $item->id_producto }}" action="{{ route('producto.registrarFotoProducto') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="txtid" value="{{ $item->id_producto }}">
                        <label class="text-white mb-2">Seleccione la imagen</label>
                        <input class="form-control input__text" type="file" name="txtfoto" accept=".jpg,.png,.jpeg" required>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form="formFoto{{ $item->id_producto }}" class="btn btn-primary btn-glow">Guardar Imagen</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR PRODUCTO --}}
    <div class="modal fade" id="editProducto{{ $item->id_producto }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: #111; border: 1px solid rgba(255,255,255,0.1);">
                <div class="modal-header" style="background: var(--accent-color);">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Editar producto: {{ $item->nombre }}</h5>
                    <button class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('productos.update',$item->id_producto) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Categoría</label>
                                <input type="text" name="txtcategoria" list="lista_categorias_edit" class="form-control input__text" value="{{ $item->categoria }}" required>
                                <datalist id="lista_categorias_edit">
                                    @foreach ($categoria as $cat)
                                        <option value="{{ $cat->nombre }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Código</label>
                                <input class="form-control input__text" name="txtcodigoproducto" value="{{ $item->codigo }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Nombre</label>
                                <input class="form-control input__text" name="txtnombreproducto" value="{{ $item->nombre }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Precio</label>
                                <input type="number" step="0.01" class="form-control input__text" name="txtprecioproducto" value="{{ $item->precio }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Stock</label>
                                <input type="number" class="form-control input__text" name="txtstock" value="{{ $item->stock }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="text-white">Descripción</label>
                                <textarea class="form-control input__text" name="txtdescripcion" rows="3">{{ $item->descripcion }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer px-0 pb-0" style="border-top: none;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary btn-glow">Actualizar Productos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

{{-- SECCIÓN DE SCRIPTS --}}
@push('scripts')
<script>
$(document).ready(function() {
    if (!$.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable({
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sSearch":         "Buscar:",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                }
            }
        });
    }

    // Initialize Select2 for modals (requires dropdownParent)
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('.select2-modal').select2({
            dropdownParent: $(this),
            width: '100%'
        });
    });
});

// CONFIRMACIÓN DE ELIMINACIÓN CON SWEETALERT2
$(document).on('submit', '.formulario-eliminar', function(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Este producto se eliminará permanentemente!",
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
</script>
@endpush