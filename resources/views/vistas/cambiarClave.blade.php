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

<h4 class="text-center text-secondary">ACTUALIZAR CONTRASEÑA</h4>

<div class="mb-0 col-12 bg-white p-5">
    <form action="{{ route('usuario.actualizarClave') }}" method="POST">
        @csrf
        
        <div class="row">
            {{-- Clave Actual ocupa todo el ancho --}}
            <div class="fl-flex-label mb-4 col-12">
                <input type="password" name="clave_actual" class="input input__text" 
                       placeholder="Ingrese la clave actual *" required>
            </div>

            {{-- Nueva Clave ocupa todo el ancho, por lo que baja automáticamente --}}
            <div class="fl-flex-label mb-4 col-12">
                <input type="password" name="clave_nueva" class="input input__text" 
                       placeholder="Ingrese la nueva clave *" required>
            </div>
        </div>

        <div class="text-right mt-0">
            <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
        </div>
    </form>
</div>

@endsection