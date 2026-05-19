@extends('layouts.ong')

@section('title', 'Comercios Proveedores')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <div class="mb-4">
        <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:8px;">Comercios Proveedores</h2>
        <p style="color:#718096; margin-bottom:24px;">Listado de establecimientos y donantes aliados que comparten sus excedentes en la plataforma.</p>
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
                            <i class="fas fa-heart me-1"></i>Proveedor Activo
                        </p>
                        
                        <div class="text-secondary small" style="font-size: 0.875rem; line-height: 1.8;">
                            <div class="d-flex align-items-start mb-2">
                                <i class="fas fa-map-marker-alt text-muted mt-1 me-2" style="width: 16px; text-align: center;"></i> 
                                <span>{{ $prov->direccion }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-phone text-muted me-2" style="width: 16px; text-align: center;"></i> 
                                <span>{{ $prov->telefono ?? 'Teléfono no registrado' }}</span>
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
            <div class="col-12 text-center py-5" style="color:#aaa;">
                <i class="fas fa-store-slash fa-3x mb-3"></i>
                <p>No hay comercios proveedores registrados en este momento.</p>
            </div>
        @endforelse
    </div>
</main>
@endsection