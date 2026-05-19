@extends('layouts.app')

@section('title', 'Proveedores Aliados')

@section('content')
<div class="d-flex flex-column" style="min-height: 75vh;">
    <main class="container my-5 flex-grow-1">
        
        <div class="text-center mb-5 mt-4">
            <span class="text-uppercase fw-bold tracking-wider" style="color: #45b66f; font-size: 0.85rem; letter-spacing: 2px;">
                Socios Donantes
            </span>
            <h1 class="fw-extrabold mt-1 mb-3" style="color: #1a2a32; font-size: 2.5rem; font-weight: 800;">
                Proveedores <span style="color: #45b66f;">Aliados</span>
            </h1>
            <div class="mx-auto" style="width: 60px; height: 4px; background-color: #45b66f; border-radius: 2px;"></div>
            <p class="text-muted mx-auto mt-3" style="max-width: 650px; font-size: 1.05rem; line-height: 1.6;">
                Conoce a los proveedores comprometidos que hacen posible nuestra labor donando sus excedentes de comida a los que más los necesitan.
            </p>
        </div>

        <div class="row">
            @forelse($proveedores as $prov)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                        <div class="card-body p-4">
                            
                            <div class="mb-3 bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.3rem;">
                                <i class="fas fa-store"></i>
                            </div>
                            
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">
                                {{ $prov->nombre_comercial ?? $prov->razon_social }}
                            </h5>
                            <p class="text-success fw-semibold mb-4" style="font-size: 0.8rem;">
                                <i class="fas fa-heart me-1"></i>Proveedor de Alimentos
                            </p>
                            
                            <div class="text-secondary small" style="font-size: 0.875rem; line-height: 1.8;">
                                <div class="d-flex align-items-start mb-2">
                                    <i class="fas fa-map-marker-alt text-muted mt-1 me-2" style="width: 16px; text-align: center;"></i> 
                                    <span>{{ $prov->direccion }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone text-muted me-2" style="width: 16px; text-align: center;"></i> 
                                    <span>{{ $prov->telefono ?? 'Teléfono no disponible' }}</span>
                                </div>
                                @if(!empty($prov->rubro))
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tags text-muted me-2" style="width: 16px; text-align: center;"></i> 
                                    <span>Giro: {{ $prov->rubro }}</span>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted mb-3" style="font-size: 3rem;">
                        <i class="fas fa-store-slash"></i>
                    </div>
                    <h5 class="fw-bold text-secondary">No hay proveedores registrados</h5>
                    <p class="text-muted small">Pronto verás aquí la lista de comercios unidos al movimiento.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection