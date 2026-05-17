<?php
// includes/headeradmin.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/DSS404-TEORICO/resources/css/style.css">

<style>
    /* ===== ADMIN OVERRIDES ===== */
    body { background-color: #eef7ee; }

    nav.bg-white .navbar-nav .nav-link { color: #333 !important; font-weight: 500; }
    nav.bg-white .navbar-nav .nav-link:hover { color: var(--fs-green-main, #45b66f) !important; }
    nav.bg-white .navbar-nav .nav-link.active-link { color: var(--fs-green-main, #45b66f) !important; font-weight: 700; text-decoration: underline; }

    /* Forma verde orgánica (esquina superior derecha) */
    .admin-green-blob {
        position: fixed; top: 0; right: 0; width: 120px; height: 120px;
        background-color: #45b66f; border-radius: 0 0 0 100%;
        z-index: 900; pointer-events: none;
    }

    /* Modales */
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
        background: #45b66f; color: white; border: none; padding: 12px;
        border-radius: 10px; width: 100%; font-weight: bold; cursor: pointer;
        transition: 0.3s;
    }
    .btn-fs-modal-submit:hover { background: #3a9e5e; }

    /* Tablas */
    .admin-table-wrapper { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
    .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .admin-table thead th { background-color: #45b66f; color: white; padding: 14px 12px; text-align: center; font-weight: 600; }
    .admin-table tbody td { padding: 14px 12px; text-align: center; border-bottom: 1px solid #e8f5e9; color: #2d3748; }
    .admin-table tbody tr:last-child td { border-bottom: none; }
    .admin-table tbody tr:hover { background: #f0faf3; }
    .btn-action { background: none; border: none; cursor: pointer; padding: 4px 8px; border-radius: 6px; transition: 0.2s; }
    .btn-action.approve { color: white; background: #45b66f; }
    .btn-action.delete { color: #e53e3e; }
    .btn-action:hover { opacity: 0.8; transform: scale(1.1); }

    /* Cards publicaciones (estilo Figma) */
    .pub-figma-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px; }
    .pub-figma-card {
        background: white; border-radius: 16px; padding: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06); cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s; border: 1px solid #e8f5e9;
    }
    .pub-figma-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .pub-figma-card .card-img { font-size: 48px; margin-bottom: 12px; display: block; text-align: center; }
    .pub-figma-card .card-title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; }
    .pub-figma-card .card-title { font-size: 13px; font-weight: 700; color: #1a2a32; }
    .pub-figma-card .card-qty { font-size: 13px; font-weight: 700; color: #1a2a32; }
    .pub-figma-card .card-desc { font-size: 11px; color: #718096; line-height: 1.4; margin-bottom: 10px; }
    .pub-figma-card .card-footer-row { display: flex; justify-content: space-between; align-items: center; }
    .pub-figma-card .card-time { font-size: 11px; color: #718096; }
    .pub-figma-card .card-clock { background: #45b66f; color: white; border: none; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; cursor: pointer; }

    /* Impacto cards */
    .impact-ong-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 20px; }
    .impact-ong-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e8f5e9; }
    .impact-ong-card .card-icon-large { font-size: 48px; margin-bottom: 12px; }
    .impact-ong-card h5 { font-size: 14px; font-weight: 700; color: #1a2a32; margin-bottom: 6px; }
    .impact-ong-card p { font-size: 12px; color: #718096; line-height: 1.4; margin: 0; }

    /* Comercio cards (con imagen/logo, cantidad y "Ver mas") */
    .impact-comercio-card {
        background: white; border-radius: 16px; padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e8f5e9;
        display: flex; flex-direction: column;
    }
    .impact-comercio-card .logo-area { font-size: 60px; text-align: center; margin-bottom: 12px; }
    .impact-comercio-card .title-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
    .impact-comercio-card h5 { font-size: 14px; font-weight: 700; color: #1a2a32; margin: 0; }
    .impact-comercio-card .qty { font-size: 14px; font-weight: 700; color: #1a2a32; }
    .impact-comercio-card p { font-size: 12px; color: #718096; line-height: 1.4; margin-bottom: 12px; flex: 1; }
    .btn-ver-mas { background: #45b66f; color: white; border: none; border-radius: 20px; padding: 6px 16px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-block; }
    .btn-ver-mas:hover { background: #3a9e5e; color: white; }

    /* Buscador */
    .admin-search-wrap { position: relative; max-width: 480px; margin: 0 auto 30px auto; }
    .admin-search-wrap input { width: 100%; padding: 14px 50px 14px 20px; border-radius: 30px; border: 1px solid #d0e8d0; font-size: 15px; outline: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06); background: white; }
    .admin-search-wrap .search-icon { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); color: #888; }

    /* Sección títulos */
    .admin-section-title { font-size: 22px; font-weight: 800; color: #1a2a32; border-bottom: 2px solid #45b66f; padding-bottom: 10px; margin-bottom: 24px; }
</style>

<nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm" style="padding: 10px 0;">
    <div class="container position-relative">
        <a class="navbar-brand" href="/DSS404-TEORICO/views/admin/inicio-admin.php">
            <img src="/DSS404-TEORICO/resources/img/logoheader.png" alt="Foodshare" style="height: 42px; width: auto;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navAdmin">
            <ul class="navbar-nav">
                <li class="nav-item mx-3">
                    <a class="nav-link <?php echo ($current_page == 'inicio-admin.php') ? 'active-link' : ''; ?>"
                       href="/DSS404-TEORICO/views/admin/inicio-admin.php">Inicio</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link <?php echo ($current_page == 'organizaciones-admin.php') ? 'active-link' : ''; ?>"
                       href="/DSS404-TEORICO/views/admin/organizaciones-admin.php">Organizaciones</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link <?php echo ($current_page == 'comercios-admin.php') ? 'active-link' : ''; ?>"
                       href="/DSS404-TEORICO/views/admin/comercios-admin.php">Comercios</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link <?php echo ($current_page == 'publicaciones-admin.php') ? 'active-link' : ''; ?>"
                       href="/DSS404-TEORICO/views/admin/publicaciones-admin.php">Publicaciones</a>
                </li>
            </ul>
        </div>

        <!-- Perfil Admin -->
        <div class="dropdown">
            <div class="dropdown-toggle" id="dropdownAdmin" data-bs-toggle="dropdown" aria-expanded="false"
                 style="width:40px;height:40px;background:#e0e0e0;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;">
                <i class="fas fa-user text-secondary"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAdmin" style="border-radius:12px;border:none;box-shadow:0 10px 25px rgba(0,0,0,0.1);">
                <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="/DSS404-TEORICO/views/admin/inicio-admin.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Forma verde orgánica esquina superior derecha -->
<div class="admin-green-blob"></div>

<!-- Espaciador -->
<div style="height: 80px;"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
