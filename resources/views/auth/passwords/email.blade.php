<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('inicio/css/login-modern.css') }}">
    <title>Recuperar Contraseña - SENA</title>
</head>
<body>
    <div class="login-wrapper">
        <div class="background-overlay"></div>
        
        <div class="login-container">
            <div class="login-box">
                <div class="login-header">
                    <div class="avatar-circle">
                        <i class="fas fa-envelope fa-2x" style="color: #fff; margin-top: 25px;"></i>
                    </div>
                    <h1 class="welcome-title">RECUPERAR</h1>
                    <p class="subtitle">Ingresa tu correo electrónico</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-info" role="alert" style="color: #fff; text-align: center; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.2); padding: 10px; border-radius: 8px;">
                        <i class="fas fa-check-circle"></i>
                        <small>{{ session('status') }}</small>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="login-form">
                    @csrf

                    <div class="form-group">
                        @error('correo')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-at"></i>
                            </span>
                            <input 
                                type="email" 
                                id="correo" 
                                name="correo" 
                                class="form-input @error('correo') is-invalid @enderror"
                                placeholder="Correo institucional"
                                value="{{ old('correo') }}"
                                required 
                                autofocus>
                        </div>
                    </div>

                    <div class="forgot-password" style="text-align: center; margin-top: 20px;">
                        <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Volver al login</a>
                    </div>

                    <button type="submit" class="btn-login">
                        <span>ENVIAR ENLACE</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>

                <div class="login-footer">
                    <p><small>&copy; {{ date('Y') }} SENA. Todos los derechos reservados.</small></p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('bootstrap4/js/jquery.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.login-box').style.animation = 'slideUp 0.6s ease-out';
        });
    </script>
</body>
</html>
