<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/DSS404-TEORICO/resources/css/style.css">
    <link rel="stylesheet" href="reservados-style.css"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Alimentos Reservados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<div class="page-container">
    <?php include '../../includes/headerong.php'; ?>

    <main class="main-content container mt-5">
        <div class="section-header-main mb-4">
            <h2 class="title-page">Mis Reservas Actuales</h2>
            <p class="text-muted">Gestión de alimentos solicitados agrupados por tipo.</p>
        </div>
        <div id="reservedCategoriesContainer"></div>
    </main>

    <?php include '../../includes/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Datos de ejemplo con categorías
    const reservas = [
        { id: 1, categoria: "Platos Preparados", titulo: "Guisado de Carne", descripcion: "Platos con arroz, ensalada y tortilla.", comercio: "Comedor Esperanza", hora: "19:45 p.m.", icono: "fa-utensils", cantidad: 12 },
        { id: 2, categoria: "Platos Preparados", titulo: "Sopa de Pollo", descripcion: "Porciones familiares de sopa fresca.", comercio: "Restaurante El Sol", hora: "20:00 p.m.", icono: "fa-utensils", cantidad: 5 },
        { id: 3, categoria: "Frutas y Verduras", titulo: "Caja Mixta", descripcion: "Manzanas, guineos y zanahorias.", comercio: "Supermercado Don Pepe", hora: "19:45 p.m.", icono: "fa-apple-alt", cantidad: 1 },
        { id: 4, categoria: "Panadería y Repostería", titulo: "Pan Variado", descripcion: "Bolsas de pan dulce y francés.", comercio: "Panadería La Vega", hora: "18:30 p.m.", icono: "fa-bread-slice", cantidad: 10 }
    ];

    function renderReservados() {
        const container = document.getElementById('reservedCategoriesContainer');
        if (!container) return;

        // 1. Agrupar reservas por categoría
        const grupos = reservas.reduce((acc, item) => {
            if (!acc[item.categoria]) acc[item.categoria] = [];
            acc[item.categoria].push(item);
            return acc;
        }, {});

        // 2. Generar el HTML
        let html = '';
        for (const categoria in grupos) {
            html += `
                <div class="category-block mb-5">
                    <h3 class="category-title">${categoria}</h3>
                    <div class="category-divider"></div>
                    <div class="reserved-list">
                        ${grupos[categoria].map(res => `
                            <div class="publication-item reserved-item">
                                <div class="pub-category-icon is-reserved"><i class="fas ${res.icono}"></i></div>
                                <div class="pub-content">
                                    <div class="d-flex align-items-center">
                                        <div class="pub-title">${res.titulo}</div>
                                        <span class="badge-qty-reserved ms-2">${res.cantidad}</span>
                                    </div>
                                    <div class="pub-description">${res.descripcion}</div>
                                    <div class="pub-meta">
                                        <i class="fas fa-store"></i> ${res.comercio} &nbsp;|&nbsp;
                                        <i class="far fa-clock"></i> Recoger a las: ${res.hora}
                                    </div>
                                </div>
                                <div class="reserved-status">
                                    <span class="status-label">En Espera</span>
                                    <div class="status-dot"></div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        container.innerHTML = html;
    }

    renderReservados();
</script>
</body>
</html>