@extends('layouts.ong')

@section('title', 'Alimentos Reservados')

@section('content')

<main class="main-content container mt-5">
    <div class="section-header-main mb-4">
        <h2 class="title-page">Mis Reservas Actuales</h2>
        <p class="text-muted">Gestión de alimentos solicitados agrupados por tipo.</p>
    </div>
    <div id="reservedCategoriesContainer">
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x text-success"></i>
            <p class="mt-2 text-muted">Cargando reservas...</p>
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
    const iconosPorCategoria = {
        'Platos Preparados': 'fa-utensils',
        'Panadería y Repostería': 'fa-bread-slice',
        'Frutas y Verduras': 'fa-apple-alt',
        'Lácteos y Embutidos': 'fa-cheese',
        'Carnes': 'fa-drumstick-bite',
        default: 'fa-box-open'
    };

    function getIcono(cat) { return iconosPorCategoria[cat] || iconosPorCategoria.default; }

    async function cargarReservados() {
        const container = document.getElementById('reservedCategoriesContainer');
        try {
            const res = await fetch('{{ route("ong.donaciones.reservados") }}');
            const reservas = await res.json();

            if (!reservas.length) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No tienes reservas activas en este momento.</p>
                    </div>`;
                return;
            }

            // Agrupa por categoría
            const grupos = reservas.reduce((acc, item) => {
                const cat = item.categoria?.nombre ?? 'Sin categoría';
                if (!acc[cat]) acc[cat] = [];
                acc[cat].push(item);
                return acc;
            }, {});

            let html = '';
            for (const [categoria, items] of Object.entries(grupos)) {
                html += `<div class="category-block mb-5">
                    <h3 class="category-title">${categoria}</h3>
                    <div class="category-divider"></div>
                    <div class="reserved-list">`;
                items.forEach(res => {
                    const icono = getIcono(categoria);
                    const hora = new Date(res.fecha_limite).toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit' });
                    html += `
                        <div class="publication-item reserved-item">
                            <div class="pub-category-icon is-reserved"><i class="fas ${icono}"></i></div>
                            <div class="pub-content">
                                <div class="d-flex align-items-center">
                                    <div class="pub-title">${res.titulo}</div>
                                    <span class="badge-qty-reserved ms-2">${res.cantidad}</span>
                                </div>
                                <div class="pub-description">${res.descripcion ?? ''}</div>
                                <div class="pub-meta">
                                    <i class="fas fa-store"></i> ${res.comercio?.nombre_comercial ?? 'Comercio'} &nbsp;|&nbsp;
                                    <i class="far fa-clock"></i> Recoger a las: ${hora}
                                </div>
                            </div>
                            <div class="reserved-status">
                                <span class="status-label">En Espera</span>
                                <div class="status-dot"></div>
                            </div>
                        </div>`;
                });
                html += `</div></div>`;
            }
            container.innerHTML = html;

        } catch (e) {
            container.innerHTML = '<div class="alert alert-warning">No se pudieron cargar las reservas.</div>';
        }
    }

    cargarReservados();
</script>
@endpush
