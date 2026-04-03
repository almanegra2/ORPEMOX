@extends('layouts/app')

@section("titulo", "Registro de Categorías")

@section('content')

<div class="px-4 py-2">
    <div class="glass-panel p-5">
        <h4 class="text-center mb-5 mt-2" style="color: var(--accent-color); font-weight: 700; text-transform: uppercase;">
            <i class="fas fa-tags mr-2"></i> REGISTRO DE CATEGORÍAS
        </h4>

        <form action="{{ route('categoria.store') }}" method="POST">
            @csrf

            <div class="row justify-content-center mb-4">
                {{-- Campo Nombre de la Categoría --}}
                <div class="col-12 col-md-8">
                    <label class="form-label text-white mb-2">Nombre de la categoría <span class="text-danger">*</span></label>
                    <div class="d-flex shadow-sm">
                        <input type="text"
                               class="form-control input__text flex-grow-1"
                               placeholder="Ej: Electrónica, Ropa, etc."
                               name="txtnombre"
                               style="border-radius: 8px 0 0 8px;"
                               value="{{ old('txtnombre') }}" required>
                        
                        <button type="submit" class="btn btn-primary btn-glow px-4" style="border-radius: 0 8px 8px 0; height: 50px;">
                            <i class="fas fa-save mr-2"></i> Guardar
                        </button>
                    </div>

                    @error('txtnombre')
                        <small class="text-danger mt-2 d-block" style="font-weight: 500;">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>

            <hr style="border-top: 1px solid rgba(255,255,255,0.05); margin: 30px 0;">

            {{-- Botón para volver a la lista --}}
            <div class="text-center">
                <a href="{{ route('categoria.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-chevron-left mr-2"></i> Volver al listado
                </a>
            </div>

        </form>
    </div>
</div>

@endsection