<?php
// views/ong/estadisticas.php
$estadisticas = [
    ['titulo' => 'Platos Preparados', 'cantidad' => 48, 'color' => '#e66a6a', 'porcentaje' => 60],
    ['titulo' => 'Frutas y Verduras', 'cantidad' => 124, 'color' => '#df9d5f', 'porcentaje' => 31],
    ['titulo' => 'Panadería y Rep.', 'cantidad' => 12, 'color' => '#ded164', 'porcentaje' => 20],
    ['titulo' => 'Lacteos y Emb.', 'cantidad' => 9, 'color' => '#5eb15f', 'porcentaje' => 49],
    ['titulo' => 'Carnes', 'cantidad' => 6, 'color' => '#6e8aed', 'porcentaje' => 39],
    ['titulo' => 'Bebidas y Jugos', 'cantidad' => 2, 'color' => '#b96dec', 'porcentaje' => 60]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Estadísticas</title>
    <style>
        .fs-chart-container {
            background: white; border-radius: 25px; padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); height: 100%;
        }
        .fs-stat-box {
            border-radius: 20px; padding: 15px; color: #fff; text-align: center; margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: 0.3s;
        }
        .fs-stat-box:hover { transform: translateY(-3px); }
        .fs-bar-chart {
            display: flex; height: 350px; position: relative; padding-left: 50px;
            border-bottom: 2px solid #e2e8f0; border-left: 2px solid #e2e8f0;
        }
        .fs-y-axis {
            position: absolute; left: 0; top: 0; bottom: 0; width: 40px;
            display: flex; flex-direction: column; justify-content: space-between;
            font-size: 11px; color: #718096; text-align: right; padding-bottom: 10px;
        }
        .fs-bars-area {
            display: flex; align-items: flex-end; justify-content: space-around; width: 100%; height: 100%;
        }
        .fs-bar-column { width: 45px; height: 100%; display: flex; align-items: flex-end; }
        .fs-bar { width: 100%; border-radius: 4px 4px 0 0; transition: height 0.5s ease; cursor: pointer; }
        .fs-bar:hover { opacity: 0.8; }
    </style>
</head>
<body style="background-color: #f9fbf9;">

<?php include '../../includes/headerong.php'; ?>

<main class="container" style="padding-top: 50px; min-height: 80vh;">
    
    <h2 class="hero-title-new mb-5 text-center" style="font-size: 2.5rem; color: #1a3a2a;">
        Estadísticas de <span>Donaciones</span>
    </h2>

    <div class="row mb-5">
        <!-- Sidebar -->
        <div class="col-md-3">
            <?php foreach ($estadisticas as $stat): ?>
                <div class="fs-stat-box" style="background-color: <?php echo $stat['color']; ?>;">
                    <div style="font-size: 13px; font-weight: 700; opacity: 0.9;"><?php echo htmlspecialchars($stat['titulo']); ?></div>
                    <div style="font-size: 28px; font-weight: 900;"><?php echo $stat['cantidad']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Chart -->
        <div class="col-md-9">
            <div class="fs-chart-container">
                <h3 class="text-center fw-bold mb-4" style="color: #2d3748;">Los Excedentes del Mes</h3>
                <div class="fs-bar-chart">
                    <div class="fs-y-axis">
                        <span>100%</span><span>90%</span><span>80%</span><span>70%</span><span>60%</span>
                        <span>50%</span><span>40%</span><span>30%</span><span>20%</span><span>0%</span>
                    </div>
                    <div class="fs-bars-area">
                        <?php foreach ($estadisticas as $stat): ?>
                            <div class="fs-bar-column">
                                <div class="fs-bar" title="<?php echo $stat['titulo'] . ': ' . $stat['cantidad']; ?>" style="height: <?php echo $stat['porcentaje']; ?>%; background-color: <?php echo $stat['color']; ?>;"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>

</body>
</html>
