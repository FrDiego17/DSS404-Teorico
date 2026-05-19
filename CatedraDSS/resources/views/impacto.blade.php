@extends('layouts.app')

@section('title', 'Nuestro Impacto')

@section('content')
<div class="d-flex flex-column" style="min-height: 75vh;">
    <main class="container my-5 flex-grow-1">
        <div class="text-center mb-5 mt-4">
            <span class="text-uppercase fw-bold tracking-wider" style="color: #45b66f; font-size: 0.85rem; letter-spacing: 2px;">
                Nuestra Huella
            </span>
            <h1 class="fw-extrabold mt-1 mb-3" style="color: #1a2a32; font-size: 2.5rem; font-weight: 800;">
                Historias de <span style="color: #45b66f;">Impacto</span>
            </h1>
            <div class="mx-auto" style="width: 60px; height: 4px; background-color: #45b66f; border-radius: 2px;"></div>
            <p class="text-muted mx-auto mt-3" style="max-width: 600px; font-size: 1.05rem; line-height: 1.6;">
                Conoce cómo las ONGs aliadas transforman los excedentes de alimentos en ayuda real, reduciendo el desperdicio y alimentando esperanzas.
            </p>
        </div>

    <div class="row">
        @forelse($impactosGlobales as $impacto)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-body p-4 d-flex flex-direction-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 1.1rem;">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="ms-3">
                                    {{-- Mostramos el nombre de la organización o el del usuario si no está el perfil completo --}}
                                    <h6 class="fw-bold text-dark m-0" style="font-size: 0.95rem;">
                                        {{ $impacto->organizacion->nombre_comercial ?? $impacto->organizacion->usuario->name ?? 'ONG Aliada' }}
                                    </h6>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $impacto->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>

                            <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.1rem;">
                                {{ $impacto->titulo }}
                            </h5>
                            <p class="card-text text-secondary" style="font-size: 0.9rem; line-height: 1.6;">
                                {{ $impacto->descripcion }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted mb-3" style="font-size: 3rem;">
                    <i class="fas fa-heart-broken"></i>
                </div>
                <h5 class="fw-bold text-secondary">Aún no hay historias compartidas</h5>
                <p class="text-muted small">Pronto verás aquí el impacto de nuestra comunidad.</p>
            </div>
        @endforelse
    </div>
    </main>
</div>
@endsection