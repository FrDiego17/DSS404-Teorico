@extends('layouts.comercio')

@section('title', 'Organizaciones')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Organizaciones Registradas</h2>
    <p style="color:#718096; margin-bottom:32px;">Estas son las organizaciones verificadas que pueden recoger tus excedentes de alimentos.</p>

    <div class="row">
        @forelse($organizaciones as $org)
            <div class="col-md-4 mb-4">
                <div class="fs-pub-card" style="display:flex; flex-direction:column; justify-content:space-between; height:100%;">
                    <div>
                        <div class="pub-category-icon" style="background:#45b66f22; color:#45b66f; width:50px; height:50px; display:flex; align-items:center; justify-content:center; border-radius:50%; margin-bottom:15px; font-size:24px;">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5 style="font-weight:800; color:#1a2a32; margin-bottom:4px;">{{ $org->nombre_oficial }}</h5>
                        <p style="font-size:12px; color:#45b66f; font-weight:600; margin-bottom:16px;">
                            <i class="fas fa-check-circle me-1"></i>Organización Verificada
                        </p>
                        
                        <div class="pub-meta mb-2">
                            <i class="fas fa-map-marker-alt" style="width:20px; text-align:center;"></i> {{ $org->direccion }}
                        </div>
                        <div class="pub-meta mb-2">
                            <i class="fas fa-phone" style="width:20px; text-align:center;"></i> {{ $org->telefono_contacto }}
                        </div>
                        <div class="pub-meta mb-3">
                            <i class="fas fa-user" style="width:20px; text-align:center;"></i> {{ $org->representante_legal }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5" style="color:#aaa;">
                <i class="fas fa-building fa-3x mb-3"></i>
                <p>No hay organizaciones verificadas aún.</p>
            </div>
        @endforelse
    </div>
</main>
@endsection
