@extends('layouts.comercio')

@section('title', 'Dashboard Comercio')

@section('content')

<section class="hero-fullscreen">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h1 class="hero-title-new mb-3">
                    BIENVENIDO AL PANEL DE <span>{{ Auth::user()->name }}</span><br>
                    PUBLICÁ TUS EXCEDENTES Y AYUDA
                </h1>
                <p class="hero-subtitle-new">
                    Tus donaciones hacen la diferencia. Administra tus publicaciones, revisa el impacto social y conoce las organizaciones registradas.
                </p>
                <button class="btn-hero-cta mt-3" id="btnNuevaPub">
                    Publicar Excedente <i class="fas fa-plus ms-2"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<main class="container mb-5">

    <div class="row features-grid mb-5">
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='{{ route('comercio.estadisticas') }}'">
                <div class="card-icon-elegant"><i class="fas fa-chart-line"></i></div>
                <h4>Estadística de Donaciones</h4>
                <p>Revisa las donaciones que has realizado mensualmente de forma gráfica.</p>
                <a href="{{ route('comercio.estadisticas') }}" class="btn-elegant">Ver Donaciones</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='{{ route('comercio.impacto') }}'">
                <div class="card-icon-elegant"><i class="fas fa-hands-holding-circle"></i></div>
                <h4>Impacto Social</h4>
                <p>Historias de cambios que se han logrado con los aportes de las donaciones.</p>
                <a href="{{ route('comercio.impacto') }}" class="btn-elegant">Ver Impacto</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='{{ route('comercio.organizaciones') }}'">
                <div class="card-icon-elegant"><i class="fas fa-hand-holding-heart"></i></div>
                <h4>Organizaciones Sociales</h4>
                <p>Conoce las organizaciones registradas que pueden recoger tus excedentes.</p>
                <a href="{{ route('comercio.organizaciones') }}" class="btn-elegant">Ver Organizaciones</a>
            </div>
        </div>
    </div>

    <!-- Publicaciones recientes -->
    <div class="publications-section">
        <div class="section-header">
            <h3><i class="fas fa-newspaper me-2"></i> Mis Publicaciones Recientes</h3>
            <a href="{{ route('comercio.donaciones') }}" class="btn-new">Ver más ></a>
        </div>

        <div id="publicationsGridHome">
            @forelse($donacionesRecientes as $don)
                @php
                    $iconos = [
                        'Platos Preparados' => 'fa-utensils',
                        'Panadería y Repostería' => 'fa-bread-slice',
                        'Frutas y Verduras' => 'fa-apple-alt',
                        'Bebidas y Jugos' => 'fa-wine-bottle',
                        'Lácteos y Embutidos' => 'fa-cheese',
                        'Carnes' => 'fa-drumstick-bite',
                    ];
                    $icono = $iconos[$don->categoria->nombre ?? ''] ?? 'fa-box-open';
                    $hora = $don->fecha_limite ? \Carbon\Carbon::parse($don->fecha_limite)->format('H:i') : '--:--';
                @endphp
                <div class="publication-item fs-pub-card">
                    <div class="pub-category-icon"><i class="fas {{ $icono }}"></i></div>
                    <div class="pub-content">
                        <div class="pub-title">
                            {{ $don->titulo }}
                            <span class="badge bg-success ms-2">{{ $don->cantidad }} unidades</span>
                        </div>
                        <div class="pub-description">{{ $don->descripcion }}</div>
                        <div class="pub-meta">
                            <i class="far fa-clock"></i> Recoger antes de {{ $hora }}
                        </div>
                    </div>
                    <button class="pub-request-btn fs-pub-btn">
                        Editar / Renovar <i class="fas fa-pencil-alt ms-1"></i>
                    </button>
                </div>
            @empty
                <div class="text-center py-5" style="color:#aaa;">
                    <i class="fas fa-box-open fa-3x mb-3"></i>
                    <p>Aún no tienes publicaciones. ¡Publica tu primer excedente!</p>
                </div>
            @endforelse
        </div>
    </div>
</main>

    <!-- Modal para una nueva publicación -->
<div class="fs-modal-overlay" id="modalNuevaPub">
    <div class="fs-modal-content">
        <button class="fs-modal-close" id="btnCloseModal">&times;</button>
        <h3 style="color: #45b66f; margin-bottom: 20px;">Nueva Publicación</h3>

        <form id="formNuevaPub" method="POST" action="{{ route('comercio.donaciones.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label text-muted">¿Qué excedente tienes?</label>
                <select class="form-select" name="categoria_id" required>
                    <option disabled selected value="">Selecciona una categoría</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">Título</label>
                <input type="text" class="form-control" name="titulo" placeholder="Ej: Platos preparados del día" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">Descripción</label>
                <textarea class="form-control" rows="3" name="descripcion" placeholder="Ej: Platos de guisado de carne, arroz, ensalada..."></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label text-muted">Cantidad (unidades)</label>
                    <input type="number" class="form-control" name="cantidad" placeholder="0" min="1" required>
                </div>
                <div class="col-6">
                    <label class="form-label text-muted">Recoger antes de</label>
                    <input type="datetime-local" class="form-control" name="fecha_limite" required>
                </div>
            </div>
            <button type="submit" class="btn-fs-modal-submit">Publicar Excedente</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const btnOpen = document.getElementById("btnNuevaPub");
    const btnClose = document.getElementById("btnCloseModal");
    const modal = document.getElementById("modalNuevaPub");

    btnOpen.addEventListener("click", () => modal.classList.add("active"));
    btnClose.addEventListener("click", () => modal.classList.remove("active"));
    modal.addEventListener("click", (e) => { if (e.target === modal) modal.classList.remove("active"); });

    document.addEventListener('click', function(e) {
        if(e.target.closest('.fs-pub-btn')) {
            modal.classList.add("active");
        }
    });
</script>
@endpush
