<?php
// views/restaurante/inicio-comercio.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Inicio Comercio</title>
</head>
<body>

<?php include '../../includes/headerong.php'; ?>

<!-- HERO SECCIÓN (Estilo Genesis) -->
<section class="hero-fullscreen">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h1 class="hero-title-new mb-3">
                    BIENVENIDO AL PANEL DE <span>COMERCIO</span><br>
                    PUBLICÁ TUS EXCEDENTES Y AYUDA
                </h1>
                <p class="hero-subtitle-new">
                    Tus donaciones hacen la diferencia. Administra tus publicaciones, revisa el impacto social y conoce las organizaciones registradas.
                </p>
                <button class="btn-hero-cta mt-3" id="btnNuevaPub">Publicar Excedente <i class="fas fa-plus ms-2"></i></button>
            </div>
        </div>
    </div>
</section>

<main class="container mb-5">
    
    <!-- TARJETAS DE INFORMACIÓN (Estilo Genesis Elegant Cards) -->
    <div class="row features-grid mb-5">
        <!-- Card 1 -->
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='/DSS404-TEORICO/views/restaurante/estadisticas.php'">
                <div class="card-icon-elegant">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h4>Estadística de Donaciones</h4>
                <p>Revisa las donaciones que has realizado mensualmente de forma gráfica.</p>
                <a href="/DSS404-TEORICO/views/restaurante/estadisticas.php" class="btn-elegant">Ver Donaciones</a>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='/DSS404-TEORICO/views/restaurante/impacto-social.php'">
                <div class="card-icon-elegant">
                    <i class="fas fa-hands-holding-circle"></i>
                </div>
                <h4>Impacto Social</h4>
                <p>Historias de cambios que se han logrado con los aportes de las donaciones.</p>
                <a href="/DSS404-TEORICO/views/restaurante/impacto-social.php" class="btn-elegant">Ver Impacto</a>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='/DSS404-TEORICO/views/restaurante/organizaciones.php'">
                <div class="card-icon-elegant">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h4>Organizaciones Sociales</h4>
                <p>Conoce las organizaciones registradas que pueden recoger tus excedentes.</p>
                <a href="/DSS404-TEORICO/views/restaurante/organizaciones.php" class="btn-elegant">Ver Organizaciones</a>
            </div>
        </div>
    </div>

    <!-- MIS PUBLICACIONES (Estilo Genesis List) -->
    <div class="publications-section">
        <div class="section-header">
            <h3><i class="fas fa-newspaper me-2"></i> Mis Publicaciones Recientes</h3>
            <a href="/DSS404-TEORICO/views/restaurante/mis-excedentes.php" class="btn-new">Ver más ></a>
        </div>
        
        <div id="publicationsGridHome">
            <!-- Item 1 -->
            <div class="publication-item fs-pub-card">
                <div class="pub-category-icon"><i class="fas fa-utensils"></i></div>
                <div class="pub-content">
                    <div class="pub-title">Platos Preparados <span class="badge bg-success ms-2">12 unidades</span></div>
                    <div class="pub-description">Platos de guisado de carne, arroz, ensalada y una tortilla.</div>
                    <div class="pub-meta">
                        <i class="far fa-clock"></i> Recoger antes de 19:45 p.m.
                    </div>
                </div>
                <button class="pub-request-btn fs-pub-btn">
                    Editar / Renovar <i class="fas fa-pencil-alt ms-1"></i>
                </button>
            </div>
            
            <!-- Item 2 -->
            <div class="publication-item fs-pub-card">
                <div class="pub-category-icon"><i class="fas fa-carrot"></i></div>
                <div class="pub-content">
                    <div class="pub-title">Frutas y Verduras <span class="badge bg-success ms-2">1 caja</span></div>
                    <div class="pub-description">Caja de manzanas, uvas, guineos y zanahorias próximas a caducar.</div>
                    <div class="pub-meta">
                        <i class="far fa-clock"></i> Recoger antes de 19:45 p.m.
                    </div>
                </div>
                <button class="pub-request-btn fs-pub-btn">
                    Editar / Renovar <i class="fas fa-pencil-alt ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</main>

