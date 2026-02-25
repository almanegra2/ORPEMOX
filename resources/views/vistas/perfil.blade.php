@extends('layouts/app')

@section('titulo', 'Mi perfil')

<style>
    .contenedor {
        background: white;
        padding: 15px;
        display: flex;
        justify-content: space-around;
        gap: 20px;
        align-items: center;
    }

    .img {
        width: 250px;
        height: 250px;
        border-radius: 250px;
        object-fit: cover;
    }

    @media screen and (max-width: 600px) {
        .contenedor {
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }
    }
</style>

@section('content')

    @if (session('mensaje'))
        <script>
            $(function () {
                new PNotify({
                    title: "CORRECTO",
                    text: "{{ session('mensaje') }}",
                    type: "success",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            $(function () {
                new PNotify({
                    title: "ERROR",
                    text: "{{ session('error') }}",
                    type: "error",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif
        
    <h4 class="text-center text-secondary">MI PERFIL</h4>

    @foreach ($datos as $item)
    <div class="contenedor">
        
        <div>
            @if ($item->foto != null)
                <img class="img" src="{{ asset('storage/FOTOS-PERFIL-USUARIO/'.$item->foto) }}" alt="">
            @else
                <img class="img" src="{{ asset('images/img.jpg') }}" alt="">
            @endif
        </div>

        <div>
            <h6><b>Modificar imagen</b></h6>

            {{-- FORM ACTUALIZAR --}}
            <form action="{{ route('perfil.actualizarIMG') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf

                <div class="alert alert-secondary">
                    Selecciona una imagen no muy pesada y en formato válido (.jpg, .jpeg, .png)
                </div>

                <div>
                    <input type="file" 
                           class="input form-control-file mb-3" 
                           name="foto"
                           accept=".jpg,.jpeg,.png">

                    @error('foto')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success btn-rounded">
                        Modificar
                    </button>

                    <button type="button" 
                            onclick="confirmarEliminacion()" 
                            class="btn btn-danger btn-rounded">
                        Eliminar foto
                    </button>
                </div>
            </form>

            {{-- FORM ELIMINAR --}}
            <form action="{{ route('perfil.eliminarFotoPerfil') }}" 
                  method="POST" 
                  id="formEliminarFoto">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>


    {{-- FORM DATOS --}}
    <form action="{{route("perfil.actualizarDatos")}}" method="POST" class="bg-white p-3 mt-3">
        <div class="row">

            @method("put")

            @csrf

            <div class="fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" 
                       placeholder="Nombres" value="{{$item->nombre}}" name="nombre">
                       @error('nombre')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
            </div>

            <div class="fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" 
                       placeholder="Apellidos" value="{{$item->apellido}}" name="apellido">
                       @error('apellido')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
            </div> 

            <div class="fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" 
                       placeholder="Usuario" value="{{$item->usuario}}" name="usuario">
                       @error('usuario')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
            </div>

            <div class="fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" 
                       placeholder="Teléfono" value="{{$item->telefono}}" name="telefono">
            </div>

            <div class="fl-flex-label col-12 col-lg-6 mb-4">
                <input type="text" class="input input__text" 
                       placeholder="Dirección" value="{{$item->direccion}}" name="direccion">
            </div>

            <div class="fl-flex-label col-12 col-lg-6 mb-4">
                <input type="email" class="input input__text" 
                       placeholder="Correo electrónico" value="{{$item->correo}}" name="correo">
                       @error('correo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
            </div>

            <div class="text-right col-12">
                <button type="submit" class="btn btn-primary btn-rounded">
                    Guardar cambios
                </button>
            </div>
        </div>
    </form>

    @endforeach

@endsection


{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmarEliminacion() {
    Swal.fire({
        title: '¿Está seguro?',
        text: '¡No podrá recuperar esta imagen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Salir'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formEliminarFoto').submit();
        }
    });
}
</script>