<?php
// views/restaurante/mis-excedentes.php
$platos_preparados = [
    [
        'titulo' => 'Platos Preparados',
        'descripcion' => 'Platos de guisado de carne, arroz, ensalada y una tortilla.',
        'hora' => '19:45 p.m.',
        'cantidad' => 12,
        'icono' => 'fa-utensils'
    ],
    [
        'titulo' => 'Platos Preparados',
        'descripcion' => 'Platos de picado de verdura, casamiento y ensalada.',
        'hora' => '19:45 p.m.',
        'cantidad' => 6,
        'icono' => 'fa-utensils'
    ]
];

$frutas_verduras = [
    [
        'titulo' => 'Frutas y Verduras',
        'descripcion' => 'Caja de manzanas, uvas, guineos y zanahorias próximas a caducar.',
        'hora' => '19:45 p.m.',
        'cantidad' => 1,
        'icono' => 'fa-apple-alt'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Mis Excedentes</title>
</head>
<body style="background-color: #f9fbf9;">

<?php include '../../includes/headerong.php'; ?>

<main class="container" style="padding-top: 50px; min-height: 80vh;">

    <h2 class="hero-title-new mb-4 text-center" style="font-size: 2.5rem; color: #1a3a2a;">
        Mis <span>Excedentes Activos</span>
    </h2>

    <!-- SECCION: Platos Preparados -->
    <div class="publications-section mb-5">
        <div class="section-header">
            <h3><i class="fas fa-utensils me-2"></i> Platos Preparados</h3>
        </div>
        
        <div>
            <?php foreach ($platos_preparados as $pub): ?>
                <div class="publication-item">
                    <div class="pub-category-icon"><i class="fas <?php echo $pub['icono']; ?>"></i></div>
                    <div class="pub-content">
                        <div class="pub-title"><?php echo htmlspecialchars($pub['titulo']); ?> <span class="badge bg-success ms-2"><?php echo $pub['cantidad']; ?> unds</span></div>
                        <div class="pub-description"><?php echo htmlspecialchars($pub['descripcion']); ?></div>
                        <div class="pub-meta">
                            <i class="far fa-clock"></i> Recoger antes de <?php echo htmlspecialchars($pub['hora']); ?>
                        </div>
                    </div>
                    <button class="pub-request-btn fs-pub-btn">
                        Editar / Renovar <i class="fas fa-pencil-alt ms-1"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- SECCION: Frutas y Verduras -->
    <div class="publications-section mb-5">
        <div class="section-header">
            <h3><i class="fas fa-carrot me-2"></i> Frutas y Verduras</h3>
        </div>
        
        <div>
            <?php foreach ($frutas_verduras as $pub): ?>
                <div class="publication-item">
                    <div class="pub-category-icon"><i class="fas <?php echo $pub['icono']; ?>"></i></div>
                    <div class="pub-content">
                        <div class="pub-title"><?php echo htmlspecialchars($pub['titulo']); ?> <span class="badge bg-success ms-2"><?php echo $pub['cantidad']; ?> cajas</span></div>
                        <div class="pub-description"><?php echo htmlspecialchars($pub['descripcion']); ?></div>
                        <div class="pub-meta">
                            <i class="far fa-clock"></i> Recoger antes de <?php echo htmlspecialchars($pub['hora']); ?>
                        </div>
                    </div>
                    <button class="pub-request-btn fs-pub-btn">
                        Editar / Renovar <i class="fas fa-pencil-alt ms-1"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var clockBtns = document.querySelectorAll(".fs-pub-btn");
    clockBtns.forEach(function(btn) {
        btn.addEventListener("click", function() {
            alert("Redirigiendo a edición/renovación del excedente seleccionado...");
        });
    });
});
</script>

</body>
</html>
