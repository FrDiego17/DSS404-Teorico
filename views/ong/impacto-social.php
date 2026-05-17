<?php
// views/ong/impacto-social.php
$domingo_savio = [
    [
        'titulo' => 'Programa de rescate',
        'descripcion' => 'El restaurante organiza o participa en jornadas donde se preparan comidas gratuitas.',
        'icono' => 'fa-utensils'
    ],
    [
        'titulo' => 'Comedores comunitarios',
        'descripcion' => 'Apoyamos comedores comunitarios que brindan comidas nutritivas a niños, adultos mayores y familias de escasos recursos.',
        'icono' => 'fa-utensils'
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Impacto Social</title>
</head>
<body style="background-color: #f9fbf9;">

<?php include '../../includes/headerong.php'; ?>

<main class="container" style="padding-top: 50px; min-height: 80vh;">
    
    <h2 class="hero-title-new mb-2 text-center" style="font-size: 2.5rem; color: #1a3a2a;">
        Impacto <span>Social</span>
    </h2>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <input type="text" class="fs-search-input" id="searchImpacto" placeholder="Buscar impacto social...">
        </div>
    </div>

    <div class="publications-section mb-5" id="impactoContainer">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h3>Restaurante Domingo Savio</h3>
            <button class="btn-new" id="btnAddImpacto">Agregar <i class="fas fa-plus ms-1"></i></button>
        </div>
        
        <div class="fs-pubs-grid">
            <?php foreach ($domingo_savio as $item): ?>
                <div class="publication-item impact-card">
                    <div class="pub-category-icon"><i class="fas <?php echo $item['icono']; ?>"></i></div>
                    <div class="pub-content">
                        <div class="pub-title search-title"><?php echo htmlspecialchars($item['titulo']); ?></div>
                        <div class="pub-description search-desc"><?php echo htmlspecialchars($item['descripcion']); ?></div>
                    </div>
                    <div class="d-flex ms-3">
                        <button class="action-btn-custom edit" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                        <button class="action-btn-custom delete" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>

<!-- MODAL AGREGAR IMPACTO -->
<div class="fs-modal-overlay" id="modalAddImpacto">
    <div class="fs-modal-content">
        <button class="fs-modal-close" id="btnCloseAddImpacto">&times;</button>
        <h3 style="color: var(--fs-green-main, #1ba154); margin-bottom: 20px;">Agregar Impacto Social</h3>
        <form id="formAddImpacto">
            <div class="mb-3">
                <label class="form-label text-muted">Título del Programa</label>
                <input type="text" class="form-control" required placeholder="Ej: Jornada de Reciclaje">
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">Descripción</label>
                <textarea class="form-control" required placeholder="Describe el impacto..."></textarea>
            </div>
            <button type="submit" class="btn-fs-modal-submit">Guardar</button>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var modalAdd = document.getElementById("modalAddImpacto");
    var btnAdd = document.getElementById("btnAddImpacto");
    var btnCloseAdd = document.getElementById("btnCloseAddImpacto");
    var formAdd = document.getElementById("formAddImpacto");

    btnAdd.addEventListener("click", function() { modalAdd.classList.add("active"); });
    btnCloseAdd.addEventListener("click", function() { modalAdd.classList.remove("active"); });
    modalAdd.addEventListener("click", function(e) { if (e.target === modalAdd) modalAdd.classList.remove("active"); });

    formAdd.addEventListener("submit", function(e) {
        e.preventDefault();
        var title = formAdd.querySelector('input[type="text"]').value;
        var desc = formAdd.querySelector('textarea').value;
        var container = document.getElementById("impactoContainer").querySelector(".fs-pubs-grid");

        var newCard = document.createElement("div");
        newCard.className = "publication-item impact-card";
        newCard.innerHTML = `
            <div class="pub-category-icon"><i class="fas fa-hand-holding-heart"></i></div>
            <div class="pub-content">
                <div class="pub-title search-title">${title}</div>
                <div class="pub-description search-desc">${desc}</div>
            </div>
            <div class="d-flex ms-3">
                <button class="action-btn-custom edit" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="action-btn-custom delete" title="Eliminar"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
        
        newCard.querySelector('.delete').addEventListener("click", function() {
            if(confirm("¿Estás seguro de que deseas eliminar este impacto social?")) {
                newCard.style.display = 'none';
            }
        });

        container.insertBefore(newCard, container.firstChild);
        alert("¡Impacto social guardado con éxito!");
        formAdd.reset();
        modalAdd.classList.remove("active");
    });

    document.querySelectorAll('.action-btn-custom.delete').forEach(btn => {
        btn.addEventListener("click", function() {
            if(confirm("¿Estás seguro de que deseas eliminar este impacto social?")) {
                this.closest('.publication-item').style.display = 'none';
            }
        });
    });

    var searchInput = document.getElementById("searchImpacto");
    searchInput.addEventListener("keyup", function() {
        var filter = searchInput.value.toLowerCase();
        var cards = document.querySelectorAll(".impact-card");
        cards.forEach(function(card) {
            var title = card.querySelector(".search-title").innerText.toLowerCase();
            var desc = card.querySelector(".search-desc").innerText.toLowerCase();
            card.style.display = (title.includes(filter) || desc.includes(filter)) ? "" : "none";
        });
    });
});
</script>

</body>
</html>
