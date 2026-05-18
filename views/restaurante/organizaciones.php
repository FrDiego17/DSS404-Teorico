<?php
// views/restaurante/organizaciones.php
$organizaciones = [
    [
        'titulo' => 'Dona tu comida',
        'descripcion' => 'Transformamos el excedente de alimentos en oportunidades de nutrición.',
        'cantidad' => 12,
        'icono' => 'fa-seedling',
        'color' => '#8bc34a'
    ],
    [
        'titulo' => 'Banco de Alimentos El Salvador',
        'descripcion' => 'Trabajamos para minimizar el hambre y malnutrición en El Salvador.',
        'cantidad' => 6,
        'icono' => 'fa-wheat-awn',
        'color' => '#f0ad4e'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Organizaciones</title>
</head>
<body style="background-color: #f9fbf9;">

<?php include '../../includes/headerong.php'; ?>

<main class="container" style="padding-top: 50px; min-height: 80vh;">
    
    <h2 class="hero-title-new mb-2 text-center" style="font-size: 2.5rem; color: #1a3a2a;">
        Organizaciones <span>Sociales</span>
    </h2>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <input type="text" class="fs-search-input" id="searchOrgs" placeholder="Buscar Organizaciones...">
        </div>
    </div>

    <div class="row features-grid">
        <?php foreach ($organizaciones as $org): ?>
            <div class="col-md-4 mb-4 org-card">
                <div class="elegant-card">
                    <div class="card-icon-elegant" style="color: <?php echo $org['color']; ?>;">
                        <i class="fas <?php echo $org['icono']; ?> org-icon"></i>
                    </div>
                    <h4 class="org-title"><?php echo htmlspecialchars($org['titulo']); ?></h4>
                    <p class="org-desc"><?php echo htmlspecialchars($org['descripcion']); ?></p>
                    <button class="btn-elegant w-100 btn-ver-org">Ver más &rarr;</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>

<!-- MODAL ONG -->
<div class="fs-modal-overlay" id="modalOrg">
    <div class="fs-org-modal-content">
        <button class="fs-modal-close" id="btnCloseOrg">&times;</button>
        <div class="fs-org-logo-large">
            <i class="fas fa-wheat-awn" id="modalOrgIcon"></i>
        </div>
        <h3 class="fs-org-title" id="modalOrgTitle">Banco de Alimentos</h3>
        <div class="fs-rating">
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
        </div>
        <p class="fs-org-desc" id="modalOrgDesc">Descripción de la organización.</p>
        <button class="btn-fs-modal-submit" id="btnCerrarOrgBtn">Cerrar</button>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var modalOrg = document.getElementById("modalOrg");
    var btnCloseOrg = document.getElementById("btnCloseOrg");
    var btnCerrarOrgBtn = document.getElementById("btnCerrarOrgBtn");
    
    var modalIcon = document.getElementById("modalOrgIcon");
    var modalTitle = document.getElementById("modalOrgTitle");
    var modalDesc = document.getElementById("modalOrgDesc");

    document.querySelectorAll(".btn-ver-org").forEach(function(btn) {
        btn.addEventListener("click", function(e) {
            e.preventDefault();
            var card = this.closest(".org-card");
            modalTitle.innerText = card.querySelector(".org-title").innerText;
            modalDesc.innerText = card.querySelector(".org-desc").innerText;
            var iconEl = card.querySelector(".org-icon");
            modalIcon.className = iconEl.className;
            modalIcon.style.color = iconEl.parentElement.style.color || "#f0ad4e";

            modalOrg.classList.add("active");
        });
    });

    var closeModal = () => modalOrg.classList.remove("active");
    btnCloseOrg.addEventListener("click", closeModal);
    btnCerrarOrgBtn.addEventListener("click", closeModal);
    modalOrg.addEventListener("click", e => { if (e.target === modalOrg) closeModal(); });

    var searchInput = document.getElementById("searchOrgs");
    searchInput.addEventListener("keyup", function() {
        var filter = searchInput.value.toLowerCase();
        document.querySelectorAll(".org-card").forEach(function(card) {
            var text = card.innerText.toLowerCase();
            card.style.display = text.includes(filter) ? "" : "none";
        });
    });
});
</script>

</body>
</html>
