@extends('layouts/app')
@section('titulo', 'Lista de categorías')

@section('content')
<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h3 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">
            <i class="fas fa-tags mr-2"></i> GESTIÓN DE CATEGORÍAS
        </h3>

        <div class="mb-4">
            <a href="{{ route('categoria.create') }}" class="btn btn-primary btn-glow">
                <i class="fas fa-plus-circle mr-2"></i> Registrar nueva categoría
            </a>
        </div>

        <div class="table-responsive">
            <table id="example" class="table table-dark table-hover border-0" style="background: rgba(0,0,0,0.2);">
                <thead style="background: rgba(255,255,255,0.05);">
                    <tr>
                        <th width="10%" style="color: var(--accent-color); border-bottom: 2px solid var(--accent-color);">ID</th>
                        <th style="color: var(--accent-color); border-bottom: 2px solid var(--accent-color);">Nombre de la Categoría</th>
                        <th width="15%" class="text-center" style="color: var(--accent-color); border-bottom: 2px solid var(--accent-color);">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $item)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td class="align-middle font-weight-bold" style="color: #ccc;">#{{ $item->id_categoria }}</td>
                            <td class="align-middle text-white">{{ $item->nombre }}</td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center" style="gap: 8px;">
                                    <button type="button" data-toggle="modal" data-target="#editCategoria{{ $item->id_categoria }}" class="btn btn-warning btn-sm btn-glow" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('categoria.destroy', $item->id_categoria) }}" method="POST" class="formulario-eliminar m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
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

{{-- MODALES FUERA DE LA TABLA --}}
@foreach ($categorias as $item)
    <div class="modal fade" id="editCategoria{{ $item->id_categoria }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background: #111; border: 1px solid rgba(255,255,255,0.1);">
                <div class="modal-header" style="background: var(--accent-color); border-bottom: none;">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Modificar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <form action="{{ route('categoria.update', $item->id_categoria) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body py-4">
                        <div class="form-group mb-0">
                            <label class="text-white mb-2 ml-1">Nombre de la Categoría</label>
                            <input type="text" name="txtnombre" class="form-control input__text" value="{{ $item->nombre }}" placeholder="Ingrese el nombre..." required>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicializar DataTable
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

        // Confirmación de eliminación
        $(document).on('submit', '.formulario-eliminar', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará la categoría de forma permanente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) { this.submit(); }
            });
        });
    });
</script>
@endpush