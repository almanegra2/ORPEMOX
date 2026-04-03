<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('inicio/css/login-modern.css') }}">
    <title>Restablecer Contraseña - SENA</title>
</head>
<body>
    <div class="login-wrapper">
        <div class="background-overlay"></div>
        
        <div class="login-container">
            <div class="login-box">
                <div class="login-header">
                    <div class="avatar-circle">
                        <i class="fas fa-key fa-2x" style="color: #fff; margin-top: 25px;"></i>
                    </div>
                    <h1 class="welcome-title">NUEVA CLAVE</h1>
                    <p class="subtitle">Ingresa tu nueva contraseña</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="login-form">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

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
                                value="{{ $email ?? old('correo') }}"
                                required 
                                autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input @error('password') is-invalid @enderror"
                                placeholder="Nueva Contraseña"
                                required>
                            <span class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <small style="color: rgba(255,255,255,0.7); font-size: 11px; margin-top: 5px; display: block;">Mínimo 8 a 12 caracteres, incluye mayúscula, número y símbolo.</small>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                id="password-confirm" 
                                name="password_confirmation" 
                                class="form-input"
                                placeholder="Confirmar Contraseña"
                                required>
                            <span class="toggle-password" onclick="togglePassword('password-confirm')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" style="margin-top: 30px;">
                        <span>RESTABLECER</span>
                        <i class="fas fa-check"></i>
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
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.target.closest('.toggle-password').querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.login-box').style.animation = 'slideUp 0.6s ease-out';
        });
    </script>
</body>
</html>
