@extends('layouts/app')

@section('titulo', 'Cambiar Contraseña')

@section('content')

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

<div class="px-4 py-2">
    <div class="glass-panel p-4 mb-4">
        <h2 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 800; text-transform: uppercase; letter-spacing: 2px;">
            <i class="fas fa-key mr-2"></i> ACTUALIZAR CONTRASEÑA
        </h2>

        <form action="{{ route('usuario.actualizarClave') }}" method="POST" class="px-lg-5">
            @csrf
            
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 mb-4">
                    <label class="form-label text-white ml-1">Contraseña Actual *</label>
                    <input type="password" name="clave_actual" class="form-control input__text" 
                           placeholder="Ingrese su clave actual" required>
                    @error('clave_actual')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-8 mb-4">
                    <label class="form-label text-white ml-1">Nueva Contraseña *</label>
                    <input type="password" name="clave_nueva" class="form-control input__text" 
                           placeholder="Mínimo 6 caracteres" required>
                    @error('clave_nueva')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-glow px-5 py-2" style="font-size: 1.1rem; font-weight: 700;">
                    <i class="fas fa-save mr-2"></i> GUARDAR CONTRASEÑA
                </button>
            </div>
        </form>
    </div>
</div>

@endsection