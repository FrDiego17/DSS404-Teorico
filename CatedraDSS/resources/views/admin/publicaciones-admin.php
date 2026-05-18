<?php
// views/admin/publicaciones-admin.php

$impacto_ong = [
    ['titulo' => 'Programa de rescate', 'descripcion' => 'Entregamos paquetes de alimentos básicos, a las personas de la calle de Soyapango.', 'emoji' => '🍽️', 'detalle' => 'Este programa opera todos los días de 6am a 9am. Atendemos a más de 200 personas al mes y distribuimos cajas con arroz, frijoles, aceite y otros productos esenciales rescatados de comercios locales.'],
    ['titulo' => 'Comedores comunitarios', 'descripcion' => 'Apoyamos comedores comunitarios que brindan comidas nutritivas a niños, adultos mayores y familias de escasos recursos.', 'emoji' => '🍽️', 'detalle' => 'Operamos 3 comedores en San Salvador, Soyapango y Mejicanos. Cada comedor sirve entre 80 y 120 comidas al día, 5 días a la semana, utilizando alimentos rescatados o donados por comercios aliados.'],
];

$impacto_comercios = [
    ['nombre' => 'Comedor Don Bosco', 'cantidad' => 12, 'descripcion' => 'Transformamos el excedente de alimentos en oportunidades de nutrición para quienes más lo necesitan.', 'emoji' => '🍳', 'ubicacion' => 'Soyapango, San Salvador', 'telefono' => '7890-1234', 'tipo' => 'Comedor'],
    ['nombre' => 'Sabor Compartido', 'cantidad' => 6, 'descripcion' => 'Cada plato que no se vende se transforma en una oportunidad para alimentar a alguien más.', 'emoji' => '👨‍🍳', 'ubicacion' => 'Santa Tecla, La Libertad', 'telefono' => '7891-5678', 'tipo' => 'Restaurante'],
    ['nombre' => 'Mesa Solidaria', 'cantidad' => 6, 'descripcion' => 'Rescatamos alimentos del día para convertirlos en comidas dignas para personas que lo necesitan.', 'emoji' => '🌍', 'ubicacion' => 'Centro, San Salvador', 'telefono' => '7892-9012', 'tipo' => 'ONG Comercial'],
];

