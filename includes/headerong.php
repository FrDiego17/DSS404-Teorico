<?php
// includes/headerong.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom Style -->
<link rel="stylesheet" href="/DSS404-TEORICO/resources/css/style.css">

<style>
    /* Estilos agregados para soportar nuestros modales y utilidades sobre Genesis */
    .fs-modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        display: none; align-items: center; justify-content: center;
        z-index: 1050; opacity: 0; transition: 0.3s ease;
    }
    .fs-modal-overlay.active { display: flex; opacity: 1; }
    .fs-modal-content {
        background: white; width: 100%; max-width: 500px;
        border-radius: 20px; padding: 40px; position: relative;
        transform: translateY(20px); transition: 0.3s ease;
    }
    .fs-modal-overlay.active .fs-modal-content { transform: translateY(0); }
    .fs-modal-close {
        position: absolute; top: 15px; right: 20px;
        background: none; border: none; font-size: 24px; color: #888; cursor: pointer;
    }
    .fs-org-modal-content {
        background: #f6fae1; width: 100%; max-width: 400px;
        border-radius: 16px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        position: relative; text-align: center; margin: auto;
    }
    .fs-org-logo-large { font-size: 80px; color: #f0ad4e; margin-bottom: 20px; }
    .fs-org-title { font-size: 18px; font-weight: 800; color: #245824; margin-bottom: 10px; }
    .fs-rating { color: #000; margin-bottom: 20px; font-size: 14px; }
    .fs-org-desc { font-size: 13px; color: #333; line-height: 1.5; text-align: left; margin-bottom: 30px; }
    .btn-fs-modal-submit { background: var(--fs-green-main, #45b66f); color: white; border: none; padding: 12px; border-radius: 10px; width: 100%; font-weight: bold; cursor: pointer; }
    .fs-search-input { width: 100%; padding: 15px 25px; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 4px 10px rgba(0,0,0,0.05); outline: none; margin-bottom: 20px;}
    .action-btn-custom { background: none; border: none; color: #666; transition: 0.2s; margin-left: 10px; }
    .action-btn-custom:hover { color: var(--fs-green-main, #45b66f); }
    .action-btn-custom.delete:hover { color: #d9534f; }
    
    /* Corrección para que los links se vean oscuros en el navbar blanco */
    nav.bg-white .navbar-nav .nav-link { color: #333 !important; font-weight: 500; }
    nav.bg-white .navbar-nav .nav-link:hover { color: var(--fs-green-main, #45b66f) !important; }
    nav.bg-white .navbar-nav .nav-link.fw-bold { color: var(--fs-green-main, #45b66f) !important; }
</style>

<nav class="navbar navbar-expand-lg fixed-top bg-white shadow-sm" style="padding: 10px 0;">
    <div class="container position-relative">
        <!-- Espacio para tu logo a la izquierda -->
        <a class="navbar-brand" href="/DSS404-TEORICO/views/ong/inicio-comercio.php">
            <img src="/DSS404-TEORICO/resources/img/logoheader.png" alt="Logo Foodshare" style="height: 45px; width: auto; display: block;">
        </a>

        <!-- Botón Móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navFoodshare">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces centrados -->
        <div class="collapse navbar-collapse" id="navFoodshare">
            <ul class="navbar-nav nav-center">
                <li class="nav-item">
                    <a class="nav-link text-dark <?php echo ($current_page == 'inicio-comercio.php') ? 'fw-bold border-bottom border-success' : ''; ?>" href="/DSS404-TEORICO/views/ong/inicio-comercio.php">Inicio</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link text-dark dropdown-toggle" href="#" id="navbarDropdownPublicar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Publicar
                    </a>
                    <ul class="dropdown-menu dropdown-menu-user" aria-labelledby="navbarDropdownPublicar">
                        <li><a class="dropdown-item" href="/DSS404-TEORICO/views/ong/inicio-comercio.php?openModal=1">Platos Preparados</a></li>
                        <li><a class="dropdown-item" href="/DSS404-TEORICO/views/ong/inicio-comercio.php?openModal=2">Frutas y Verduras</a></li>
                        <li><a class="dropdown-item" href="/DSS404-TEORICO/views/ong/inicio-comercio.php?openModal=3">Panadería y Repostería</a></li>
                        <li><a class="dropdown-item" href="/DSS404-TEORICO/views/ong/inicio-comercio.php?openModal=4">Lácteos y Embutidos</a></li>
                        <li><a class="dropdown-item" href="/DSS404-TEORICO/views/ong/inicio-comercio.php?openModal=5">Carnes</a></li>
                        <li><a class="dropdown-item" href="/DSS404-TEORICO/views/ong/inicio-comercio.php?openModal=6">Bebidas y Jugos</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark <?php echo ($current_page == 'mis-excedentes.php') ? 'fw-bold border-bottom border-success' : ''; ?>" href="/DSS404-TEORICO/views/ong/mis-excedentes.php">Mis Excedentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark <?php echo ($current_page == 'historial.php') ? 'fw-bold border-bottom border-success' : ''; ?>" href="/DSS404-TEORICO/views/ong/historial.php">Historial</a>
                </li>
            </ul>
        </div>

        <!-- Perfil Usuario Derecha -->
        <div class="dropdown">
            <div class="user-profile-icon dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px; background-color: #e0e0e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <i class="fas fa-user text-secondary"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                <li><a class="dropdown-item" href="#">Configuración</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="/DSS404-TEORICO/views/ong/inicio-comercio.php">Cerrar Sesión</a></li>
            </ul>
        </div>

    </div>
</nav>

<!-- Espaciador para el navbar fixed -->
<div style="height: 80px;"></div>
