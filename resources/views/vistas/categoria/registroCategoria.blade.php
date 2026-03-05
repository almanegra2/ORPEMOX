@extends('layouts/app')

@section("titulo", "Registro de Productos")

<style>
    textarea {
        field-sizing: content;
    }

    .mensaje {
        color: red;
        front-size: 13px;
        padding: 5px;
    }
</style>

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

    <h4 class="text-center text-secondary">Registro de Productos</h4>

     <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row col-12">

            <div class="fl-flex-label col-12 col-md-6 mb-3 px-2">
                <select name="txtcategoria" class="input input__select">
                    <option value=""> seleccionar categoría...</option>
                    @foreach ($categorias ?? [] as $item)
                        <option value="{{ $item->id_categoria }}">
                            {{ $item->nombre }}
                        </option>
                    @endforeach
                </select>

                @error('txtcategoria')
                    <small class="mensaje">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
                <input type="text"
                       class="input input__text"
                       placeholder="codigo del producto"
                       name="txtcodigoproducto">

                @error('txtcodigoproducto')
                    <small class="mensaje">{{ $message }}</small>
                @enderror
            </div>

        </div>

        <div class="row col-12 mb-3">

            <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
                <input type="text"
                       class="input input__text"
                       placeholder="Nombre del producto"
                       name="txtnombreproducto">

                @error('txtnombreproducto')
                    <small class="mensaje">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
                <input type="text"
                       class="input input__text"
                       placeholder="Precio del producto"
                       name="txtprecioproducto"
                       step="0.05">

                @error('txtprecioproducto')
                    <small class="mensaje">{{ $message }}</small>
                @enderror
            </div>

        </div>

        <div class="row col-12 mb-3">

            <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
                <input type="text"
                       class="input input__text"
                       placeholder="stock del producto"
                       name="txtstock">

                @error('txtstock')
                    <small class="mensaje">{{ $message }}</small>
                @enderror
            </div>

            <div class="fl-flex-label 12 col-md-6 mb-3 px-2">
                <textarea name="txtdescripcion"
                          cols="30"
                          rows="10"
                          placeholder="Descripción del producto"
                          class="input input__text"></textarea>
            </div>

            <div class="row col-12 mb-3">
                <div class="fl-flex-label col-md-6 mb-3 px-2">
                    <label for="txtfoto">Subir foto del producto</label>
                    <input type="file"
                           id="txtfoto"
                           class="input input__text"
                           name="txtfoto" accept="image/*">

                    @error('txtfoto')
                        <small class="mensaje">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="text-right px-4">
                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </div>

        </div>

    </form>

@endsection