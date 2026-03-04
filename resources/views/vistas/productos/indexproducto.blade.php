@extends('layouts/app')
@section('titulo', 'Lista de productos')

@section('content')

    {{-- Notificaciones PNotify --}}
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

    <h5 class="text-center text-secondary">LISTA DE PRODUCTOS</h5>

    {{-- Buscador AJAX --}}
    <form action="" id="formBuscar" method="POST">
        @csrf
        <div class="row col-12 p-3">
            <div class="col-12 col-md-9">
                <input type="text" name="buscar" id="buscar" class="form-control p-3"
                    placeholder="Ingrese el codigo o nombre del producto">
            </div>
            <button type="submit" class="btn btn-success col-12 col-md-3 mt-2 mt-sm-0">
                Buscar
            </button>
        </div>
    </form>

    {{-- Tabla de resultados AJAX --}}
    <div class="overflow-auto">
        <table class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoria</th>
                    <th>Foto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </div>

    {{-- Tabla Principal (Carga Inicial) --}}
    <section class="card">
        <div class="card-block">
            <table id="example2" class="display table table-striped" cellspacing="0" width="100%">
                <thead class="table-primary">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoria</th>
                        <th>Foto</th>
                        <th>Acciones</th>
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
                                    <a href="" data-toggle="modal" data-target="#editar{{ $item->codigo }}">Agregar foto</a>
                                @else
                                    <a href="" data-toggle="modal" data-target="#exampleModal{{ $item->codigo }}">Ver Foto</a>
                                @endif
                            </td>
                            <td>
                                {{-- BOTÓN EDITAR (Video 41) --}}
                                <a href="" data-toggle="modal" data-target="#editProducto{{ $item->id_producto }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- FORMULARIO ELIMINAR con d-inline (Mejora Video 43) --}}
                                <form action="{{ route('productos.destroy', $item->codigo) }}" method="POST" class="d-inline formulario-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL VER FOTO --}}
                        <div class="modal fade" id="exampleModal{{ $item->codigo }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100">Foto del producto</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img style="width: 80%" src="{{ asset('storage/FOTO-PRODUCTOS/' . $item->foto) }}" alt="">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <a href="{{ route('producto.eliminarFoto', $item->id_producto) }}" class="btn btn-danger">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL SUBIR FOTO --}}
                        <div class="modal fade" id="editar{{ $item->codigo }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100">Subir foto del producto</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <form action="{{ route('producto.registrarFotoProducto') }}" id="formFoto{{ $item->id_producto }}" 
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="txtid" value="{{ $item->id_producto }}">
                                            <input class="form-control" type="file" name="txtfoto" accept=".jpg, .png, .jpeg">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary" form="formFoto{{ $item->id_producto }}">Guardar Foto</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL EDITAR DATOS (Video 41) --}}
                        <div class="modal fade" id="editProducto{{ $item->id_producto }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100">Modificar datos del producto</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <form action="{{ route('productos.update', $item->id_producto) }}" method="POST" class="p-4 text-left">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label>Categoría</label>
                                                <select name="txtcategoria" class="form-control" required>
                                                    @foreach ($categoria as $cat)
                                                        <option value="{{ $cat->id_categoria }}" @selected($cat->id_categoria == $item->id_categoria)>
                                                            {{ $cat->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Código</label>
                                                <input type="text" name="txtcodigoproducto" class="form-control" value="{{ $item->codigo }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" name="txtnombreproducto" class="form-control" value="{{ $item->nombre }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Precio</label>
                                                <input type="text" name="txtprecioproducto" class="form-control" value="{{ $item->precio }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Stock</label>
                                                <input type="number" name="txtstock" class="form-control" value="{{ $item->stock }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea name="txtdescripcion" class="form-control" rows="2">{{ $item->descripcion }}</textarea>
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

            {{-- Paginación --}}
            <div class="text-right">
                {{ $datos->links("pagination::bootstrap-4") }}
                Mostrando {{ $datos->firstItem() }} - {{ $datos->lastItem() }} de {{ $datos->total() }} resultados
            </div>
        </div>
    </section>

    {{-- SCRIPTS --}}
    <script>
        // Script AJAX para Búsqueda
        let formBuscar = document.getElementById('formBuscar');
        formBuscar.addEventListener("submit", buscarDatos);
        formBuscar.addEventListener("keyup", buscarDatos);

        function buscarDatos(e) {
            e.preventDefault();
            let datos = $(formBuscar).serialize();

            $.ajax({
                url: "{{ route('producto.buscar') }}",
                type: "post",
                data: datos,
                success: function(res) {
                    let tbody = document.getElementById("tbody");
                    let tr = "";
                    res.dato.forEach(function(item) {
                        tr += `
                            <tr>
                                <td>${item.codigo}</td>
                                <td>${item.nombre}</td>
                                <td>${item.descripcion}</td>
                                <td>${item.precio}</td>
                                <td>${item.stock}</td>
                                <td>${item.categoria}</td>
                                <td>${item.foto ?? ''}</td>
                                <td><a class="btn btn-info btn-sm">Ver</a></td> 
                            </tr>
                        `;
                    });
                    tbody.innerHTML = tr;
                },
                error: function() {
                    document.getElementById("tbody").innerHTML = "";
                }
            });
        }

        // SOLUCIÓN DEFINITIVA SWEET ALERT (Video 43 - Delegación de eventos)
        $(document).on('submit', '.formulario-eliminar', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>

@endsection