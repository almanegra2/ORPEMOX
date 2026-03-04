<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('inicio/css/login-modern.css') }}">
    <title>Inicio de sesión - SENA</title>
</head>
<body>
    <div class="login-wrapper">
        <!-- Fondo con overlay -->
        <div class="background-overlay"></div>
        
        <!-- Contenedor principal -->
        <div class="login-container">
            <!-- Formulario glassmorphism -->
            <div class="login-box">
                <div class="login-header">
                    <div class="avatar-circle">
                        <img src="{{ asset('inicio/img/avatar.svg') }}" alt="Avatar">
                    </div>
                    <h1 class="welcome-title">BIENVENIDO</h1>
                    <p class="subtitle">Sistema punto display</p>
                </div>

                <!-- Alertas -->
                @if (session('mensaje'))
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i>
                        <small>{{ session('mensaje') }}</small>
                    </div>
                @endif

                <!-- Formulario -->
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <!-- Campo Usuario -->
                    <div class="form-group">
                        @error('usuario')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('usuario') }}
                            </div>
                        @enderror
                        <div class="input-group">
                            <span class="input-icon">
                                <i class="fas fa-user"></i>
                            </span>
                            <input 
                                type="text" 
                                id="usuario" 
                                name="usuario" 
                                class="form-input @error('usuario') is-invalid @enderror"
                                placeholder="Nombre de usuario"
                                value="{{ old('usuario') }}"
                                required 
                                autocomplete="username">
                        </div>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="form-group">
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('password') }}
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
                                placeholder="Contraseña"
                                required 
                                autocomplete="current-password">
                            <span class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Olvide contraseña -->
                    <div class="forgot-password">
                        <a href="#">¿Olvidé mi contraseña?</a>
                    </div>

                    <!-- Botón Login -->
                    <button type="submit" class="btn-login">
                        <span>INICIAR SESIÓN</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    <p><small>&copy; 2026 SENA. Todos los derechos reservados.</small></p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('bootstrap4/js/jquery.min.js') }}"></script>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
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

        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.login-box').style.animation = 'slideUp 0.6s ease-out';
        });
    </script>
</body>
</html>
