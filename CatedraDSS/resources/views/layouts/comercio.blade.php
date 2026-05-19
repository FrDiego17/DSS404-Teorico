<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare Comercio - @yield('title', 'Panel de Comercio')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        :root {
            --fs-green: #45b66f;
            --fs-green-dark: #3a9e5e;
            --fs-dark: #1a2a32;
            --fs-bg-header: #fdfefd;
        }

        html, body {
            height: 100%;
            margin: 0;
        }
        body { 
            padding-top: 85px; 
            background-color: #f9fbf9; 
            display: flex;
            flex-direction: column;
        }

        .page-container {
            flex: 1 0 auto;
        }

        .navbar-comercio {
            background-color: var(--fs-bg-header);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 12px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.02);
        }
        .navbar-brand img { height: 45px; width: auto; display: block; }
        
        .nav-center { 
            position: absolute; 
            left: 50%; 
            transform: translateX(-50%); 
        }

        .navbar-comercio .nav-link {
            color: #4a5568 !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 12px;
            padding: 8px 0;
            position: relative;
            transition: color 0.3s ease;
        }
        
        .navbar-comercio .nav-link.active::after,
        .navbar-comercio .nav-link:hover::after {
            content: '';
            position: absolute;
            bottom: -4px; 
            left: 0;
            width: 100%; 
            height: 2.5px;
            background-color: var(--fs-green);
            border-radius: 2px;
        }
        .navbar-comercio .nav-link.active,
        .navbar-comercio .nav-link:hover { 
            color: var(--fs-green) !important; 
            font-weight: 600;
        }

        .user-profile-icon {
            width: 40px; height: 40px;
            background-color: #e2e8f0; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #64748b; cursor: pointer; transition: 0.3s;
        }
        .user-profile-icon:hover { background-color: var(--fs-green); color: white; }
        .dropdown-menu-user { border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin-top: 15px; }

        .fs-modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.55); display: none; align-items: center;
            justify-content: center; z-index: 1050; opacity: 0; transition: 0.3s;
        }
        .fs-modal-overlay.active { display: flex; opacity: 1; }
        .fs-modal-content {
            background: white; width: 100%; max-width: 520px;
            border-radius: 20px; padding: 40px; position: relative;
            transform: translateY(20px); transition: 0.3s;
        }
        .fs-modal-overlay.active .fs-modal-content { transform: translateY(0); }
        .fs-modal-close {
            position: absolute; top: 15px; right: 20px;
            background: none; border: none; font-size: 24px; color: #888; cursor: pointer;
        }
        .btn-fs-modal-submit {
            background: var(--fs-green); color: white; border: none; padding: 12px;
            border-radius: 10px; width: 100%; font-weight: bold; cursor: pointer; transition: 0.3s;
        }
        .btn-fs-modal-submit:hover { background: var(--fs-green-dark); }

        .fs-footer { 
            background-color: #0a0a0a; 
            color: #fff; 
            padding: 0;
            flex-shrink: 0;
        }
        .footer-link { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.85rem; transition: color 0.3s; }
        .footer-link:hover { color: var(--fs-green); }
        .fs-footer h5 { font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 1rem; font-weight: 600; }
        .copyright-text { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin: 0; }

        @media (max-width: 991px) {
            .nav-center { position: static; transform: none; margin-top: 15px; width: 100%; }
            .navbar-nav { text-align: center; }
            .navbar-comercio .nav-link { margin: 8px 0; display: inline-block; }
            .navbar-comercio .nav-link.active::after,
            .navbar-comercio .nav-link:hover::after { bottom: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top navbar-comercio">
    <div class="container position-relative">
        <a class="navbar-brand" href="{{ route('comercio.dashboard') }}">
            <img src="{{ asset('resources/img/logoheader.png') }}" alt="Logo Foodshare"
                 onerror="this.src='https://placehold.co/180x50/ffffff/45b66f?text=Foodshare'">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navComercio">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navComercio">
            <div class="nav-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('comercio.dashboard') ? 'active' : '' }}"
                           href="{{ route('comercio.dashboard') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('comercio.donaciones') ? 'active' : '' }}"
                           href="{{ route('comercio.donaciones') }}">Mis Publicaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('comercio.estadisticas') ? 'active' : '' }}"
                           href="{{ route('comercio.estadisticas') }}">Estadísticas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('comercio.impacto') ? 'active' : '' }}"
                           href="{{ route('comercio.impacto') }}">Impacto Social</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('comercio.organizaciones') ? 'active' : '' }}"
                           href="{{ route('comercio.organizaciones') }}">Organizaciones</a>
                    </li>
                </ul>
            </div>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <div class="user-profile-icon" id="userDropCom" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user" aria-labelledby="userDropCom">
                        <li>
                            <span class="dropdown-item-text fw-semibold text-dark">
                                {{ Auth::user()->name }}
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Salir
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="page-container">
    @yield('content')
</div>

<footer class="fs-footer">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-8 mb-4 mb-md-0">
                <div class="mb-3">
                    <img src="{{ asset('resources/img/logofooter.png') }}" alt="Foodshare"
                         style="height: 45px; width: auto;"
                         onerror="this.style.display='none'; this.nextSibling.style.display='inline-block'">
                    <span class="text-success fw-bold" style="font-size: 1.5rem; display:none;">foodshare</span>
                </div>
                <p style="font-size:0.85rem; color:rgba(255,255,255,0.6);">
                    Conectando excedentes de alimentos con quienes más lo necesitan en El Salvador.
                </p>
            </div>
            <div class="col-md-4">
                <h5 class="text-white mb-3">Contacto</h5>
                <p class="mb-2">
                    <i class="fa-regular fa-envelope text-success me-2"></i>
                    <span class="text-success">contacto@foodshare.sv</span>
                </p>
            </div>
        </div>
        <hr style="border-color:rgba(255,255,255,0.1); margin: 0 0 15px 0;">
        <div class="row pb-3">
            <div class="col-12 text-center">
                <p class="copyright-text mb-0">
                    &copy; {{ date('Y') }} Foodshare - Proyecto de Cátedra. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>