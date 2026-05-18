@extends('layouts.comercio')

@section('title', 'Mis Publicaciones')

@section('content')
<main class="container mb-5" style="padding-top: 20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32;">Mis Publicaciones</h2>
        <button class="btn" style="background:#45b66f; color:white; border-radius:20px; padding:8px 20px; font-weight:600;" id="btnNuevaPub">
            <i class="fas fa-plus me-2"></i>Nueva Publicación
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius:12px;">{{ session('success') }}</div>
    @endif

    @forelse($donaciones as $don)
        @php
            $iconos = ['Platos Preparados'=>'fa-utensils','Panadería y Repostería'=>'fa-bread-slice','Frutas y Verduras'=>'fa-apple-alt','Bebidas y Jugos'=>'fa-wine-bottle','Lácteos y Embutidos'=>'fa-cheese','Carnes'=>'fa-drumstick-bite'];
            $icono = $iconos[$don->categoria->nombre ?? ''] ?? 'fa-box-open';
            $hora = $don->fecha_limite ? \Carbon\Carbon::parse($don->fecha_limite)->format('H:i') : '--:--';
        @endphp
        <div class="publication-item fs-pub-card">
            <div class="pub-category-icon"><i class="fas {{ $icono }}"></i></div>
            <div class="pub-content">
                <div class="pub-title">
                    {{ $don->titulo }}
                    <span class="badge bg-success ms-2">{{ $don->cantidad }} uds</span>
                    <span class="badge ms-1" style="background:{{ $don->estado === 'disponible' ? '#e8f5e9' : '#fff3cd' }}; color:{{ $don->estado === 'disponible' ? '#2e7d32' : '#e65100' }}; font-size:11px;">
                        {{ ucfirst($don->estado) }}
                    </span>
                </div>
                <div class="pub-description">{{ $don->descripcion }}</div>
                <div class="pub-meta"><i class="far fa-clock"></i> Límite: {{ $hora }}</div>
            </div>
        </div>
    @empty
        <div class="text-center py-5" style="color:#aaa;">
            <i class="fas fa-box-open fa-3x mb-3"></i>
            <p>Aún no tienes publicaciones activas.</p>
        </div>
    @endforelse

</main>

<!-- Modal para una nueva publicación -->
<div class="fs-modal-overlay" id="modalNuevaPub">
    <div class="fs-modal-content">
        <button class="fs-modal-close" id="btnCloseModal">&times;</button>
        <h3 style="color:#45b66f; margin-bottom:20px;">Nueva Publicación</h3>
        <form method="POST" action="{{ route('comercio.donaciones.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label text-muted">Categoría</label>
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
                <textarea class="form-control" rows="3" name="descripcion" placeholder="Describe el excedente..."></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label text-muted">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad" min="1" required>
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
    const btn = document.getElementById("btnNuevaPub");
    const modal = document.getElementById("modalNuevaPub");
    const close = document.getElementById("btnCloseModal");
    btn.addEventListener("click", () => modal.classList.add("active"));
    close.addEventListener("click", () => modal.classList.remove("active"));
    modal.addEventListener("click", e => { if(e.target===modal) modal.classList.remove("active"); });
</script>
@endpush
