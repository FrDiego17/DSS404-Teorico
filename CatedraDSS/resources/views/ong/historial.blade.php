@extends('layouts.ong')

@section('title', 'Historial de Donaciones')

@section('content')

<main class="main-content container mt-4">

    {{-- BARRA DE BÚSQUEDA --}}
    <div class="search-container-historial mb-5">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Buscar en el historial..." id="searchInput" oninput="filtrarHistorial()">
        </div>
    </div>

    {{-- Contenedor dinámico --}}
    <div id="historyTimeline">
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x text-success"></i>
            <p class="mt-2 text-muted">Cargando historial...</p>
        </div>
    </div>

</main>

@endsection

@push('scripts')
<script>
    let historialData = [];

    const iconosPorCategoria = {
        'Platos Preparados': 'fa-utensils',
        'Panadería y Repostería': 'fa-bread-slice',
        'Frutas y Verduras': 'fa-apple-alt',
        'Lácteos y Embutidos': 'fa-cheese',
        'Carnes': 'fa-drumstick-bite',
        default: 'fa-box-open'
    };

    function getIcono(cat) { return iconosPorCategoria[cat] || iconosPorCategoria.default; }

    async function cargarHistorial() {
        try {
            const res = await fetch('{{ route("ong.donaciones.historial") }}');
            historialData = await res.json();
            renderHistorial(historialData);
        } catch (e) {
            document.getElementById('historyTimeline').innerHTML =
                '<div class="alert alert-warning">No se pudo cargar el historial.</div>';
        }
    }

    function filtrarHistorial() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        const filtrado = historialData.filter(d =>
            d.titulo.toLowerCase().includes(q) ||
            (d.descripcion ?? '').toLowerCase().includes(q)
        );
        renderHistorial(filtrado);
    }

    function renderHistorial(donaciones) {
        const container = document.getElementById('historyTimeline');

        if (!donaciones.length) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay registros en el historial.</p>
                </div>`;
            return;
        }

        // Agrupa por período
        const grupos = {};
        donaciones.forEach(don => {
            const fecha = new Date(don.updated_at);
            const hoy = new Date();
            const diff = Math.floor((hoy - fecha) / (1000 * 60 * 60 * 24));
            let periodo = diff === 0 ? 'Hoy' : diff <= 7 ? 'Esta Semana' : diff <= 30 ? 'Este Mes' : 'Anteriores';
            if (!grupos[periodo]) grupos[periodo] = [];
            grupos[periodo].push(don);
        });

        let html = '';
        for (const [periodo, items] of Object.entries(grupos)) {
            html += `<div class="history-section mb-5">
                <h3 class="timeline-title">${periodo}</h3>
                <div class="timeline-line"></div>
                <div class="history-list">`;
            items.forEach(item => {
                const estado = item.reserva_estado === 'completada' ? 'completado' : item.reserva_estado;
                const icono = getIcono(item.categoria?.nombre);
                const fecha = new Date(item.updated_at).toLocaleDateString('es-SV');
                html += `
                    <div class="publication-item history-item ${estado}">
                        <div class="pub-category-icon historial-icon"><i class="fas ${icono}"></i></div>
                        <div class="pub-content">
                            <div class="d-flex align-items-center">
                                <div class="pub-title">${item.titulo}</div>
                            </div>
                            <div class="pub-description">${item.descripcion ?? ''}</div>
                            ${item.reserva_notas ? `<div style="font-size:12px; font-weight:600; color:#2b6cb0; margin-top:4px;"><i class="fas fa-info-circle me-1"></i> ${item.reserva_notas}</div>` : ''}
                        </div>
                        <div class="historial-status-badge">
                            <span class="date-text">${fecha}</span>
                            <div class="status-circle ${estado}">
                                <i class="fas ${estado === 'completado' ? 'fa-check' : 'fa-times'}"></i>
                            </div>
                        </div>
                    </div>`;
            });
            html += `</div></div>`;
        }
        container.innerHTML = html;
    }

    cargarHistorial();
</script>
@endpush
