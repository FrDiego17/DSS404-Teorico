@extends('layouts.ong')

@section('title', 'Alimentos Reservados')

@section('content')

<main class="main-content container mt-5">
    <div class="section-header-main mb-4">
        <h2 class="title-page">Mis Reservas Actuales</h2>
        <p class="text-muted">Asigna un voluntario a cada reserva para que recoja el producto.</p>
    </div>
    <div id="reservedCategoriesContainer">
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x text-success"></i>
            <p class="mt-2 text-muted">Cargando reservas...</p>
        </div>
    </div>
</main>

<div id="toastNotif" style="
    position:fixed; bottom:28px; right:28px; z-index:9999;
    background:#1a2a32; color:#fff; border-radius:12px;
    padding:14px 22px; font-size:14px; font-weight:600;
    box-shadow:0 8px 32px rgba(0,0,0,0.22);
    display:none; align-items:center; gap:10px; min-width:280px;
">
    <i id="toastIcon" class="fas fa-check-circle" style="color:#45b66f; font-size:18px;"></i>
    <span id="toastMsg"></span>
</div>

@endsection

@push('scripts')
<script>
    const csrfToken = '{{ csrf_token() }}';

    const iconosPorCategoria = {
        'Platos Preparados': 'fa-utensils',
        'Panadería y Repostería': 'fa-bread-slice',
        'Frutas y Verduras': 'fa-apple-alt',
        'Lácteos y Embutidos': 'fa-cheese',
        'Carnes': 'fa-drumstick-bite',
        default: 'fa-box-open'
    };

    function getIcono(cat) { return iconosPorCategoria[cat] || iconosPorCategoria.default; }

    // Carga los voluntarios de la ONG para el selector
    let voluntariosCache = [];
    async function cargarVoluntarios() {
        try {
            const res = await fetch('{{ route("ong.api.voluntarios.index") }}');
            voluntariosCache = await res.json();
        } catch(e) { voluntariosCache = []; }
    }

    function buildVoluntarioSelector(reservaId, voluntarioActual) {
        if (!voluntariosCache.length) {
            return `<p class="text-muted" style="font-size:12px;">No hay voluntarios registrados.</p>`;
        }

        const opciones = voluntariosCache.map(v =>
            `<option value="${v.id}" ${voluntarioActual?.id === v.id ? 'selected' : ''}>${v.nombre}</option>`
        ).join('');

        const yaAsignado = voluntarioActual != null;

        return `
            <div class="asignar-voluntario-section mt-3 p-3" style="background:#f7fdf9; border:1px solid #c6f0d6; border-radius:10px;">
                <p style="font-size:12px; font-weight:700; color:#45b66f; margin:0 0 8px 0; text-transform:uppercase; letter-spacing:0.5px;">
                    <i class="fas fa-user-check me-1"></i>Asignar Voluntario
                </p>
                ${yaAsignado ? `
                    <div style="font-size:13px; color:#2d3748; margin-bottom:8px;">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Asignado: <strong>${voluntarioActual.nombre}</strong>
                        <span style="font-size:11px; color:#a0aec0; margin-left:6px;">(código enviado por correo)</span>
                    </div>
                ` : ''}
                <div class="d-flex gap-2">
                    <select id="sel_vol_${reservaId}" class="form-select form-select-sm" style="border-radius:8px; font-size:13px; flex:1;">
                        <option value="" disabled ${!yaAsignado ? 'selected' : ''}>Seleccionar voluntario...</option>
                        ${opciones}
                    </select>
                    <button
                        onclick="asignarVoluntario(${reservaId})"
                        id="btn_asignar_${reservaId}"
                        style="background:#45b66f; color:#fff; border:none; border-radius:8px; padding:6px 14px; font-size:13px; font-weight:700; cursor:pointer; white-space:nowrap; transition:background 0.2s;"
                        onmouseover="this.style.background='#2d8c52'"
                        onmouseout="this.style.background='#45b66f'"
                    >
                        <i class="fas fa-paper-plane me-1"></i>${yaAsignado ? 'Reasignar' : 'Enviar código'}
                    </button>
                </div>
            </div>`;
    }

    async function asignarVoluntario(reservaId) {
        const select = document.getElementById(`sel_vol_${reservaId}`);
        const btn    = document.getElementById(`btn_asignar_${reservaId}`);
        const volId  = select?.value;

        if (!volId) { mostrarToast('Selecciona un voluntario primero.', false); return; }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Enviando...';

        try {
            const res  = await fetch(`{{ url('ong/reservas') }}/${reservaId}/asignar-voluntario`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ voluntario_id: parseInt(volId) })
            });
            const data = await res.json();

            if (res.ok) {
                mostrarToast(`Código enviado a ${data.voluntario} por correo.`, true);
                cargarReservados(); // refresca las tarjetas
            } else {
                mostrarToast(data.message || 'Error al asignar voluntario.', false);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane me-1"></i>Enviar código';
            }
        } catch(e) {
            mostrarToast('Error de conexión.', false);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-paper-plane me-1"></i>Enviar código';
        }
    }

    function mostrarToast(msg, exito = true) {
        const toast = document.getElementById('toastNotif');
        const icon  = document.getElementById('toastIcon');
        const texto = document.getElementById('toastMsg');
        icon.className  = exito ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        icon.style.color = exito ? '#45b66f' : '#e53e3e';
        texto.textContent = msg;
        toast.style.display = 'flex';
        setTimeout(() => { toast.style.display = 'none'; }, 4000);
    }

    async function cargarReservados() {
        const container = document.getElementById('reservedCategoriesContainer');
        try {
            const res    = await fetch('{{ route("ong.donaciones.reservados") }}');
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
                    const hora  = new Date(res.fecha_limite).toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit' });
                    const selectorHtml = buildVoluntarioSelector(res.reserva_id, res.voluntario ?? null);

                    html += `
                        <div class="publication-item reserved-item" style="flex-direction:column; align-items:stretch;">
                            <div style="display:flex; align-items:flex-start; gap:16px;">
                                <div class="pub-category-icon is-reserved"><i class="fas ${icono}"></i></div>
                                <div class="pub-content" style="flex:1;">
                                    <div class="d-flex align-items-center">
                                        <div class="pub-title">${res.titulo}</div>
                                        <span class="badge-qty-reserved ms-2" title="Cantidad restante en el comercio">${res.cantidad} uds disp.</span>
                                    </div>
                                    <div class="pub-description">${res.descripcion ?? ''}</div>
                                    ${res.reserva_notas ? `<div style="font-size:12px; font-weight:600; color:#2b6cb0; margin-top:4px; margin-bottom:8px;"><i class="fas fa-info-circle me-1"></i> ${res.reserva_notas}</div>` : ''}
                                    <div class="pub-meta">
                                        <i class="fas fa-store"></i> ${res.comercio?.nombre_comercial ?? 'Comercio'} &nbsp;|&nbsp;
                                        <i class="far fa-clock"></i> Recoger antes de: ${hora}
                                    </div>
                                </div>
                                <div class="reserved-status">
                                    <span class="status-label">Reservado</span>
                                    <div class="status-dot"></div>
                                </div>
                            </div>
                            ${selectorHtml}
                        </div>`;
                });

                html += `</div></div>`;
            }
            container.innerHTML = html;

        } catch (e) {
            container.innerHTML = '<div class="alert alert-warning">No se pudieron cargar las reservas.</div>';
        }
    }

    document.addEventListener('DOMContentLoaded', async () => {
        await cargarVoluntarios();
        cargarReservados();
    });
</script>
@endpush
