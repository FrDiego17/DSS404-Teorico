<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare Admin - @yield('title', 'Panel de Administración')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        :root {
            --fs-green: #45b66f;
            --fs-green-dark: #3a9e5e;
            --fs-dark: #1a2a32;
        }
        body { background-color: #eef7ee; padding-top: 80px; }

        .navbar-admin {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 10px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
        }
        .navbar-admin .nav-link {
            color: #333 !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 10px;
            padding: 5px 0;
            position: relative;
            transition: color 0.3s ease;
        }
        .navbar-admin .nav-link.active-link,
        .navbar-admin .nav-link:hover { color: var(--fs-green) !important; }
        .navbar-admin .nav-link.active-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 100%; height: 2px;
            background-color: var(--fs-green);
        }

        .admin-green-blob {
            position: fixed; top: 0; right: 0;
            width: 120px; height: 120px;
            background-color: var(--fs-green);
            border-radius: 0 0 0 100%;
            z-index: 900; pointer-events: none;
        }

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

        .admin-table-wrapper {
            background: white; border-radius: 16px;
            overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .admin-table thead th {
            background-color: var(--fs-green); color: white;
            padding: 14px 12px; text-align: center; font-weight: 600;
        }
        .admin-table tbody td {
            padding: 14px 12px; text-align: center;
            border-bottom: 1px solid #e8f5e9; color: #2d3748;
        }
        .admin-table tbody tr:last-child td { border-bottom: none; }
        .admin-table tbody tr:hover { background: #f0faf3; }
        .btn-action { background: none; border: none; cursor: pointer; padding: 4px 8px; border-radius: 6px; transition: 0.2s; }
        .btn-action.approve { color: white; background: var(--fs-green); }
        .btn-action.delete { color: #e53e3e; }
        .btn-action:hover { opacity: 0.8; transform: scale(1.1); }

        .pub-figma-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px; }
        .pub-figma-card {
            background: white; border-radius: 16px; padding: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06); cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s; border: 1px solid #e8f5e9;
        }
        .pub-figma-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .pub-figma-card .card-img { font-size: 48px; margin-bottom: 12px; display: block; text-align: center; }
        .pub-figma-card .card-title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; }
        .pub-figma-card .card-title { font-size: 13px; font-weight: 700; color: var(--fs-dark); }
        .pub-figma-card .card-qty { font-size: 13px; font-weight: 700; color: var(--fs-dark); }
        .pub-figma-card .card-desc { font-size: 11px; color: #718096; line-height: 1.4; margin-bottom: 10px; }
        .pub-figma-card .card-footer-row { display: flex; justify-content: space-between; align-items: center; }
        .pub-figma-card .card-time { font-size: 11px; color: #718096; }
        .pub-figma-card .card-clock {
            background: var(--fs-green); color: white; border: none;
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; cursor: pointer;
        }

        .impact-ong-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px; }
        .impact-ong-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e8f5e9; }
        .impact-ong-card .card-icon-large { font-size: 48px; margin-bottom: 12px; }
        .impact-ong-card h5 { font-size: 14px; font-weight: 700; color: var(--fs-dark); margin-bottom: 6px; }
        .impact-ong-card p { font-size: 12px; color: #718096; line-height: 1.4; margin: 0; }

        .impact-comercio-card {
            background: white; border-radius: 16px; padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e8f5e9;
            display: flex; flex-direction: column;
        }
        .impact-comercio-card .logo-area { font-size: 60px; text-align: center; margin-bottom: 12px; }
        .impact-comercio-card .title-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
        .impact-comercio-card h5 { font-size: 14px; font-weight: 700; color: var(--fs-dark); margin: 0; }
        .impact-comercio-card .qty { font-size: 14px; font-weight: 700; color: var(--fs-dark); }
        .impact-comercio-card p { font-size: 12px; color: #718096; line-height: 1.4; margin-bottom: 12px; flex: 1; }
        .btn-ver-mas {
            background: var(--fs-green); color: white; border: none;
            border-radius: 20px; padding: 6px 16px; font-size: 12px;
            font-weight: 600; cursor: pointer; transition: 0.2s;
            text-decoration: none; display: inline-block;
        }
        .btn-ver-mas:hover { background: var(--fs-green-dark); color: white; }

        .admin-search-wrap { position: relative; max-width: 480px; margin: 0 auto 30px auto; }
        .admin-search-wrap input {
            width: 100%; padding: 14px 50px 14px 20px;
            border-radius: 30px; border: 1px solid #d0e8d0;
            font-size: 15px; outline: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06); background: white;
        }
        .admin-search-wrap .search-icon {
            position: absolute; right: 18px; top: 50%;
            transform: translateY(-50%); color: #888;
        }

        .admin-section-title {
            font-size: 22px; font-weight: 800; color: var(--fs-dark);
            border-bottom: 2px solid var(--fs-green);
            padding-bottom: 10px; margin-bottom: 24px;
        }

        .elegant-card {
            background: white; border-radius: 16px; padding: 28px 22px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07); cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s; text-align: center;
            border: 1px solid #e8f5e9; height: 100%;
        }
        .elegant-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
        .card-icon-elegant {
            width: 64px; height: 64px; background: #e8f5e9;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 16px;
            font-size: 26px; color: var(--fs-green);
        }
        .elegant-card h4 { font-size: 16px; font-weight: 700; color: var(--fs-dark); margin-bottom: 8px; }
        .elegant-card p { font-size: 13px; color: #718096; margin-bottom: 16px; }
        .btn-elegant {
            background: var(--fs-green); color: white; border: none;
            border-radius: 20px; padding: 8px 20px; font-size: 13px;
            font-weight: 600; text-decoration: none; display: inline-block; transition: 0.3s;
        }
        .btn-elegant:hover { background: var(--fs-green-dark); color: white; }

        /* FOOTER */
        .fs-footer { background-color: #0a0a0a; color: #fff; padding: 0; }
        .footer-link { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.85rem; transition: color 0.3s; }
        .footer-link:hover { color: var(--fs-green); }
        .fs-footer h5 { font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 1rem; font-weight: 600; }
        .copyright-text { font-size: 0.75rem; color: rgba(255,255,255,0.4); margin: 0; }
    </style>
    @stack('styles')
</head>
<body>

<div class="admin-green-blob"></div>

<nav class="navbar navbar-expand-lg fixed-top navbar-admin">
    <div class="container position-relative">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('resources/img/logoheader.png') }}" alt="Foodshare"
                 style="height: 42px; width: auto;"
                 onerror="this.src='https://placehold.co/120x42/ffffff/45b66f?text=Foodshare'">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navAdmin">
            <ul class="navbar-nav">
                <li class="nav-item mx-2">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}"
                       href="{{ route('admin.dashboard') }}">Inicio</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link {{ request()->routeIs('admin.ongs.index') ? 'active-link' : '' }}"
                       href="{{ route('admin.ongs.index') }}">Organizaciones</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link {{ request()->routeIs('admin.comercios.index') ? 'active-link' : '' }}"
                       href="{{ route('admin.comercios.index') }}">Comercios</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link {{ request()->routeIs('admin.publicaciones.index') ? 'active-link' : '' }}"
                       href="{{ route('admin.publicaciones.index') }}">Publicaciones</a>
                </li>
            </ul>
        </div>

        <!-- Perfil y cierre de sesion -->
        <div class="dropdown">
            <div class="dropdown-toggle" id="dropdownAdmin" data-bs-toggle="dropdown"
                 style="width:40px;height:40px;background:#e0e0e0;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                <i class="fas fa-user text-secondary"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAdmin"
                style="border-radius:12px;border:none;box-shadow:0 10px 25px rgba(0,0,0,0.1);">
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
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer class="fs-footer mt-5">
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
                    <span class="text-success">admin@foodshare.sv</span>
                </p>
            </div>
        </div>
        <hr style="border-color:rgba(255,255,255,0.1);">
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
