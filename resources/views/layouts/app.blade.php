<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <title>@yield('titulo', "Inicio")</title>

    {{-- Token CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
    
    {{-- CSS Base --}}
    <link href="{{asset('app/publico/css/lib/font-awesome/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('bootstrap5/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('app/publico/css/lib/lobipanel/lobipanel.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/publico/css/separate/vendor/lobipanel.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/publico/css/lib/jqueryui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/publico/css/separate/pages/widgets.min.css')}}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/fontawesome.min.css')}}">

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="{{asset('app/publico/css/lib/datatables-net/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('app/publico/css/separate/vendor/datatables-net.min.css')}}">

    <link href="{{asset('app/publico/css/lib/bootstrap/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('app/publico/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('app/publico/css/mis_estilos/estilos.css')}}" rel="stylesheet">

    {{-- Form & Personalizados --}}
    <link rel="stylesheet" type="text/css" href="{{asset('app/publico/css/lib/jquery-flex-label/jquery.flex.label.css')}}">
    <link href="{{asset('principal/css/estilos.css')}}" rel="stylesheet">

    {{-- pNotify CSS --}}
    <link href="{{asset('pnotify/css/pnotify.css')}}" rel="stylesheet" />
    <link href="{{asset('pnotify/css/pnotify.buttons.css')}}" rel="stylesheet" />
    <link href="{{asset('pnotify/css/custom.min.css')}}" rel="stylesheet" />

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Modern Premium Styles --}}
    <link href="{{ asset('css/modern_premium.css') }}" rel="stylesheet">

    <style>
        :root {
            --accent-color: #f59e0b;
            color-scheme: dark;
        }
        html, body {
            color-scheme: dark;
        }
        /* FORCED GLOBAL RE-THEME - NO BLUE ALLOWED */
        .site-header {
            background: #000000 !important;
            border-bottom: 1px solid rgba(245, 158, 11, 0.3) !important; /* Single continuous line */
        }
        .site-header-shown, .site-header-content-in, .site-header-content {
            background: #000000 !important;
            border-bottom: none !important; /* Prevent double nested lines */
        }
        .side-menu, .side-menu-list, .side-menu-list ul {
            background: #000000 !important;
            border-right: 1px solid rgba(245, 158, 11, 0.2) !important;
        }
        .side-menu-list li a.activo, 
        .side-menu-list li.opened > span,
        .side-menu-list li.blue a.activo,
        .side-menu-list li.blue.opened > span,
        .side-menu-list li a:hover,
        .side-menu-list li.opened ul li a.activo {
            background: rgba(245, 158, 11, 0.4) !important;
            color: var(--accent-color) !important;
            border-left: 5px solid var(--accent-color) !important;
        }
        .side-menu-list li a.activo span,
        .side-menu-list li a.activo i,
        .side-menu-list li.opened > span span,
        .side-menu-list li.opened > span i,
        .side-menu-list li.opened ul li a.activo span,
        .side-menu-list li.opened ul li a.activo i {
            color: var(--accent-color) !important;
        }
        /* Icon Filter to Gold */
        .side-menu-list li img.img-inicio {
            filter: sepia(100%) saturate(200%) brightness(100%) hue-rotate(5deg) !important;
        }
        /* Neutralizing legacy classes */
        .side-menu-list li.blue, .side-menu-list li.red, .side-menu-list li.grey {
            background: transparent !important;
        }
        .side-menu-list li.blue > span, .side-menu-list li.red > span, .side-menu-list li.grey > span {
            background: transparent !important;
        }
        .marca {
            width: 100%;
            background: #000 !important;
            position: fixed;
            bottom: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            border-top: 1px solid rgba(245, 158, 11, 0.2);
        }
        .marca__parrafo { margin: 0 !important; color: white !important; }
        .marca__texto { color: var(--accent-color) !important; text-decoration: underline; }
        .marca__parrafo span { color: #f59e0b !important; }
        
        .show-hide-sidebar, .hamburger, .site-header .menu {
            background: transparent !important;
            color: var(--accent-color) !important;
        }
        .show-hide-sidebar:before, .show-hide-sidebar:after, .hamburger span, 
        .site-header .menu:before, .site-header .menu:after {
            background: var(--accent-color) !important;
        }
        .dropdown-notification .nomTipo {
            color: var(--accent-color) !important;
        }
        .nomInfo {
            color: var(--accent-color) !important;
        }
    /* --- SELECT2 DARK THEME OVERRIDES --- */
    .select2-container--default .select2-selection--single {
        background: rgba(25, 25, 25, 0.95) !important;
        border: 1px solid rgba(245, 158, 11, 0.2) !important;
        height: 48px !important;
        border-radius: 12px !important;
        display: flex;
        align-items: center;
        transition: var(--transition-smooth);
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #ffffff !important;
        padding-left: 12px !important;
        line-height: normal !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        right: 10px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: var(--accent-color) transparent transparent transparent !important;
    }
    .select2-dropdown {
        background: #0f0f0f !important;
        border: 1px solid var(--accent-color) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.9) !important;
        overflow: hidden !important;
    }
    .select2-search--dropdown {
        background: #0f0f0f !important;
        padding: 8px !important;
    }
    .select2-search__field {
        background: #000 !important;
        color: #ffffff !important;
        border: 1px solid rgba(245, 158, 11, 0.3) !important;
        border-radius: 8px !important;
        padding: 8px !important;
        outline: none !important;
    }
    .select2-results__option {
        padding: 10px 15px !important;
        color: #ffffff !important;
        background: #0f0f0f !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--accent-color) !important;
        color: #000 !important;
        font-weight: 700 !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: rgba(245, 158, 11, 0.3) !important;
        color: #fff !important;
    }
    /* White box fix */
    .select2-container .select2-selection--single .select2-selection__placeholder {
        color: #999 !important;
    }

    /* --- DATATABLES PREMIUM OVERRIDES --- */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: transparent !important;
        color: #ffffff !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 8px !important;
        transition: all 0.3s ease !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--accent-color) !important;
        color: #000 !important;
        border: 1px solid var(--accent-color) !important;
        font-weight: 700 !important;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.4) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: rgba(255,255,255,0.05) !important;
        color: var(--accent-color) !important;
        border: 1px solid var(--accent-color) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
        color: #555 !important;
        border: 1px solid rgba(255,255,255,0.05) !important;
        opacity: 0.5 !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        background: rgba(255,255,255,0.02) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 8px !important;
        color: #fff !important;
        padding: 8px 12px !important;
        transition: all 0.3s ease !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--accent-color) !important;
        box-shadow: 0 0 10px rgba(245, 158, 11, 0.2) !important;
        outline: none !important;
    }
    .dataTables_wrapper .dataTables_length select {
        background: #111 !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 6px !important;
        color: #fff !important;
    }

    /* --- DATATABLES NUKE ALL BLUE --- */
    .dt-bootstrap .pagination .paginate_button a,
    .dataTables_wrapper .dataTables_paginate .paginate_button a {
        color: var(--accent-color) !important;
        background-color: transparent !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
    }
    .dt-bootstrap .pagination .paginate_button.active a,
    .dt-bootstrap .pagination .paginate_button.active a:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: var(--accent-color) !important;
        background: var(--accent-color) !important;
        color: #000 !important;
        border-color: var(--accent-color) !important;
        font-weight: 700 !important;
    }
    table.dataTable tr.selected,
    table.dataTable tr.selected td,
    table.dataTable tr.selected .sorting_1 {
        background-color: rgba(245, 158, 11, 0.2) !important;
        color: #fff !important;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @laravelPWA
</head>

<body class="with-side-menu">
    <div id="app">
        <header class="site-header">
            <div class="container-fluid" style="padding-left: 40px;">
                <button id="show-hide-sidebar-toggle" class="show-hide-sidebar menu">
                    <span>toggle menu</span>
                </button>
                <button class="hamburger hamburger--htla">
                    <span>toggle menu</span>
                </button>

                <div class="site-header-content">
                    <div class="site-header-content-in">
                        <div class="site-header-shown">
                            <div class="dropdown dropdown-notification">
                                <h6 class="mt-2 nomTipo">
                                    {{ Auth::user()->tipo_usuario === 1 ? 'Administrador' : 'Usuario' }}
                                </h6>
                            </div>

                            <div class="dropdown user-menu">
                                <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if (Auth::user()->foto == null)
                                        <img src="{{asset('app/publico/img/user.svg')}}" alt="">
                                    @else
                                        <img class="img" src="{{ asset('storage/FOTOS-PERFIL-USUARIO/'.Auth::user()->foto) }}" alt="">
                                    @endif
                                </button>
                                <div class="dropdown-menu dropdown-menu-right pt-0" aria-labelledby="dd-user-menu">
                                    <h5 class="p-2 text-center nomInfo">{{ Auth::user()->nombre . " " . Auth::user()->apellido }}</h5>
                                    <a class="dropdown-item" href="{{ route('usuario.perfil') }}"><span class="font-icon glyphicon glyphicon-user"></span>Perfil</a>
                                    <a class="dropdown-item" href="{{ route('usuario.cambiarClave') }}"><span class="font-icon glyphicon glyphicon-lock"></span>Cambiar contraseña</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="font-icon glyphicon glyphicon-log-out"></span>Salir
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <nav class="side-menu">
            <ul class="side-menu-list p-0">
                <li class="red">
                    <a href="{{route('home')}}" class="{{ Request::is('home*') ? 'activo' : ''}}">
                        <img src="{{asset('img-inicio/house.png')}}" class="img-inicio"> <span class="lbl">INICIO</span>
                    </a>
                </li>

                {{-- MÓDULO REGISTROS --}}
                <li class="grey with-sub {{ Request::is('productos*') || Request::is('categoria*') ? 'opened' : ''}}">
                    <span>
                        <img src="{{asset('img-inicio/boton-agregar.png')}}" class="img-inicio"> 
                        <span class="lbl">REGISTROS</span>
                    </span>
                    <ul>
                        <li>
                            <a href="{{route('categoria.index')}}" class="{{ Request::is('categoria*') ? 'activo' : ''}}">
                                <i class="fas fa-tags"></i> <span class="lbl">CATEGORÍA</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{route('productos.index')}}" class="{{ Request::is('productos*') ? 'activo' : ''}}">
                                <i class="fas fa-th-list"></i> <span class="lbl">PRODUCTOS</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- MÓDULO ENTRADAS (NUEVO - VIDEO 65) --}}
                <li class="blue with-sub {{ Request::is('entradas*') ? 'opened' : ''}}">
                    <span>
                        {{-- Usamos la imagen img1.png indicada en el video para el icono de entradas --}}
                        <img src="{{asset('img-inicio/valores.png')}}" class="img-inicio"> 
                        <span class="lbl">ENTRADAS</span>
                    </span>
                    <ul>
                        <li>
                            <a href="{{route('entradas.create')}}" class="{{ Request::is('entradas/create') ? 'activo' : ''}}">
                                <i class="fas fa-plus-circle"></i> <span class="lbl">Registrar entrada</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('entradas.index')}}" class="{{ Request::is('entradas') ? 'activo' : ''}}">
                                <i class="fas fa-clipboard-list"></i> <span class="lbl">Lista de entradas</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="red">
                    <a href="{{route('usuario.index')}}" class="{{ Request::is('usuario*') ? 'activo' : ''}}">
                        <img src="{{asset('img-inicio/team.png')}}" class="img-inicio"> <span class="lbl">USUARIOS</span>
                    </a>
                </li>
                
                <li class="red">
                    <a href="{{route('clientes.index')}}" class="{{ Request::is('clientes*') ? 'activo' : ''}}">
                        <i class="fas fa-user-tie" style="font-size: 1.1em; opacity: 0.8; margin-right: 12px; margin-left:10px;"></i> 
                        <span class="lbl">CLIENTES</span>
                    </a>
                </li>
                
                <li class="red">
                    <a href="{{route('empresa.index')}}" class="{{ Request::is('empresa*') ? 'activo' : ''}}">
                        <img src="{{asset('img-inicio/info.png')}}" class="img-inicio"> <span class="lbl">ACERCA DE</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="page-content mt-5">
            @yield('content')
        </div>
    </div>

    {{-- JS Base --}}
    <script src="{{asset('app/publico/js/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap5/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap5/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('app/publico/js/lib/tether/tether.min.js')}}"></script>
    <script src="{{asset('app/publico/js/lib/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('app/publico/js/plugins.js')}}"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    {{-- DataTables JS --}}
    <script src="{{asset('app/publico/js/lib/datatables-net/datatables.min.js')}}"></script>

    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Sweet Alert & PNotify --}}
    <script src="{{asset('sweet/js/sweetalert2.js')}}"></script>
    <script src="{{asset('pnotify/js/pnotify.js')}}"></script>
    <script src="{{asset('pnotify/js/pnotify.buttons.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('app/publico/js/lib/jqueryui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('app/publico/js/lib/lobipanel/lobipanel.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('app/publico/js/lib/match-height/jquery.matchHeight.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('app/publico/js/lib/jquery-flex-label/jquery.flex.label.js')}}"></script>

    <script src="{{asset('app/publico/js/app.js')}}"></script>

    {{-- Alertas de Sesión --}}
    <script>
        $(function() {
            @if (session('CORRECTO') || session('correcto'))
                new PNotify({
                    title: 'ÉXITO',
                    text: "{{ session('CORRECTO') ?? session('correcto') }}",
                    type: 'success',
                    styling: 'bootstrap3'
                });
            @endif
            @if (session('INCORRECTO') || session('incorrecto'))
                new PNotify({
                    title: 'ERROR',
                    text: "{{ session('INCORRECTO') ?? session('incorrecto') }}",
                    type: 'error',
                    styling: 'bootstrap3'
                });
            @endif
            
            $('.fl-flex-label').flexLabel();
        });
    </script>

    @stack('scripts')

</body>
</html>