$publicaciones = [
    ['titulo' => 'Platos Preparados', 'descripcion' => 'Platos de guisado de carne, arroz, ensalada y una tortilla.', 'hora' => '19:45 p.m.', 'cantidad' => 12, 'emoji' => '🍽️', 'comercio' => 'Comedor Esperanza', 'estado' => 'Disponible'],
    ['titulo' => 'Panadería y Repostería', 'descripcion' => 'Pan empaquetado próximo a caducar.', 'hora' => '18:30 p.m.', 'cantidad' => 8, 'emoji' => '🥐', 'comercio' => 'Panadería La Vega', 'estado' => 'Reservado'],
    ['titulo' => 'Frutas y Verduras', 'descripcion' => 'Caja de manzanas, uvas, guineos y zanahorias próximas a caducar.', 'hora' => '19:45 p.m.', 'cantidad' => 1, 'emoji' => '🥦', 'comercio' => 'Supermercado Don Pepe', 'estado' => 'Disponible'],
    ['titulo' => 'Bebidas y Jugos', 'descripcion' => 'Excedente de jugos naturales preparados del día.', 'hora' => '19:45 p.m.', 'cantidad' => 11, 'emoji' => '🧃', 'comercio' => 'Jugos Express', 'estado' => 'Disponible'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Publicaciones Admin</title>
    <style>
        /* Modal detalle impacto comercio */
        .modal-emoji-header { font-size: 64px; text-align: center; margin-bottom: 16px; }
        .modal-badge { display: inline-block; background: #e8f5e9; color: #2e7d32; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 16px; }
        .modal-info-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; font-size: 14px; color: #555; }
        .modal-info-row i { color: #45b66f; width: 18px; }
        /* Modal publicación detalle */
        .pub-modal-header { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
        .pub-modal-emoji { font-size: 52px; }
        .pub-modal-title { font-size: 18px; font-weight: 800; color: #1a2a32; }
        .pub-modal-comercio { font-size: 13px; color: #718096; }
        .status-pill { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .status-disponible { background: #e8f5e9; color: #2e7d32; }
        .status-reservado { background: #fff3e0; color: #e65100; }
        .pub-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 16px 0; }
        .pub-detail-item { background: #f9fbf9; border-radius: 10px; padding: 12px; }
        .pub-detail-item .label { font-size: 11px; color: #718096; text-transform: uppercase; letter-spacing: 0.5px; }
        .pub-detail-item .value { font-size: 16px; font-weight: 700; color: #1a2a32; margin-top: 2px; }
        /* Modal confirmación aprobar */
        .confirm-icon { font-size: 56px; text-align: center; margin-bottom: 16px; }
    </style>
</head>
<body>

<?php include '../../includes/headeradmin.php'; ?>

<main class="container" style="padding-top: 20px; min-height: 75vh; padding-bottom: 60px;">

    <!-- BUSCADOR -->
    <div class="admin-search-wrap">
        <input type="text" id="searchPublicaciones" placeholder="Buscar en publicaciones...">
        <i class="fas fa-search search-icon"></i>
    </div>

    <!-- IMPACTO SOCIAL ONG -->
    <h2 class="admin-section-title">Impacto Social ONG</h2>
    <div class="impact-ong-grid mb-5">
        <?php foreach ($impacto_ong as $i => $item): ?>
            <div class="impact-ong-card search-card" style="cursor:pointer;"
                 onclick="abrirModalONG('<?php echo addslashes($item['titulo']); ?>', '<?php echo addslashes($item['descripcion']); ?>', '<?php echo $item['emoji']; ?>', '<?php echo addslashes($item['detalle']); ?>')">
                <div class="card-icon-large"><?php echo $item['emoji']; ?></div>
                <h5 class="search-title"><?php echo htmlspecialchars($item['titulo']); ?></h5>
                <p class="search-desc"><?php echo htmlspecialchars($item['descripcion']); ?></p>
                <span style="color:#45b66f; font-size:13px; font-weight:600;">Ver detalles →</span>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- IMPACTO SOCIAL COMERCIOS -->
    <h2 class="admin-section-title">Impacto Social Comercios</h2>
    <div class="row mb-5">
        <?php foreach ($impacto_comercios as $com): ?>
            <div class="col-md-4 mb-4 search-card">
                <div class="impact-comercio-card h-100">
                    <div class="logo-area"><?php echo $com['emoji']; ?></div>
                    <div class="title-row">
                        <h5><?php echo htmlspecialchars($com['nombre']); ?></h5>
                        <span class="qty"><?php echo $com['cantidad']; ?></span>
                    </div>
                    <p class="search-desc"><?php echo htmlspecialchars($com['descripcion']); ?></p>
                    <a href="#" class="btn-ver-mas"
                       data-nombre="<?php echo htmlspecialchars($com['nombre']); ?>"
                       data-emoji="<?php echo $com['emoji']; ?>"
                       data-tipo="<?php echo htmlspecialchars($com['tipo']); ?>"
                       data-ubicacion="<?php echo htmlspecialchars($com['ubicacion']); ?>"
                       data-telefono="<?php echo htmlspecialchars($com['telefono']); ?>"
                       data-cantidad="<?php echo $com['cantidad']; ?>"
                       data-desc="<?php echo htmlspecialchars($com['descripcion']); ?>">
                        Ver mas →
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- PUBLICACIONES EXCEDENTES -->
    <h2 class="admin-section-title">Publicaciones Excedentes</h2>
    <div class="pub-figma-grid mb-5">
        <?php foreach ($publicaciones as $pub): ?>
            <div class="pub-figma-card search-card">
                <span class="card-img"><?php echo $pub['emoji']; ?></span>
                <div class="card-title-row">
                    <span class="card-title search-title"><?php echo $pub['titulo']; ?></span>
                    <span class="card-qty"><?php echo $pub['cantidad']; ?></span>
                </div>
                <p class="card-desc search-desc"><?php echo $pub['descripcion']; ?></p>
                <div class="card-footer-row">
                    <span class="card-time"><?php echo $pub['hora']; ?></span>
                    <button class="card-clock btn-ver-pub"
                        data-titulo="<?php echo htmlspecialchars($pub['titulo']); ?>"
                        data-emoji="<?php echo $pub['emoji']; ?>"
                        data-desc="<?php echo htmlspecialchars($pub['descripcion']); ?>"
                        data-hora="<?php echo htmlspecialchars($pub['hora']); ?>"
                        data-cantidad="<?php echo $pub['cantidad']; ?>"
                        data-comercio="<?php echo htmlspecialchars($pub['comercio']); ?>"
                        data-estado="<?php echo htmlspecialchars($pub['estado']); ?>">
                        <i class="fas fa-clock"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>

<!-- MODAL: Impacto ONG -->
<div class="fs-modal-overlay" id="modalONG">
    <div class="fs-modal-content" style="max-width: 460px;">
        <button class="fs-modal-close" onclick="cerrarModal('modalONG')">&times;</button>
        <div class="modal-emoji-header" id="modalONGEmoji">🍽️</div>
        <h4 id="modalONGTitulo" style="font-weight:800; color:#1a2a32; text-align:center; margin-bottom:8px;"></h4>
        <p id="modalONGDesc" style="color:#718096; font-size:13px; text-align:center; margin-bottom:16px;"></p>
        <div style="background:#f0faf3; border-radius:12px; padding:16px;">
            <p id="modalONGDetalle" style="font-size:13px; color:#2d3748; line-height:1.6; margin:0;"></p>
        </div>
        <button class="btn-fs-modal-submit mt-4" onclick="cerrarModal('modalONG')">Entendido</button>
    </div>
</div>

<!-- MODAL: Impacto Comercio -->
<div class="fs-modal-overlay" id="modalComercio">
    <div class="fs-modal-content" style="max-width: 440px;">
        <button class="fs-modal-close" onclick="cerrarModal('modalComercio')">&times;</button>
        <div class="modal-emoji-header" id="modalComEmoji"></div>
        <span class="modal-badge" id="modalComTipo"></span>
        <h4 id="modalComNombre" style="font-weight:800; color:#1a2a32; margin-bottom:4px;"></h4>
        <p id="modalComDesc" style="color:#718096; font-size:13px; margin-bottom:16px;"></p>
        <div class="modal-info-row"><i class="fas fa-map-marker-alt"></i><span id="modalComUbicacion"></span></div>
        <div class="modal-info-row"><i class="fas fa-phone"></i><span id="modalComTelefono"></span></div>
        <div class="modal-info-row"><i class="fas fa-hand-holding-heart"></i><span id="modalComCantidad"></span> publicaciones activas</div>
        <button class="btn-fs-modal-submit mt-3" onclick="cerrarModal('modalComercio')">Cerrar</button>
    </div>
</div>

<!-- MODAL: Detalle Publicación -->
<div class="fs-modal-overlay" id="modalPub">
    <div class="fs-modal-content" style="max-width: 460px;">
        <button class="fs-modal-close" onclick="cerrarModal('modalPub')">&times;</button>
        <div class="pub-modal-header">
            <div class="pub-modal-emoji" id="modalPubEmoji"></div>
            <div>
                <div class="pub-modal-title" id="modalPubTitulo"></div>
                <div class="pub-modal-comercio" id="modalPubComercio"></div>
                <span class="status-pill mt-1" id="modalPubEstado"></span>
            </div>
        </div>
        <p id="modalPubDesc" style="color:#718096; font-size:14px;"></p>
        <div class="pub-detail-grid">
            <div class="pub-detail-item">
                <div class="label">Cantidad disponible</div>
                <div class="value" id="modalPubCantidad"></div>
            </div>
            <div class="pub-detail-item">
                <div class="label">Hora límite</div>
                <div class="value" id="modalPubHora"></div>
            </div>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button class="btn-fs-modal-submit" style="background:#e53e3e;" onclick="cerrarModal('modalPub')">
                <i class="fas fa-times me-2"></i>Cancelar Publicación
            </button>
            <button class="btn-fs-modal-submit" onclick="cerrarModal('modalPub')">
                <i class="fas fa-check me-2"></i>Confirmar
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Buscador global
    document.getElementById("searchPublicaciones").addEventListener("keyup", function () {
        var filter = this.value.toLowerCase();
        document.querySelectorAll(".search-card").forEach(function (card) {
            var title = (card.querySelector(".search-title") || {innerText: ""}).innerText.toLowerCase();
            var desc = (card.querySelector(".search-desc") || {innerText: ""}).innerText.toLowerCase();
            card.style.display = (title.includes(filter) || desc.includes(filter)) ? "" : "none";
        });
    });

    // Botones "Ver mas" Impacto Comercios
    document.querySelectorAll(".btn-ver-mas").forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById("modalComEmoji").innerText = this.dataset.emoji;
            document.getElementById("modalComTipo").innerText = this.dataset.tipo;
            document.getElementById("modalComNombre").innerText = this.dataset.nombre;
            document.getElementById("modalComDesc").innerText = this.dataset.desc;
            document.getElementById("modalComUbicacion").innerText = this.dataset.ubicacion;
            document.getElementById("modalComTelefono").innerText = this.dataset.telefono;
            document.getElementById("modalComCantidad").innerText = this.dataset.cantidad;
            abrirModal("modalComercio");
        });
    });

    // Botones reloj en publicaciones
    document.querySelectorAll(".btn-ver-pub").forEach(function (btn) {
        btn.addEventListener("click", function () {
            document.getElementById("modalPubEmoji").innerText = this.dataset.emoji;
            document.getElementById("modalPubTitulo").innerText = this.dataset.titulo;
            document.getElementById("modalPubComercio").innerText = "📍 " + this.dataset.comercio;
            document.getElementById("modalPubDesc").innerText = this.dataset.desc;
            document.getElementById("modalPubCantidad").innerText = this.dataset.cantidad + " unidades";
            document.getElementById("modalPubHora").innerText = this.dataset.hora;
            var estadoPill = document.getElementById("modalPubEstado");
            estadoPill.innerText = this.dataset.estado;
            estadoPill.className = "status-pill " + (this.dataset.estado === "Disponible" ? "status-disponible" : "status-reservado");
            abrirModal("modalPub");
        });
    });

    // Click fuera cierra modal
    document.querySelectorAll(".fs-modal-overlay").forEach(function (overlay) {
        overlay.addEventListener("click", function (e) {
            if (e.target === overlay) overlay.classList.remove("active");
        });
    });
});

function abrirModalONG(titulo, desc, emoji, detalle) {
    document.getElementById("modalONGTitulo").innerText = titulo;
    document.getElementById("modalONGDesc").innerText = desc;
    document.getElementById("modalONGEmoji").innerText = emoji;
    document.getElementById("modalONGDetalle").innerText = detalle;
    abrirModal("modalONG");
}

function abrirModal(id) { document.getElementById(id).classList.add("active"); }
function cerrarModal(id) { document.getElementById(id).classList.remove("active"); }
</script>

</body>
</html>
