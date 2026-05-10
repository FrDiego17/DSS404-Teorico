<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Header Minimalista</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --fs-green-text: #45b66f;
            --fs-nav-links: #333333;
            --fs-bg-header: #fdfefd; /* Un blanco casi puro muy elegante */
        }

        body {
            padding-top: 80px; /* Ajuste para que el contenido no quede debajo */
            background-color: #f9fbf9;
        }

        /* ===== NAVBAR ESTILO FIGMA (IMAGE_723706.PNG) ===== */
        .navbar-minimal {
            background-color: var(--fs-bg-header);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.02);
        }

        /* Espacio para tu logo a la izquierda */
        .navbar-brand img {
            height: 45px;
            width: auto;
            display: block;
        }

        /* Enlaces centrados */
        .nav-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .navbar-minimal .nav-link {
            color: var(--fs-nav-links) !important;
            font-weight: 500;
            font-size: 1rem;
            margin: 0 15px;
            padding: 5px 0;
            position: relative;
            transition: color 0.3s ease;
        }

        /* Efecto de línea debajo (como en 'Reservados' de la imagen) */
        .navbar-minimal .nav-link.active::after,
        .navbar-minimal .nav-link:hover::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--fs-green-text);
        }

        .navbar-minimal .nav-link:hover {
            color: var(--fs-green-text) !important;
        }

        /* Icono de usuario a la derecha */
        .user-profile-icon {
            width: 40px;
            height: 40px;
            background-color: #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            cursor: pointer;
            transition: 0.3s;
        }

        .user-profile-icon:hover {
            background-color: var(--fs-green-text);
            color: white;
        }

        /* Dropdown personalizado */
        .dropdown-menu-user {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin-top: 15px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .nav-center {
                position: static;
                transform: none;
                margin-top: 20px;
                width: 100%;
            }
            .navbar-nav {
                text-align: center;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top navbar-minimal">
    <div class="container position-relative">
        <a class="navbar-brand" href="dashboard_ong.php">
            <img src="/DSS404-TEORICO/resources/img/logoheader.png" alt="Logo Foodshare" onerror="this.src='https://placehold.co/180x50/ffffff/45b66f?text=Foodshare'">
        </a>

        <!-- Botón Móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navFoodshare">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navFoodshare">
            <div class="nav-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard_ong.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registroVoluntarios.php">Registrar Voluntarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservados.php">Reservados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historial_ong.php">Historial</a>
                    </li>
                </ul>
            </div>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <div class="user-profile-icon" id="userDrop" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user" aria-labelledby="userDrop">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-id-card me-2"></i> Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Salir</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>

<!-- JS de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>