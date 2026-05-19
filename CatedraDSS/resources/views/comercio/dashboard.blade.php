@extends('layouts.comercio')

@section('title', 'Dashboard Comercio')

@section('content')

<section class="hero-fullscreen" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('{{ asset('resources/img/index.png') }}'); background-size: cover; background-position: center;">
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

        <div class="row">
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
                    $hora = $don->fecha_limite ? \Carbon\Carbon::parse($don->fecha_limite)->format('d/m/Y H:i') : '--/--/---- --:--';
                    $esReservada = $don->estado === 'reservada';
                    $esEntregada = $don->estado === 'entregada';
                    $esVencida   = $don->estado === 'publicada' && $don->fecha_limite && \Carbon\Carbon::parse($don->fecha_limite)->isPast();
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="fs-pub-card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border:1px solid {{ $esEntregada ? '#c6f6d5' : ($esReservada ? '#bee3f8' : ($esVencida ? '#fed7d7' : '#e8f5e9')) }};">
                        <div>
                            <div class="pub-category-icon" style="background:#45b66f22; color:#45b66f; width:50px; height:50px; display:flex; align-items:center; justify-content:center; border-radius:50%; margin-bottom:15px; font-size:24px;">
                                <i class="fas {{ $icono }}"></i>
                            </div>
                            <h5 style="font-weight:800; color:#1a2a32; margin-bottom:8px;">
                                {{ $don->titulo }}
                                <span class="badge bg-success ms-2" style="font-size:11px; vertical-align:middle;">{{ $don->cantidad }} uds</span>
                                {{-- Badge de estado --}}
                                @if($esEntregada)
                                    <span class="badge ms-1" style="font-size:11px; vertical-align:middle; background:#c6f6d5; color:#22543d;">
                                        ✅ Entregada
                                    </span>
                                @elseif($esReservada)
                                    <span class="badge ms-1" style="font-size:11px; vertical-align:middle; background:#bee3f8; color:#2c5282;">
                                        📦 Reservada
                                    </span>
                                @elseif($esVencida)
                                    <span class="badge ms-1" style="font-size:11px; vertical-align:middle; background:#fed7d7; color:#9b2c2c;">
                                        ⏳ Tiempo Agotado
                                    </span>
                                @else
                                    <span class="badge ms-1" style="font-size:11px; vertical-align:middle; background:#fff3cd; color:#e65100;">
                                        {{ ucfirst($don->estado) }}
                                    </span>
                                @endif
                            </h5>
                            <p style="font-size:13px; color:#718096; margin-bottom:16px;">{{ \Illuminate\Support\Str::limit($don->descripcion, 70) }}</p>
                            
                            <div class="pub-meta mb-3" style="font-size:13px; color:#e65100; font-weight:600;">
                                <i class="far fa-clock me-1"></i> Límite: {{ $hora }}
                            </div>
                        </div>
                        @if(!$esEntregada)
                            <button class="pub-request-btn fs-pub-btn w-100" onclick='abrirModalEditar(@json($don))' style="background:#f8f9fa; color:#45b66f; border:1px solid #45b66f; padding:10px; border-radius:8px; font-weight:600; text-align:center; transition: all 0.3s; cursor:pointer;">
                                Editar / Renovar <i class="fas fa-pencil-alt ms-1"></i>
                            </button>
                        @else
                            <div style="text-align:center; padding:10px; border-radius:8px; background:#f0fff4; color:#276749; font-size:13px; font-weight:600; border:1px solid #c6f6d5;">
                                <i class="fas fa-check-double me-1"></i> Proceso completado
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5" style="color:#aaa;">
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

        @if ($errors->any())
            <div class="alert alert-danger" style="border-radius:12px; font-size:0.9rem;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formNuevaPub" method="POST" action="{{ route('comercio.donaciones.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
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
                <div class="col-4">
                    <label class="form-label text-muted">Cantidad (unidades)</label>
                    <input type="number" class="form-control" name="cantidad" placeholder="0" min="1" required>
                </div>
                <div class="col-4">
                    <label class="form-label text-muted">Peso estimado (kg)</label>
                    <input type="number" step="0.01" class="form-control" name="peso_estimado_kg" placeholder="0.00" min="0" value="0">
                </div>
                <div class="col-4">
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
    const form = document.getElementById("formNuevaPub");
    const formMethod = document.getElementById("formMethod");
    const modalTitle = modal.querySelector("h3");

    // Limitar fecha mínima a la actual
    const fechaInput = document.querySelector('input[name="fecha_limite"]');
    if(fechaInput){
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        fechaInput.min = now.toISOString().slice(0, 16);
    }

    btnOpen.addEventListener("click", () => {
        form.action = "{{ route('comercio.donaciones.store') }}";
        formMethod.value = "POST";
        form.reset();
        modalTitle.innerText = "Nueva Publicación";
        modal.classList.add("active");
    });
    
    btnClose.addEventListener("click", () => modal.classList.remove("active"));
    modal.addEventListener("click", (e) => { if (e.target === modal) modal.classList.remove("active"); });

    window.abrirModalEditar = function(donacion) {
        form.action = `{{ url('/comercio/donaciones') }}/${donacion.id}`;
        formMethod.value = "PUT";
        
        form.querySelector('[name="categoria_id"]').value = donacion.categoria_id;
        form.querySelector('[name="titulo"]').value = donacion.titulo;
        form.querySelector('[name="descripcion"]').value = donacion.descripcion;
        form.querySelector('[name="cantidad"]').value = donacion.cantidad;
        form.querySelector('[name="peso_estimado_kg"]').value = donacion.peso_estimado_kg;
        
        if (donacion.fecha_limite) {
            form.querySelector('[name="fecha_limite"]').value = donacion.fecha_limite.slice(0, 16);
        }

        modalTitle.innerText = "Editar / Renovar Publicación";
        modal.classList.add("active");
    };

    @if ($errors->any())
        modal.classList.add("active");
    @endif
</script>
@endpush
