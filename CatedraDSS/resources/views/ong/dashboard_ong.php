<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/DSS404-TEORICO/resources/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Dashboard ONG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<?php include '../../includes/headerong.php'; ?>

<!-- SECCIÓN HERO -->
<section class="hero-fullscreen">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h1 class="hero-title-new mb-3">
                    BIENVENIDO <span><?php echo isset($nombre_organizacion) ? $nombre_organizacion : 'Fundación Banco de Alimentos'; ?></span><br>
                    ¡HAY ALIMENTOS ESPERANDO SER DONADOS!
                </h1>
                <p class="hero-subtitle-new">
                    Las donaciones que realizas no solo transforman a la comunidad más necesitada, 
                    también reducen excedentes y minimizan desperdicios.
                </p>
            </div>
        </div>
    </div>
</section>

<main class="container">
    <div class="publications-section">
        <div class="section-header">
            <h3><i class="fas fa-newspaper me-2"></i> Publicaciones</h3>
            
        </div>
        <div id="publicationsList"></div>
    </div>
</main>

<!-- VENTANA EMERGENTE -->
<div id="modalReserva" class="fs-modal-overlay">
    <div class="fs-modal-content">
        <button class="fs-modal-close" onclick="cerrarModal()">&times;</button>
        
        <div class="fs-modal-header-img">
            <div id="modalIconContainer">
                <i class="fas fa-box-open"></i>
            </div>
        </div>

        <div class="fs-modal-body">
            <div class="d-flex justify-content-between align-items-start">
                <h4 id="modalTitle">Título del Alimento</h4>
                <span class="fs-badge-qty" id="modalQty">12</span>
            </div>
            
            <p class="fs-modal-desc" id="modalDesc">Descripción detallada del producto.</p>
            
            <div class="fs-modal-info">
                <p class="info-comercio" id="modalComercio">Nombre del Comercio</p>
                <p class="info-address">Local #16, Avenida Don Bosco, Soyapango, San Salvador</p>
                <p class="info-ref">Referencia: Punto de entrega central</p>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="info-time" id="modalTime">19:45 p.m.</span>
                    <div class="status-icon"><i class="fas fa-stopwatch"></i></div>
                </div>
            </div>

            <div class="mt-3">
                <select class="form-select fs-select-voluntario">
                    <option selected disabled>Seleccionar Voluntario</option>
                    <option value="1">Juan Pérez</option>
                    <option value="2">María López</option>
                    <option value="3">Carlos Ruíz</option>
                </select>
            </div>

            <button class="btn-fs-reservar" onclick="confirmarReserva()">Reservar</button>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const publicaciones = [
        { titulo: "Platos Preparados", descripcion: "Platos de guisado de carne, arroz, ensalada y una tortilla.", comercio: "Comedor Esperanza", hora: "19:45 p.m.", icono: "fa-utensils" },
        { titulo: "Panadería y Repostería", descripcion: "Pan empaquetado próximo a caducar.", comercio: "Panadería La Vega", hora: "18:30 p.m.", icono: "fa-bread-slice" },
        { titulo: "Frutas y Verduras", descripcion: "Caja de manzanas, uvas, guineos y zanahorias próximas a caducar.", comercio: "Supermercado Don Pepe", hora: "19:45 p.m.", icono: "fa-apple-alt" },
        { titulo: "Lacteos y Embutidos", descripcion: "Paquetes de salchichas y jamón próximos a caducar.", comercio: "Comedor Don Bosco", hora: "19:45 p.m.", icono: "fa-cheese" }
    ];

    function renderPublicaciones() {
        const container = document.getElementById('publicationsList');
        if (!container) return;
        
        let html = '';
        publicaciones.forEach((pub, index) => {
            html += `
                <div class="publication-item">
                    <div class="pub-category-icon"><i class="fas ${pub.icono}"></i></div>
                    <div class="pub-content">
                        <div class="pub-title">${pub.titulo}</div>
                        <div class="pub-description">${pub.descripcion}</div>
                        <div class="pub-meta">
                            <i class="fas fa-store"></i> ${pub.comercio} &nbsp;|&nbsp;
                            <i class="far fa-clock"></i> ${pub.hora}
                        </div>
                    </div>
                    <button class="pub-request-btn" onclick="abrirModal(${index})">
                        Solicitar <i class="fas fa-hand-holding-heart ms-1"></i>
                    </button>
                </div>`;
        });
        container.innerHTML = html;
    }

    // LÓGICA DEL MODAL
    function abrirModal(index) {
        const pub = publicaciones[index];
        document.getElementById('modalTitle').innerText = pub.titulo;
        document.getElementById('modalDesc').innerText = pub.descripcion;
        document.getElementById('modalComercio').innerText = pub.comercio;
        document.getElementById('modalTime').innerText = pub.hora;
        document.getElementById('modalIconContainer').innerHTML = `<i class="fas ${pub.icono}"></i>`;
        
        document.getElementById('modalReserva').classList.add('active');
    }

    function cerrarModal() {
        document.getElementById('modalReserva').classList.remove('active');
    }

    function confirmarReserva() {
        alert("Alimento reservado con éxito. El voluntario ha sido notificado.");
        cerrarModal();
    }

    renderPublicaciones();
</script>
</body>
</html>