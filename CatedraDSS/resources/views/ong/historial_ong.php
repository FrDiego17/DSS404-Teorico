<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/DSS404-TEORICO/resources/css/style.css">
    <link rel="stylesheet" href="historial-style.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Historial de Donaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<div class="page-container">
    <?php include '../../includes/headerong.php'; ?>

    <main class="main-content container mt-4">
        <!-- BARRA DE BÚSQUEDA -->
        <div class="search-container-historial mb-5">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar en el historial..." id="searchInput">
            </div>
        </div>

        <!-- Contenedor Dinámico de Historial -->
        <div id="historyTimeline"></div>
    </main>

    <?php include '../../includes/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Datos de historial agrupados por tiempo
    const historial = [
        { 
            periodo: "Esta Semana", 
            items: [
                { id: 101, titulo: "Platos Preparados", desc: "Platos de guisado de carne y arroz.", qty: 12, estado: "completado", icono: "fa-utensils", fecha: "Hoy" },
                { id: 102, titulo: "Platos Preparados", desc: "Picado de verdura y casamiento.", qty: 6, estado: "completado", icono: "fa-utensils", fecha: "Ayer" }
            ]
        },
        { 
            periodo: "El mes pasado", 
            items: [
                { id: 103, titulo: "Frutas y Verduras", desc: "Caja de manzanas y zanahorias.", qty: 1, estado: "completado", icono: "fa-apple-alt", fecha: "15 Abr" },
                { id: 104, titulo: "Lacteos y Embutidos", desc: "Cajas de leche de 4 unidades.", qty: 11, estado: "cancelado", icono: "fa-cheese", fecha: "10 Abr", nota: "No llegó nadie a recogerlo" }
            ]
        },
        { 
            periodo: "Anteriores", 
            items: [
                { id: 105, titulo: "Panadería y Repostería", desc: "Pan empaquetado variado.", qty: 8, estado: "completado", icono: "fa-bread-slice", fecha: "20 Mar" },
                { id: 106, titulo: "Carnes", desc: "Bandejas de carnes mixtas.", qty: 8, estado: "completado", icono: "fa-drumstick-bite", fecha: "15 Mar" }
            ]
        }
    ];

    function renderHistorial() {
        const container = document.getElementById('historyTimeline');
        let html = '';

        historial.forEach(seccion => {
            html += `
                <div class="history-section mb-5">
                    <h3 class="timeline-title">${seccion.periodo}</h3>
                    <div class="timeline-line"></div>
                    <div class="history-list">
                        ${seccion.items.map(item => `
                            <div class="publication-item history-item ${item.estado}">
                                <div class="pub-category-icon historial-icon">
                                    <i class="fas ${item.icono}"></i>
                                </div>
                                <div class="pub-content">
                                    <div class="d-flex align-items-center">
                                        <div class="pub-title">${item.titulo}</div>
                                        <span class="historial-qty">x${item.qty}</span>
                                    </div>
                                    <div class="pub-description">${item.desc}</div>
                                    ${item.nota ? `<div class="cancel-note"><i class="fas fa-info-circle me-1"></i> ${item.nota}</div>` : ''}
                                </div>
                                <div class="historial-status-badge">
                                    <span class="date-text">${item.fecha}</span>
                                    <div class="status-circle ${item.estado}">
                                        <i class="fas ${item.estado === 'completado' ? 'fa-check' : 'fa-times'}"></i>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        });
        container.innerHTML = html;
    }

    renderHistorial();
</script>
</body>
</html>