@extends('layouts.app')

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h2 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
            <i class="fas fa-user-tie mr-2"></i> LISTA DE CLIENTES
        </h2>

        @if (session('CORRECTO'))
            <script>Swal.fire({ icon: 'success', title: '¡Éxito!', text: "{{ session('CORRECTO') }}", timer: 3000 });</script>
        @endif
        @if (session('INCORRECTO'))
            <script>Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('INCORRECTO') }}" });</script>
        @endif

        <div class="mb-4 text-right">
            <button class="btn btn-primary btn-glow" data-toggle="modal" data-target="#modalRegistrar">
                <i class="fas fa-plus-circle mr-1"></i> Registrar nuevo cliente
            </button>
        </div>

        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered text-center align-middle" style="width:100%">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>DNI/DOC</th>
                        <th>TELÉFONO</th>
                        <th>CORREO</th>
                        <th width="120px">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $item)
                        <tr>
                            <td>{{ $item->id_cliente }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->apellido }}</td>
                            <td>{{ $item->dni }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>{{ $item->correo }}</td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 5px;">
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditar{{ $item->id_cliente }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('clientes.destroy', $item->id_cliente) }}" method="POST" class="formulario-eliminar">
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
    </div>
</div>

{{-- MODAL REGISTRAR CLIENTE --}}
<div class="modal fade" id="modalRegistrar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: var(--accent-color); border-bottom: none;">
                <h5 class="modal-title" style="color: #000; font-weight: 700;"><i class="fas fa-user-plus mr-2"></i> Registrar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
            </div>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="modal-body text-left">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Nombre</label>
                            <input type="text" name="nombre" class="form-control input__text" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Apellido</label>
                            <input type="text" name="apellido" class="form-control input__text" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">DNI / Documento</label>
                            <input type="text" name="dni" class="form-control input__text" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Teléfono</label>
                            <input type="text" name="telefono" class="form-control input__text" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-white">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control input__text" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODALES EDITAR CLIENTE --}}
@foreach ($clientes as $item)
<div class="modal fade" id="modalEditar{{ $item->id_cliente }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: var(--accent-color); border-bottom: none;">
                <h5 class="modal-title" style="color: #000; font-weight: 700;"><i class="fas fa-user-edit mr-2"></i> Modificar Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
            </div>
            <form action="{{ route('clientes.update', $item->id_cliente) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body text-left">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Nombre</label>
                            <input type="text" name="nombre" class="form-control input__text" value="{{ $item->nombre }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Apellido</label>
                            <input type="text" name="apellido" class="form-control input__text" value="{{ $item->apellido }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">DNI / Documento</label>
                            <input type="text" name="dni" class="form-control input__text" value="{{ $item->dni }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Teléfono</label>
                            <input type="text" name="telefono" class="form-control input__text" value="{{ $item->telefono }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-white">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control input__text" value="{{ $item->correo }}" required>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
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
                text: "El cliente será marcado como inactivo (eliminado).",
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
