@extends('layouts.ong')

@section('title', 'Dashboard ONG')

@section('content')

<section class="hero-fullscreen" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('{{ asset('resources/img/index.png') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h1 class="hero-title-new mb-3">
                    BIENVENIDO <span>{{ Auth::user()->name }}</span><br>
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
            <h3><i class="fas fa-newspaper me-2"></i> Publicaciones Disponibles</h3>
        </div>
        <div id="publicationsList">
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-success"></i>
                <p class="mt-2 text-muted">Cargando publicaciones...</p>
            </div>
        </div>
    </div>
</main>

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
                <span class="fs-badge-qty" id="modalQty">0</span>
            </div>
            <p class="fs-modal-desc" id="modalDesc">Descripción detallada del producto.</p>

            <div class="fs-modal-info">
                <p class="info-comercio" id="modalComercio">Nombre del Comercio</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="info-time" id="modalTime"></span>
                    <div class="status-icon"><i class="fas fa-stopwatch"></i></div>
                </div>
            </div>

            <button class="btn-fs-reservar" onclick="confirmarReserva()">
                Reservar <i class="fas fa-hand-holding-heart ms-1"></i>
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let donacionActual = null;

    // Lista de íconos por categoría
    const iconosPorCategoria = {
        'Platos Preparados': 'fa-utensils',
        'Panadería y Repostería': 'fa-bread-slice',
        'Frutas y Verduras': 'fa-apple-alt',
        'Lácteos y Embutidos': 'fa-cheese',
        'Carnes': 'fa-drumstick-bite',
        'Bebidas': 'fa-wine-bottle',
        'default': 'fa-box-open'
    };

    function getIcono(nombreCategoria) {
        return iconosPorCategoria[nombreCategoria] || iconosPorCategoria['default'];
    }

    async function cargarPublicaciones() {
        try {
            const res = await fetch('{{ route("ong.donaciones.index") }}');
            const donaciones = await res.json();

            const container = document.getElementById('publicationsList');

            if (!donaciones.length) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay publicaciones disponibles en este momento.</p>
                    </div>`;
                return;
            }

            let html = '';
            donaciones.forEach((don, index) => {
                const icono = getIcono(don.categoria?.nombre);
                const hora = new Date(don.fecha_limite).toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit' });
                html += `
                    <div class="publication-item">
                        <div class="pub-category-icon"><i class="fas ${icono}"></i></div>
                        <div class="pub-content">
                            <div class="pub-title">${don.titulo}</div>
                            <div class="pub-description">${don.descripcion ?? ''}</div>
                            <div class="pub-meta">
                                <i class="fas fa-store"></i> ${don.comercio?.nombre_comercial ?? 'Comercio'} &nbsp;|&nbsp;
                                <i class="far fa-clock"></i> Hasta: ${hora}
                            </div>
                        </div>
                        <button class="pub-request-btn" onclick="abrirModal(${index})">
                            Solicitar <i class="fas fa-hand-holding-heart ms-1"></i>
                        </button>
                    </div>`;
            });
            container.innerHTML = html;
            window._donaciones = donaciones;
        } catch (e) {
            document.getElementById('publicationsList').innerHTML = `
                <div class="alert alert-warning">No se pudieron cargar las publicaciones.</div>`;
        }
    }

    function abrirModal(index) {
        const don = window._donaciones[index];
        donacionActual = don;
        const icono = getIcono(don.categoria?.nombre);
        const hora = new Date(don.fecha_limite).toLocaleTimeString('es-SV', { hour: '2-digit', minute: '2-digit' });

        document.getElementById('modalTitle').innerText = don.titulo;
        document.getElementById('modalDesc').innerText = don.descripcion ?? '';
        document.getElementById('modalComercio').innerText = don.comercio?.nombre_comercial ?? 'Comercio';
        document.getElementById('modalTime').innerText = `Límite: ${hora}`;
        document.getElementById('modalQty').innerText = don.cantidad;
        document.getElementById('modalIconContainer').innerHTML = `<i class="fas ${icono}"></i>`;
        document.getElementById('modalReserva').classList.add('active');
    }

    function cerrarModal() {
        document.getElementById('modalReserva').classList.remove('active');
    }

    async function confirmarReserva() {
        if (!donacionActual) return;
        
        try {
            const res = await fetch(`{{ url('/ong/reservas/crear') }}/${donacionActual.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    notas: '',
                    donacion_id: donacionActual.id 
                })
            });

            const data = await res.json();
            
            if (res.ok) {
                alert('¡Alimento reservado con éxito! El comercio ha sido notificado.');
                cerrarModal();
                cargarPublicaciones(); // Recarga la lista de disponibles
            } else {
                alert(data.message || 'Error al reservar el alimento.');
            }
        } catch (error) {
            console.error(error);
            alert('Ocurrió un error al procesar la reserva.');
        }
    }

    cargarPublicaciones();
</script>
@endpush
