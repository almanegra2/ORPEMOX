@extends('layouts/app')
@section('titulo', 'Registro de Entradas')

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h4 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 700; text-transform: uppercase;">
            <i class="fas fa-plus-circle mr-2"></i> REGISTRO DE ENTRADA DE PRODUCTOS
        </h4>

        <form action="{{route("entradas.store")}}" method="POST">

        @csrf

        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label text-white">Producto</label>
                <input type="text" name="producto_nombre" list="lista_productos" class="form-control input__text" placeholder="Escribe el nombre del producto..." required>
                <datalist id="lista_productos">
                    @foreach($producto as $p)
                        <option value="{{ $p->nombre }}">
                    @endforeach
                </datalist>
                @error('producto_nombre')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label text-white">Proveedor</label>
                <input type="text" name="proveedor_nombre" list="lista_proveedores" class="form-control input__text" placeholder="Escribe el nombre del proveedor..." required>
                <datalist id="lista_proveedores">
                    @foreach($proveedor as $pr)
                        <option value="{{ $pr->nombre }} {{ $pr->apellido }}">
                    @endforeach
                </datalist>
                @error('proveedor_nombre')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-4 mb-3">
                <label class="form-label text-white">Cantidad</label>
                <input type="number" class="form-control input__text" placeholder="0" name="cantidad" value="{{old('cantidad')}}" required>
                @error('cantidad')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label class="form-label text-white">Precio Unitario</label>
                <input type="number" step="0.01" class="form-control input__text" placeholder="0.00" name="precio" value="{{old('precio')}}" required>
                @error('precio')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label class="form-label text-white">Fecha de Entrada</label>
                <input type="datetime-local" class="form-control input__text" name="fecha" value="{{old('fecha', date('Y-m-d\TH:i'))}}" required>
                @error('fecha')
                    <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
        </div>

        <div class="text-right mt-4">
            <a href="{{ route('entradas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary btn-glow">Guardar Entrada</button>
        </div>
    </form>
</div>
</div>

@endsection