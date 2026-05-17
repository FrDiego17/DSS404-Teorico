<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Conectando excedentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../DSS404-Teorico/resources/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Estilos adicionales para la animación de los círculos */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        .hero-icon-circle {
            animation: float 3s ease-in-out infinite;
        }
        
        .hero-icon-circle:nth-child(2) {
            animation-delay: 1s;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-transparente">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="index.php">
            <img src="../DSS404-Teorico/resources/img/logoheader.png" alt="Logo Foodshare" style="height: 65px; width: 120px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active fw-semibold" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Cómo funciona</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Organizaciones</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Proveedores</a></li>
            </ul>
        </div>
    </div>
</nav>