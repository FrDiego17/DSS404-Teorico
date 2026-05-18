<?php
// views/restaurante/historial.php

$esta_semana = [
    [
        'titulo' => 'Platos Preparados',
        'descripcion' => 'Platos de guisado de carne, arroz, ensalada y una tortilla.',
        'hora' => '19:45 p.m.',
        'cantidad' => 12,
        'icono' => 'fa-utensils',
        'estado' => 'ok'
    ]
];

$mes_pasado = [
    [
        'titulo' => 'Frutas y Verduras',
        'descripcion' => 'Caja de manzanas, uvas, guineos y zanahorias próximas a caducar.',
        'hora' => '19:45 p.m.',
        'cantidad' => 1,
        'icono' => 'fa-carrot',
        'estado' => 'ok'
    ],
    [
        'titulo' => 'Lacteos y Embutidos',
        'descripcion' => 'Cajas de leche de 4 unidades próximas a caducar.',
        'hora' => '19:45 p.m.',
        'cantidad' => 11,
        'icono' => 'fa-cheese',
        'estado' => 'error',
        'mensaje' => 'Nadie llego a recogerlo'
    ]
];

function renderHistorialCard($pub) {
    $estado_class = ($pub['estado'] == 'ok') ? 'text-success' : 'text-danger';
    $estado_icon = ($pub['estado'] == 'ok') ? 'fa-check-circle' : 'fa-times-circle';
    $mensaje_html = isset($pub['mensaje']) ? '<div class="text-danger small mt-1">' . $pub['mensaje'] . '</div>' : '';

    echo '
    <div class="publication-item historial-card">
        <div class="pub-category-icon"><i class="fas ' . $pub['icono'] . '"></i></div>
        <div class="pub-content">
            <div class="pub-title search-title">' . htmlspecialchars($pub['titulo']) . ' <span class="badge bg-secondary ms-2">' . $pub['cantidad'] . ' unds</span></div>
            <div class="pub-description search-desc">' . htmlspecialchars($pub['descripcion']) . '</div>
            <div class="pub-meta">
                <i class="far fa-clock"></i> Recogido a las ' . htmlspecialchars($pub['hora']) . '
                ' . $mensaje_html . '
            </div>
        </div>
        <div class="fs-historial-status ' . $estado_class . '" style="font-size: 24px;">
            <i class="fas ' . $estado_icon . '"></i>
        </div>
    </div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Historial</title>
</head>
<body style="background-color: #f9fbf9;">

<?php include '../../includes/headerong.php'; ?>

<main class="container" style="padding-top: 50px; min-height: 80vh;">
    
    <h2 class="hero-title-new mb-2 text-center" style="font-size: 2.5rem; color: #1a3a2a;">
        Historial de <span>Donaciones</span>
    </h2>
    
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <input type="text" class="fs-search-input" id="searchHistorial" placeholder="Buscar en el historial...">
        </div>
    </div>

    <div class="publications-section mb-5">
        <div class="section-header">
            <h3>Esta Semana</h3>
        </div>
        <div>
            <?php foreach ($esta_semana as $pub) renderHistorialCard($pub); ?>
        </div>
    </div>

    <div class="publications-section mb-5">
        <div class="section-header">
            <h3>El mes pasado</h3>
        </div>
        <div>
            <?php foreach ($mes_pasado as $pub) renderHistorialCard($pub); ?>
        </div>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var searchInput = document.getElementById("searchHistorial");
    
    searchInput.addEventListener("keyup", function() {
        var filter = searchInput.value.toLowerCase();
        var cards = document.querySelectorAll(".historial-card");
        
        cards.forEach(function(card) {
            var title = card.querySelector(".search-title").innerText.toLowerCase();
            var desc = card.querySelector(".search-desc").innerText.toLowerCase();
            
            if (title.includes(filter) || desc.includes(filter)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });
});
</script>

</body>
</html>
