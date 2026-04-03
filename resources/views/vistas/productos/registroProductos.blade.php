@extends('layouts/app')

@section("titulo", "Registro de Productos")

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-4">
        <h4 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 700; text-transform: uppercase;">
            <i class="fas fa-plus-circle mr-2"></i> REGISTRO DE PRODUCTOS
        </h4>

        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label text-white">Categoría</label>
                    <input type="text" name="txtcategoria" list="lista_categorias" class="form-control input__text" placeholder="Escribe la categoría..." value="{{ old('txtcategoria') }}" required>
                    <datalist id="lista_categorias">
                        @foreach ($categorias ?? [] as $item)
                            <option value="{{ $item->nombre }}">
                        @endforeach
                    </datalist>
                    @error('txtcategoria')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label text-white">Código del Producto</label>
                    <input type="text" class="form-control input__text" placeholder="Ingrese el código" name="txtcodigoproducto" value="{{ old('txtcodigoproducto') }}" required>
                    @error('txtcodigoproducto')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label text-white">Nombre del Producto</label>
                    <input type="text" class="form-control input__text" placeholder="Nombre completo" name="txtnombreproducto" value="{{ old('txtnombreproducto') }}" required>
                    @error('txtnombreproducto')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label text-white">Precio del Producto</label>
                    <input type="number" step="0.01" class="form-control input__text" placeholder="0.00" name="txtprecioproducto" value="{{ old('txtprecioproducto') }}" required>
                    @error('txtprecioproducto')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label text-white">Stock Inicial</label>
                    <input type="number" class="form-control input__text" placeholder="0" name="txtstock" value="{{ old('txtstock') }}" required>
                    @error('txtstock')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label class="form-label text-white">Descripción</label>
                    <textarea name="txtdescripcion" rows="2" placeholder="Breve descripción..." class="form-control input__text">{{ old('txtdescripcion') }}</textarea>
                    @error('txtdescripcion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <label class="form-label text-white">Foto del Producto</label>
                    <input type="file" name="txtfoto" class="form-control input__text" accept="image/*">
                    <small class="text-muted">Formatos permitidos: JPG, PNG, JPEG.</small>
                    @error('txtfoto')
                        <br><small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-glow">
                    <i class="fas fa-save mr-2"></i> Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>

@endsection