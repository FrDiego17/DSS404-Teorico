<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - @yield('title', 'Dashboard ONG')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        :root {
            --fs-green-text: #45b66f;
            --fs-nav-links: #333333;
            --fs-bg-header: #fdfefd;
        }
        body { padding-top: 80px; background-color: #f9fbf9; }

        .navbar-minimal {
            background-color: var(--fs-bg-header);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.02);
        }
        .navbar-brand img { height: 45px; width: auto; display: block; }
        .nav-center { position: absolute; left: 50%; transform: translateX(-50%); }
        .navbar-minimal .nav-link {
            color: var(--fs-nav-links) !important;
            font-weight: 500;
            font-size: 1rem;
            margin: 0 10px;
            padding: 5px 0;
            position: relative;
            white-space: nowrap;
            transition: color 0.3s ease;
        }
        .navbar-minimal .nav-link.active::after,
        .navbar-minimal .nav-link:hover::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 100%; height: 2px;
            background-color: var(--fs-green-text);
        }
        .navbar-minimal .nav-link:hover { color: var(--fs-green-text) !important; }
        .user-profile-icon {
            width: 40px; height: 40px;
            background-color: #e0e0e0;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #777; cursor: pointer; transition: 0.3s;
        }
        .user-profile-icon:hover { background-color: var(--fs-green-text); color: white; }
        .dropdown-menu-user { border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin-top: 15px; }
        @media (max-width: 991px) {
            .nav-center { position: static; transform: none; margin-top: 20px; width: 100%; }
            .navbar-nav { text-align: center; }
        }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top navbar-minimal">
    <div class="container position-relative">
        <a class="navbar-brand" href="{{ route('ong.dashboard') }}">
            <img src="{{ asset('resources/img/logoheader.png') }}" alt="Logo Foodshare"
                 onerror="this.src='https://placehold.co/180x50/ffffff/45b66f?text=Foodshare'">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navFoodshare">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navFoodshare">
            <div class="nav-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-nowrap {{ request()->routeIs('ong.voluntarios') ? 'active' : '' }}"
                        href="{{ route('ong.voluntarios') }}">Registrar Voluntarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ong.reservados') ? 'active' : '' }}"
                        href="{{ route('ong.reservados') }}">Reservados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ong.historial') ? 'active' : '' }}"
                        href="{{ route('ong.historial') }}">Historial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-nowrap {{ request()->routeIs('ong.impactos') ? 'active' : '' }}"
                        href="{{ route('ong.impactos') }}">Mis Impactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ong.proveedores') ? 'active' : '' }}"
                        href="{{ route('ong.proveedores') }}">Proveedores</a>
                    </li>
                </ul>
            </div>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <div class="user-profile-icon" id="userDrop" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user" aria-labelledby="userDrop">
                        <li>
                            <span class="dropdown-item-text fw-semibold text-dark">
                                {{ Auth::user()->name }}
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-id-card me-2"></i> Perfil</a></li>
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

{{-- FOOTER --}}
<style>
    .fs-footer { background-color: #0a0a0a; color: #ffffff; padding: 0; }
    .footer-description { font-size: 0.85rem; line-height: 1.5; color: rgba(255,255,255,0.6); margin-bottom: 0; }
    .footer-link { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.85rem; transition: color 0.3s ease; }
    .footer-link:hover { color: var(--fs-green-text); }
    .fs-footer h5 { font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 1rem; font-weight: 600; }
    .copyright-text { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin: 0; }
    .fs-footer hr { margin: 0; border-color: rgba(255,255,255,0.1); }
</style>
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
                <p class="footer-description">
                    Conectando excedentes de alimentos con quienes más lo necesitan en El Salvador.
                </p>
            </div>
            <div class="col-md-4">
                <h5 class="text-white mb-3">Contacto</h5>
                <p class="mb-2">
                    <i class="fa-regular fa-envelope text-success me-2"></i>
                    <span class="text-success">contacto@foodshare.sv</span>
                </p>
                <p class="mb-0">
                    <i class="fa-solid fa-phone text-success me-2"></i>
                    <span class="text-success">+503 2200-0000</span>
                </p>
            </div>
        </div>
        <hr class="border-secondary opacity-25 my-3">
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
