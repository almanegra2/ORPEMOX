@extends('layouts/app')
@section('titulo', 'Lista de categorías')

@section('content')

    {{-- ALERTAS DE NOTIFICACIÓN --}}
    @if (session('CORRECTO'))
        <script>
            $(function () {
                new PNotify({
                    title: "CORRECTO",
                    type: "success",
                    text: "{{ session('CORRECTO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif

    @if (session('INCORRECTO'))
        <script>
            $(function () {
                new PNotify({
                    title: "INCORRECTO",
                    type: "error",
                    text: "{{ session('INCORRECTO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif

    <h5 class="text-center text-secondary">CATEGORÍAS</h5>

    {{-- BOTÓN REGISTRAR NUEVA CATEGORÍA --}}
    <div class="mb-3">
        <a href="{{ route('categoria.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Registrar nueva categoría
        </a>
    </div>

    {{-- TABLA PRINCIPAL --}}
    <section class="card">
        <div class="card-block">
            <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th width="10%">ID</th>
                        <th>Nombre de la Categoría</th>
                        <th width="15%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $item)
                        <tr>
                            <td>{{ $item->id_categoria }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td class="text-center">
                                {{-- BOTÓN EDITAR (Abre Modal) --}}
                                <a href="" data-toggle="modal" data-target="#editCategoria{{ $item->id_categoria }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- BOTÓN ELIMINAR --}}
                                <form action="{{ route('categoria.destroy', $item->id_categoria) }}" method="POST" class="d-inline formulario-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL PARA EDITAR CATEGORÍA --}}
                        <div class="modal fade" id="editCategoria{{ $item->id_categoria }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100">Modificar Categoría</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('categoria.update', $item->id_categoria) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label>Nombre de la Categoría</label>
                                                <input type="text" name="txtnombre" class="form-control" value="{{ $item->nombre }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection