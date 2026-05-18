@extends('layouts.comercio')

@section('title', 'Organizaciones')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Organizaciones Registradas</h2>
    <p style="color:#718096; margin-bottom:32px;">Estas son las organizaciones verificadas que pueden recoger tus excedentes de alimentos.</p>

    <div class="row">
        @forelse($organizaciones as $org)
            <div class="col-md-4 mb-4">
                <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border:1px solid #e8f5e9; height:100%;">
                    <h5 style="font-weight:800; color:#1a2a32; text-align:center; margin-bottom:4px;">{{ $org->nombre_oficial }}</h5>
                    <p style="font-size:12px; color:#45b66f; text-align:center; font-weight:600; margin-bottom:12px;">Verificada ✓</p>
                    <div style="font-size:13px; color:#718096;">
                        <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-success"></i>{{ $org->direccion }}</p>
                        <p class="mb-1"><i class="fas fa-phone me-2 text-success"></i>{{ $org->telefono_contacto }}</p>
                        <p class="mb-0"><i class="fas fa-user me-2 text-success"></i>{{ $org->representante_legal }}</p>
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
