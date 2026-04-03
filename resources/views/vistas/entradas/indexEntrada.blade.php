@extends('layouts/app')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
<style>
    /* Remover forzado de color negro que rompe el modo oscuro */
    #example thead th { color: #000 !important; } /* Mantener negro solo en el header dorado para contraste */
    #example tbody td { color: #fff !important; }
    label { color: #fff !important; }
    .card { background: transparent !important; border: none !important; }
</style>

<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h3 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 700; letter-spacing: 1px;">
            <i class="fas fa-clipboard-list mr-2"></i> LISTADO DE ENTRADAS
        </h3>

        <div class="mb-4">
            <a href="{{ route('entradas.create') }}" class="btn btn-primary btn-glow">
                <i class="fas fa-plus-circle mr-2"></i> REGISTRAR NUEVA ENTRADA
            </a>
        </div>

        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Proveedor</th>
                        <th>Cant.</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $item)
                    <tr>
                        <td>{{ $item->id_entrada }}</td>
                        <td>{{ $item->producto_nombre }}</td>
                        <td>{{ $item->proveedor_nombre }} {{ $item->proveedor_apellido }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>${{ number_format($item->precio, 2) }}</td>
                        <td>{{ $item->fecha }}</td>
                        <td>
                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                <button data-toggle="modal" data-target="#edit{{ $item->id_entrada }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('entradas.destroy', $item->id_entrada) }}" method="POST" class="formulario-eliminar">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
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
    </div>
</div>

{{-- MODALES DE EDICIÓN --}}
@foreach ($datos as $item)
<div class="modal fade" id="edit{{ $item->id_entrada }}" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--accent-color);">
                <h5 class="modal-title" style="color: #000; font-weight: 700;">Editar Entrada #{{ $item->id_entrada }}</h5>
                <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
            </div>
            <form action="{{ route('entradas.update', $item->id_entrada) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body text-left">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Producto</label>
                            <input type="text" name="producto_nombre" list="lista_productos_edit" class="form-control input__text" value="{{ $item->producto_nombre }}" required>
                            <datalist id="lista_productos_edit">
                                @foreach($producto as $p)
                                    <option value="{{ $p->nombre }}">
                                @endforeach
                            </datalist>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-white">Proveedor</label>
                            <input type="text" name="proveedor_nombre" list="lista_proveedores_edit" class="form-control input__text" value="{{ $item->proveedor_nombre }} {{ $item->proveedor_apellido }}" required>
                            <datalist id="lista_proveedores_edit">
                                @foreach($proveedor as $pr)
                                    <option value="{{ $pr->nombre }} {{ $pr->apellido }}">
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Cantidad</label>
                            <input type="number" name="cantidad" value="{{ $item->cantidad }}" class="form-control input__text" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Precio</label>
                            <input type="number" step="0.01" name="precio" value="{{ $item->precio }}" class="form-control input__text" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-white">Fecha</label>
                        <input type="datetime-local" name="fecha" class="form-control input__text" value="{{ date('Y-m-d\TH:i', strtotime($item->fecha)) }}" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-glow">Actualizar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                }
            });
        }

        $(document).on('submit', '.formulario-eliminar', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta entrada se eliminará permanentemente!",
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