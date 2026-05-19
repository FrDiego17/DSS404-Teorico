@extends('layouts.app')

@section('title', 'Organizaciones')

@section('content')
<div class="d-flex flex-column" style="min-height: 75vh;">
    <main class="container my-5 flex-grow-1">
        
        <div class="text-center mb-5 mt-4">
            <span class="text-uppercase fw-bold tracking-wider" style="color: #45b66f; font-size: 0.85rem; letter-spacing: 2px;">
                Red de Apoyo
            </span>
            <h1 class="fw-extrabold mt-1 mb-3" style="color: #1a2a32; font-size: 2.5rem; font-weight: 800;">
                Organizaciones <span style="color: #45b66f;">Aliadas</span>
            </h1>
            <div class="mx-auto" style="width: 60px; height: 4px; background-color: #45b66f; border-radius: 2px;"></div>
            <p class="text-muted mx-auto mt-3" style="max-width: 650px; font-size: 1.05rem; line-height: 1.6;">
                Estas son las instituciones y ONGs verificadas que operan en la plataforma, listas para reservar y donar tus excedentes de alimentos a quienes más lo necesitan.
            </p>
        </div>

        <div class="row">
            @forelse($organizaciones as $org)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                        <div class="card-body p-4">
                            
                            <div class="mb-3 bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.3rem;">
                                <i class="fas fa-building"></i>
                            </div>
                            
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">
                                {{ $org->nombre_comercial ?? $org->nombre_oficial }}
                            </h5>
                            <p class="text-success fw-semibold mb-4" style="font-size: 0.8rem;">
                                <i class="fas fa-check-circle me-1"></i>Organización Verificada
                            </p>
                            
                            <div class="text-secondary small" style="font-size: 0.875rem; line-height: 1.8;">
                                <div class="d-flex align-items-start mb-2">
                                    <i class="fas fa-map-marker-alt text-muted mt-1 me-2" style="width: 16px; text-align: center;"></i> 
                                    <span>{{ $org->direccion }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone text-muted me-2" style="width: 16px; text-align: center;"></i> 
                                    <span>{{ $org->telefono_contacto }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user text-muted me-2" style="width: 16px; text-align: center;"></i> 
                                    <span>Rep: {{ $org->representante_legal }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted mb-3" style="font-size: 3rem;">
                        <i class="fas fa-building-circle-exclamation"></i>
                    </div>
                    <h5 class="fw-bold text-secondary">No hay organizaciones disponibles</h5>
                    <p class="text-muted small">Por el momento no se registran ONGs activas en esta región.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection