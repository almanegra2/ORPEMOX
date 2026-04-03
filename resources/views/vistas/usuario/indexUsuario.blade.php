@extends('layouts.app')

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h2 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
            <i class="fas fa-users mr-2"></i> LISTA DE USUARIOS
        </h2>

        @if (session('CORRECTO'))
            <script>Swal.fire({ icon: 'success', title: '¡Éxito!', text: "{{ session('CORRECTO') }}", timer: 3000 });</script>
        @endif
        @if (session('INCORRECTO'))
            <script>Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('INCORRECTO') }}" });</script>
        @endif

        <div class="mb-4 text-right">
            <a href="{{ route('usuario.create') }}" class="btn btn-primary btn-glow">
                <i class="fas fa-user-plus mr-1"></i> Registrar nuevo usuario
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TIPO</th>
                        <th>NOMBRE</th>
                        <th>USUARIO</th>
                        <th>TELÉFONO</th>
                        <th>DIRECCIÓN</th>
                        <th>CORREO</th>
                        <th>FOTO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $item)
                        <tr>
                            <td>{{ $item->id_usuario }}</td>
                            <td><span class="badge bg-primary">{{ $item->tipo }}</span></td> 
                            <td>{{ $item->nombre }} {{ $item->apellido }}</td>
                            <td>{{ $item->usuario }}</td>
                            <td>{{ $item->telefono }}</td>
                            <td>{{ $item->direccion }}</td>
                            <td>{{ $item->correo }}</td>
                            <td>
                                @if ($item->foto)
                                    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalVerFoto{{ $item->id_usuario }}">
                                        <i class="fas fa-image"></i> Ver foto
                                    </button>
                                @else
                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalSubirFoto{{ $item->id_usuario }}">
                                        <i class="fas fa-plus"></i> Foto
                                    </button>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center" style="gap: 5px;">
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditar{{ $item->id_usuario }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('usuario.destroy', $item->id_usuario) }}" method="POST" id="form-eliminar-user-{{ $item->id_usuario }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmarEliminarUsuario({{ $item->id_usuario }})" class="btn btn-danger btn-sm">
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

{{-- MODALES FUERA DEL BUCLE PARA EVITAR PROBLEMAS DE STACKING --}}
@foreach ($datos as $item)
    {{-- MODAL EDITAR --}}
    <div class="modal fade" id="modalEditar{{ $item->id_usuario }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--accent-color); border-bottom: none;">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Modificar Datos del Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <form action="{{ route('usuario.update', $item->id_usuario) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="txtid_edit" value="{{ $item->id_usuario }}">
                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Tipo de Usuario</label>
                                <select name="txttipo" class="form-control">
                                    @foreach($tipos as $t)
                                        <option value="{{ $t->id_tipo }}" {{ (old('txttipo', $item->tipo_usuario) == $t->id_tipo) ? 'selected' : '' }}>
                                            {{ $t->tipo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Nombre</label>
                                <input type="text" name="txtnombre" class="form-control" value="{{ old('txtnombre', $item->nombre) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Apellido</label>
                                <input type="text" name="txtapellido" class="form-control" value="{{ old('txtapellido', $item->apellido) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Usuario</label>
                                <input type="text" name="txtusuario" class="form-control" value="{{ old('txtusuario', $item->usuario) }}">
                                @if($errors->has('txtusuario') && old('txtid_edit') == $item->id_usuario)
                                    <span class="text-danger small font-weight-bold">{{ $errors->first('txtusuario') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Teléfono</label>
                                <input type="text" name="txttelefono" class="form-control" value="{{ old('txttelefono', $item->telefono) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-white">Dirección</label>
                                <input type="text" name="txtdireccion" class="form-control" value="{{ old('txtdireccion', $item->direccion) }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="text-white">Correo electrónico</label>
                                <input type="email" name="txtcorreo" class="form-control" value="{{ old('txtcorreo', $item->correo) }}">
                                @if($errors->has('txtcorreo') && old('txtid_edit') == $item->id_usuario)
                                    <span class="text-danger small font-weight-bold">{{ $errors->first('txtcorreo') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL SUBIR FOTO --}}
    <div class="modal fade" id="modalSubirFoto{{ $item->id_usuario }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--accent-color); border-bottom: none;">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Subir Foto - {{ $item->nombre }}</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <form action="{{ route('usuario.registrarFotoUsuario') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="txtid" value="{{ $item->id_usuario }}">
                        <label class="text-white mb-2">Selecciona una imagen</label>
                        <input type="file" name="txtfoto" class="form-control" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Subir Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL VER FOTO --}}
    <div class="modal fade" id="modalVerFoto{{ $item->id_usuario }}" tabindex="-1" role="dialog">
        <div class="modal-dialog text-center" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--accent-color); border-bottom: none;">
                    <h5 class="modal-title" style="color: #000; font-weight: 700;">Foto de {{ $item->nombre }}</h5>
                    <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
                </div>
                <div class="modal-body">
                    @if($item->foto)
                        <img src="{{ asset('storage/FOTO-USUARIOS/' . $item->foto) }}" class="img-fluid rounded shadow" style="max-height: 400px; width: auto;">
                    @else
                        <div class="p-5 text-muted">No hay foto disponible</div>
                    @endif
                    <hr class="bg-secondary">
                    <form action="{{ route('usuario.eliminarFoto') }}" method="POST" id="form-eliminar-foto-{{ $item->id_usuario }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id_usuario }}">
                        <button type="button" onclick="confirmarEliminarFoto({{ $item->id_usuario }})" class="btn btn-danger btn-block">
                            <i class="fas fa-trash"></i> Eliminar Foto
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function confirmarEliminarUsuario(id) {
        Swal.fire({
            title: '¿Eliminar usuario completo?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-eliminar-user-' + id).submit();
            }
        })
    }

    function confirmarEliminarFoto(id) {
        Swal.fire({
            title: '¿Estás seguro de que deseas eliminar la foto permanentemente?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-eliminar-foto-' + id).submit();
            }
        })
    }
</script>
@endsection