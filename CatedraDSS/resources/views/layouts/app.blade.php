<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - @yield('title', 'Conectando excedentes')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .hero-icon-circle { animation: float 3s ease-in-out infinite; }
        .hero-icon-circle:nth-child(2) { animation-delay: 1s; }
    </style>
    @stack('styles')
</head>
<body>

{{-- NAVBAR PÚBLICO --}}
@php
    $isHome = request()->routeIs('home');
    $navTheme = $isHome ? 'navbar-dark navbar-transparente' : 'navbar-light bg-white shadow-sm';
    $btnTheme = $isHome ? 'btn-outline-light' : 'btn-outline-success';
@endphp
@if(!$isHome)
<style>
    .navbar-light .nav-link { color: #333333 !important; }
    .navbar-light .nav-link:hover { color: #45b66f !important; }
    .navbar-brand img { filter: brightness(0.2); }
</style>
@endif
<nav class="navbar navbar-expand-lg fixed-top {{ $navTheme }}">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('resources/img/logoheader.png') }}" alt="Logo Foodshare"
                 style="height: 65px; width: 120px;"
                 onerror="this.src='https://placehold.co/120x65/ffffff/45b66f?text=Foodshare'">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active fw-semibold" href="{{ route('home') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Cómo funciona</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Organizaciones</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Proveedores</a></li>
                <li class="nav-item ms-2">
                    <a class="nav-link fw-semibold btn {{ $btnTheme }} btn-sm px-3" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- CONTENIDO --}}
@yield('content')

{{-- FOOTER --}}
<style>
    .fs-footer { background-color: #0a0a0a; color: #ffffff; padding: 0; }
    .footer-description { font-size: 0.85rem; line-height: 1.5; color: rgba(255,255,255,0.6); margin-bottom: 0; }
    .footer-link { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.85rem; transition: color 0.3s ease; }
    .footer-link:hover { color: var(--fs-green); }
    .fs-footer h5 { font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 1rem; font-weight: 600; }
    .copyright-text { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin: 0; }
    .fs-footer hr { margin: 0; border-color: rgba(255,255,255,0.1); }
</style>
<footer class="fs-footer">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-5 mb-4 mb-md-0">
                <div class="mb-3">
                    <img src="{{ asset('resources/img/logofooter.png') }}" alt="Foodshare"
                         style="height: 45px; width: auto;"
                         onerror="this.style.display='none'; this.nextSibling.style.display='inline-block'">
                    <span class="text-success fw-bold" style="font-size: 1.5rem; display: none;">foodshare</span>
                </div>
                <p class="footer-description">
                    Conectando excedentes de alimentos con quienes más lo necesitan en El Salvador.
                    Una iniciativa para reducir el desperdicio y combatir el hambre.
                </p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-white mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('ong.registro') }}" class="footer-link">Registrar ONG</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Preguntas Frecuentes</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Términos y Condiciones</a></li>
                </ul>
            </div>
            <div class="col-md-3">
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