<?php include '../../includes/footer.php'; ?>

<!-- MODAL NUEVA PUBLICACION (Mantenido funcional pero estilizado) -->
<div class="fs-modal-overlay" id="modalNuevaPub">
    <div class="fs-modal-content">
        <button class="fs-modal-close" id="btnCloseModal">&times;</button>
        <h3 style="color: var(--fs-green-main, #1ba154); margin-bottom: 20px;">Nueva Publicación</h3>
        
        <form>
            <div class="mb-3">
                <label class="form-label text-muted">¿Qué excedente tienes?</label>
                <select class="form-select">
                    <option disabled selected>Selecciona una categoría</option>
                    <option value="1">Platos Preparados</option>
                    <option value="2">Frutas y Verduras</option>
                    <option value="3">Panadería y Repostería</option>
                    <option value="4">Lácteos y Embutidos</option>
                    <option value="5">Carnes</option>
                    <option value="6">Bebidas y Jugos</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">Descripción</label>
                <textarea class="form-control" rows="3" placeholder="Ej: Platos de guisado de carne..."></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label text-muted">Cantidad</label>
                    <input type="number" class="form-control" placeholder="0">
                </div>
                <div class="col-6">
                    <label class="form-label text-muted">Recoger antes de</label>
                    <input type="time" class="form-control" placeholder="--:--">
                </div>
            </div>
            
            <button type="submit" class="btn-fs-modal-submit">Publicar Excedente</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var btnOpen = document.getElementById("btnNuevaPub");
        var btnClose = document.getElementById("btnCloseModal");
        var modal = document.getElementById("modalNuevaPub");
        var form = modal.querySelector("form");
        var selectCategoria = modal.querySelector("select");

        // Abrir modal
        btnOpen.addEventListener("click", function(e) {
            e.preventDefault();
            modal.classList.add("active");
        });

        // Cerrar modal
        btnClose.addEventListener("click", function() {
            modal.classList.remove("active");
        });

        modal.addEventListener("click", function(e) {
            if (e.target === modal) modal.classList.remove("active");
        });

        // Lógica de formulario - Simulación visual
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            var grid = document.getElementById("publicationsGridHome");
            var selectCat = form.querySelector("select").options[form.querySelector("select").selectedIndex].text;
            var desc = form.querySelector("textarea").value;
            var time = form.querySelector('input[type="time"]').value || "00:00";
            var qty = form.querySelector('input[type="number"]').value || "1";

            var newCard = document.createElement("div");
            newCard.className = "publication-item fs-pub-card";
            newCard.innerHTML = `
                <div class="pub-category-icon"><i class="fas fa-check-circle"></i></div>
                <div class="pub-content">
                    <div class="pub-title">${selectCat} <span class="badge bg-success ms-2">${qty} unidades</span></div>
                    <div class="pub-description">${desc}</div>
                    <div class="pub-meta">
                        <i class="far fa-clock"></i> Recoger antes de ${time} p.m.
                    </div>
                </div>
                <button class="pub-request-btn fs-pub-btn">
                    Editar / Renovar <i class="fas fa-pencil-alt ms-1"></i>
                </button>
            `;
            grid.insertBefore(newCard, grid.firstChild);

            alert("¡Excedente publicado con éxito!");
            form.reset();
            modal.classList.remove("active");
        });

        // Parámetro URL de publicación
        const urlParams = new URLSearchParams(window.location.search);
        const openModalCat = urlParams.get('openModal');
        if (openModalCat) {
            selectCategoria.value = openModalCat;
            modal.classList.add("active");
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        // Interacción de botones editar
        document.addEventListener('click', function(e) {
            if(e.target.closest('.fs-pub-btn')) {
                alert("Abriendo opciones de renovación/edición para esta publicación...");
                modal.classList.add("active");
            }
        });
    });
</script>

</body>
</html>
