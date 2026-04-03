@extends('layouts/app')

@section('titulo', 'Mi Perfil')

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-4 mb-4">
        <h2 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 800; text-transform: uppercase; letter-spacing: 2px;">
            <i class="fas fa-user-circle mr-2"></i> PERFIL DE USUARIO
        </h2>

        @foreach ($datos as $item)
            {{-- SECCIÓN SUPERIOR: FOTO Y ACCIONES --}}
            <div class="row align-items-center mb-5 pb-4" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                    <div class="d-inline-block p-2" style="background: rgba(245, 158, 11, 0.1); border-radius: 50%; border: 2px solid var(--accent-color); box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);">
                        @if ($item->foto != null)
                            <img src="{{ asset('storage/FOTOS-PERFIL-USUARIO/'.$item->foto) }}" alt="Perfil" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/img.jpg') }}" alt="Perfil" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover;">
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="p-4" style="background: rgba(255,255,255,0.02); border-radius: 15px; border: 1px solid rgba(255,255,255,0.05);">
                        <h5 class="text-white mb-3" style="font-weight: 600;">
                            <i class="fas fa-camera mr-2 text-warning"></i> Actualizar Foto de Perfil
                        </h5>
                        
                        <form action="{{ route('perfil.actualizarIMG') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="text-muted small mb-2 d-block">Selecciona una imagen (.jpg, .jpeg, .png)</label>
                                <input type="file" name="foto" class="form-control" style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 10px; height: auto;" accept=".jpg,.jpeg,.png">
                                @error('foto')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-glow px-4">
                                    <i class="fas fa-sync-alt mr-2"></i> Cambiar Foto
                                </button>
                                <button type="button" onclick="confirmarEliminacion()" class="btn btn-danger px-4">
                                    <i class="fas fa-trash-alt mr-2"></i> Eliminar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- FORM ELIMINAR FOTO (HIDDEN) --}}
            <form action="{{ route('perfil.eliminarFotoPerfil') }}" method="POST" id="formEliminarFoto" class="d-none">
                @csrf
                @method('DELETE')
            </form>

            {{-- FORM DATOS PERSONALES --}}
            <form action="{{ route('perfil.actualizarDatos') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6 mb-4">
                        <label class="form-label text-white ml-1">Nombres</label>
                        <input type="text" name="nombre" class="form-control input__text" value="{{ old('nombre', $item->nombre) }}" required>
                        @error('nombre') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label class="form-label text-white ml-1">Apellidos</label>
                        <input type="text" name="apellido" class="form-control input__text" value="{{ old('apellido', $item->apellido) }}" required>
                        @error('apellido') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label class="form-label text-white ml-1">Nombre de Usuario</label>
                        <input type="text" name="usuario" class="form-control input__text" value="{{ old('usuario', $item->usuario) }}" required>
                        @error('usuario') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label class="form-label text-white ml-1">Teléfono</label>
                        <input type="text" name="telefono" class="form-control input__text" value="{{ old('telefono', $item->telefono) }}">
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label class="form-label text-white ml-1">Dirección</label>
                        <input type="text" name="direccion" class="form-control input__text" value="{{ old('direccion', $item->direccion) }}">
                    </div>

                    <div class="col-12 col-md-6 mb-4">
                        <label class="form-label text-white ml-1">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control input__text" value="{{ old('correo', $item->correo) }}" required>
                        @error('correo') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>
                </div>

                <hr style="border-top: 1px solid rgba(255,255,255,0.05); margin-bottom: 30px;">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-glow px-5 py-2" style="font-size: 1.1rem; font-weight: 700;">
                        <i class="fas fa-save mr-2"></i> GUARDAR CAMBIOS
                    </button>
                </div>
            </form>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmarEliminacion() {
    Swal.fire({
        title: '¿Eliminar foto de perfil?',
        text: 'Se restablecerá la imagen por defecto.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff4444',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formEliminarFoto').submit();
        }
    });
}
</script>
@endpush