<?php
// views/admin/inicio-admin.php

$publicaciones = [
    ['titulo' => 'Platos Preparados', 'descripcion' => 'Platos de guisado de carne, arroz, ensalada y una tortilla.', 'hora' => '19:45 p.m.', 'cantidad' => 12, 'emoji' => '🍽️'],
    ['titulo' => 'Panadería y Repostería', 'descripcion' => 'Pan empaquetado próximo a caducar.', 'hora' => '18:30 p.m.', 'cantidad' => 8, 'emoji' => '🥐'],
    ['titulo' => 'Frutas y Verduras', 'descripcion' => 'Caja de manzanas, uvas, guineos y zanahorias próximas a caducar.', 'hora' => '19:45 p.m.', 'cantidad' => 1, 'emoji' => '🥦'],
    ['titulo' => 'Bebidas y Jugos', 'descripcion' => 'Excedente de jugos naturales preparados del día.', 'hora' => '19:45 p.m.', 'cantidad' => 11, 'emoji' => '🧃'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Admin Inicio</title>
</head>
<body>

<?php include '../../includes/headeradmin.php'; ?>

<!-- HERO: estilo orgánico con blob verde -->
<section style="background-color: #eef7ee; padding: 60px 0; margin-bottom: 50px; position: relative; overflow: hidden;">
    <!-- Forma verde grande -->
    <div style="position: absolute; top: -80px; right: -120px; width: 520px; height: 520px; background-color: #45b66f; border-radius: 50%; z-index: 1;"></div>

    <!-- Círculos de imágenes decorativos -->
    <div style="position: absolute; top: 20px; right: 80px; width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 4px solid white; z-index: 2; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
        <img src="/DSS404-TEORICO/resources/img/index.png" alt="" style="width:100%; height:100%; object-fit:cover;">
    </div>
    <div style="position: absolute; top: 140px; right: 30px; width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 4px solid white; z-index: 2; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
        <img src="/DSS404-TEORICO/resources/img/header.jpeg" alt="" style="width:100%; height:100%; object-fit:cover;">
    </div>
    <div style="position: absolute; bottom: 30px; right: 120px; width: 70px; height: 70px; border-radius: 50%; overflow: hidden; border: 4px solid white; z-index: 2; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
        <img src="/DSS404-TEORICO/resources/img/index.png" alt="" style="width:100%; height:100%; object-fit:cover;">
    </div>

    <div class="container" style="position: relative; z-index: 3;">
        <div class="row">
            <div class="col-lg-7">
                <p style="font-size: 1rem; color: #666; margin-bottom: 4px;">
                    BIENVENIDO <strong style="color: #45b66f;">Administrador</strong>
                </p>
                <h1 style="font-size: 2.2rem; font-weight: 900; color: #1a2a32; line-height: 1.2; margin-bottom: 16px;">
                    Comprueba los Comercios y ONG Registrados
                </h1>
                <p style="color: #555; max-width: 420px; font-size: 0.95rem; margin-bottom: 28px;">
                    Las donaciones que realizas no solo reducen tus excedentes, también transforman a la comunidad y ayudan a los que necesitan.
                </p>
                <a href="/DSS404-TEORICO/views/admin/comercios-admin.php" class="btn-fs-modal-submit" style="display:inline-block; width:auto; padding: 12px 30px; text-decoration:none; border-radius: 30px;">
                    Administra los Registros
                </a>
            </div>
        </div>
    </div>
</section>

<main class="container mb-5">

    <!-- ELEGANT CARDS -->
    <div class="row features-grid mb-5">
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='/DSS404-TEORICO/views/admin/comercios-admin.php'">
                <div class="card-icon-elegant"><i class="fas fa-store"></i></div>
                <h4>Estadística de Registros</h4>
                <p>Conoce a los comercios registrados que realizan las donaciones de excedentes.</p>
                <a href="/DSS404-TEORICO/views/admin/comercios-admin.php" class="btn-elegant">Ver Comercios</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='/DSS404-TEORICO/views/admin/publicaciones-admin.php'">
                <div class="card-icon-elegant"><i class="fas fa-hands-holding-circle"></i></div>
                <h4>Impacto Social</h4>
                <p>Historias de cambios que se han logrado con los aportes que realizan las donaciones.</p>
                <a href="/DSS404-TEORICO/views/admin/publicaciones-admin.php" class="btn-elegant">Ver Impacto</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='/DSS404-TEORICO/views/admin/organizaciones-admin.php'">
                <div class="card-icon-elegant"><i class="fas fa-hand-holding-heart"></i></div>
                <h4>Organizaciones Sociales</h4>
                <p>Conoce las organizaciones registradas que pueden recoger tus excedentes.</p>
                <a href="/DSS404-TEORICO/views/admin/organizaciones-admin.php" class="btn-elegant">Ver Organizaciones</a>
            </div>
        </div>
    </div>

    <!-- TODAS LAS PUBLICACIONES -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #1a2a32; margin: 0;">Todas las Publicaciones</h2>
        <a href="/DSS404-TEORICO/views/admin/publicaciones-admin.php" style="color: #45b66f; font-weight: 600; text-decoration: none; font-size: 0.9rem;">Ver más &rsaquo;</a>
    </div>

    <div class="pub-figma-grid mb-5">
        <?php foreach ($publicaciones as $pub): ?>
            <div class="pub-figma-card">
                <span class="card-img"><?php echo $pub['emoji']; ?></span>
                <div class="card-title-row">
                    <span class="card-title"><?php echo $pub['titulo']; ?></span>
                    <span class="card-qty"><?php echo $pub['cantidad']; ?></span>
                </div>
                <p class="card-desc"><?php echo $pub['descripcion']; ?></p>
                <div class="card-footer-row">
                    <span class="card-time"><?php echo $pub['hora']; ?></span>
                    <button class="card-clock btn-pub-detail"
                        data-titulo="<?php echo htmlspecialchars($pub['titulo']); ?>"
                        data-emoji="<?php echo $pub['emoji']; ?>"
                        data-desc="<?php echo htmlspecialchars($pub['descripcion']); ?>"
                        data-hora="<?php echo htmlspecialchars($pub['hora']); ?>"
                        data-cantidad="<?php echo $pub['cantidad']; ?>">
                        <i class="fas fa-clock"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>

<!-- MODAL: Detalle Publicación Inicio -->
<div class="fs-modal-overlay" id="modalPubInicio">
    <div class="fs-modal-content" style="max-width: 440px;">
        <button class="fs-modal-close" onclick="document.getElementById('modalPubInicio').classList.remove('active')">&times;</button>
        <div style="font-size:52px; text-align:center; margin-bottom:12px;" id="mpEmoji"></div>
        <h4 id="mpTitulo" style="font-weight:800; color:#1a2a32; text-align:center;"></h4>
        <p id="mpDesc" style="color:#718096; font-size:13px; text-align:center; margin-bottom:16px;"></p>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
            <div style="background:#f0faf3; border-radius:10px; padding:12px;">
                <div style="font-size:11px; color:#718096;">CANTIDAD</div>
                <div id="mpCantidad" style="font-size:20px; font-weight:800; color:#1a2a32;"></div>
            </div>
            <div style="background:#f0faf3; border-radius:10px; padding:12px;">
                <div style="font-size:11px; color:#718096;">HORA LÍMITE</div>
                <div id="mpHora" style="font-size:16px; font-weight:800; color:#1a2a32;"></div>
            </div>
        </div>
        <button class="btn-fs-modal-submit" onclick="document.getElementById('modalPubInicio').classList.remove('active')">Cerrar</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".btn-pub-detail").forEach(function(btn) {
        btn.addEventListener("click", function() {
            document.getElementById("mpEmoji").innerText = this.dataset.emoji;
            document.getElementById("mpTitulo").innerText = this.dataset.titulo;
            document.getElementById("mpDesc").innerText = this.dataset.desc;
            document.getElementById("mpCantidad").innerText = this.dataset.cantidad + " unds";
            document.getElementById("mpHora").innerText = this.dataset.hora;
            document.getElementById("modalPubInicio").classList.add("active");
        });
    });
    document.getElementById("modalPubInicio").addEventListener("click", function(e) {
        if (e.target === this) this.classList.remove("active");
    });
});
</script>

</body>
</html>
