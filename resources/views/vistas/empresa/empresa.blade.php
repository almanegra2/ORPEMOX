@extends('layouts/app')
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
@section('titulo', 'empresa')
@section('content')


    {{-- notificaciones --}}


    @if (session('CORRECTO'))
        <script>
            $(function notificacion() {
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
            $(function notificacion() {
                new PNotify({
                    title: "INCORRECTO",
                    type: "error",
                    text: "{{ session('INCORRECTO') }}",
                    styling: "bootstrap3"
                });
            });
        </script>
    @endif

    <h4 class="text-center text-secondary">DATOS DE LA EMPRESA</h4>
     <div class="contenedor">
        
        <div>
            <img class="img" src="{{ asset('images/company.jpg') }}" alt="">
        </div>

        <div>
            <h6><b>Modificar imagen</b></h6>

            {{-- FORM ACTUALIZAR --}}
            <form action="" 
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
            <form action="" 
                  method="POST" 
                  id="formEliminarFoto">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>


    <div class="mb-0 col-12 bg-white p-5">
        @foreach ($sql as $item)
            <form action="{{ route('empresa.update', $item->id_empresa) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="nombre" class="input input__text" id="nombre" placeholder="Nombre"
                            value="{{ $item->nombre }}">
                        
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="telefono" class="input input__text" id="telefono" placeholder="telefono"
                            value="{{ $item->telefono }}">
                    </div>
                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="ubicacion" class="input input__text" placeholder="ubicacion *"
                            value="{{ old('ubicacion', $item->ubicacion) }}">
                        
                    </div>



                    <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="ruc" class="input input__text" placeholder="ruc *"
                            value="{{ old('ruc', $item->ruc) }}">

                    </div>    

                              <div class="fl-flex-label mb-4 col-12 col-lg-6">
                        <input type="text" name="correo" class="input input__text" placeholder="correo *"
                            value="{{ old('correo', $item->correo) }}">
                        
                    </div>
                        
                    </div>

                    <div class="text-right mt-0">
                        <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                    </div>
                </div>

            </form>
        @endforeach
    </div>

@endsection
