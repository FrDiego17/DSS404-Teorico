@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<section style="background-color: #eef7ee; padding: 60px 0; margin-bottom: 50px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -80px; right: -120px; width: 520px; height: 520px; background-color: #45b66f; border-radius: 50%; z-index: 1;"></div>

    <div style="position: absolute; top: 20px; right: 80px; width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 4px solid white; z-index: 2; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
        <img src="{{ asset('resources/img/index.png') }}" alt="" style="width:100%; height:100%; object-fit:cover;" onerror="this.style.display='none'">
    </div>
    <div style="position: absolute; top: 140px; right: 30px; width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 4px solid white; z-index: 2; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
        <img src="{{ asset('resources/img/header.jpeg') }}" alt="" style="width:100%; height:100%; object-fit:cover;" onerror="this.style.display='none'">
    </div>
    <div style="position: absolute; bottom: 30px; right: 120px; width: 70px; height: 70px; border-radius: 50%; overflow: hidden; border: 4px solid white; z-index: 2; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
        <img src="{{ asset('resources/img/index.png') }}" alt="" style="width:100%; height:100%; object-fit:cover;" onerror="this.style.display='none'">
    </div>

    <div class="container" style="position: relative; z-index: 3;">
        <div class="row">
            <div class="col-lg-7">
                <p style="font-size: 1rem; color: #666; margin-bottom: 4px;">
                    BIENVENIDO <strong style="color: #45b66f;">{{ Auth::user()->name }}</strong>
                </p>
                <h1 style="font-size: 2.2rem; font-weight: 900; color: #1a2a32; line-height: 1.2; margin-bottom: 16px;">
                    Comprueba los Comercios y ONG Registrados
                </h1>
                <p style="color: #555; max-width: 420px; font-size: 0.95rem; margin-bottom: 28px;">
                    Gestiona las organizaciones, comercios y publicaciones de excedentes de alimentos del sistema.
                </p>
                <a href="{{ route('admin.ongs.index') }}" class="btn-elegant" style="padding: 12px 30px; border-radius: 30px;">
                    Administrar Registros
                </a>
            </div>
        </div>
    </div>
</section>

<main class="container mb-5">

    <!-- Estadisticas -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border-left:4px solid #45b66f; text-align:center;">
                <div style="font-size:2rem; font-weight:900; color:#45b66f;">{{ $ongsPendientes }}</div>
                <div style="font-size:13px; color:#718096; font-weight:600;">ONGs Pendientes</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border-left:4px solid #45b66f; text-align:center;">
                <div style="font-size:2rem; font-weight:900; color:#45b66f;">{{ $totalDonaciones }}</div>
                <div style="font-size:13px; color:#718096; font-weight:600;">Total Donaciones</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border-left:4px solid #45b66f; text-align:center;">
                <div style="font-size:2rem; font-weight:900; color:#45b66f;">{{ number_format($totalKgSalvados, 1) }} kg</div>
                <div style="font-size:13px; color:#718096; font-weight:600;">Kg Salvados</div>
            </div>
        </div>
    </div>

    <div class="row features-grid mb-5">
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='{{ route('admin.comercios.index') }}'">
                <div class="card-icon-elegant"><i class="fas fa-store"></i></div>
                <h4>Estadística de Registros</h4>
                <p>Conoce a los comercios registrados que realizan las donaciones de excedentes.</p>
                <a href="{{ route('admin.comercios.index') }}" class="btn-elegant">Ver Comercios</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='{{ route('admin.publicaciones.index') }}'">
                <div class="card-icon-elegant"><i class="fas fa-hands-holding-circle"></i></div>
                <h4>Impacto Social</h4>
                <p>Publicaciones activas de excedentes de alimentos en el sistema.</p>
                <a href="{{ route('admin.publicaciones.index') }}" class="btn-elegant">Ver Publicaciones</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="elegant-card" onclick="location.href='{{ route('admin.ongs.index') }}'">
                <div class="card-icon-elegant"><i class="fas fa-hand-holding-heart"></i></div>
                <h4>Organizaciones Sociales</h4>
                <p>Conoce las organizaciones registradas que pueden recoger excedentes.</p>
                <a href="{{ route('admin.ongs.index') }}" class="btn-elegant">Ver Organizaciones</a>
            </div>
        </div>
    </div>

    @if($ongsPendientes > 0)
    <div class="alert" style="background:#fff3cd; border:1px solid #ffc107; border-radius:12px; padding:16px 20px; display:flex; align-items:center; gap:14px;">
        <i class="fas fa-exclamation-triangle" style="color:#e65100; font-size:20px;"></i>
        <div>
            <strong>Hay {{ $ongsPendientes }} organización(es) pendiente(s) de aprobación.</strong>
            <a href="{{ route('admin.ongs.index') }}" style="color:#45b66f; font-weight:600; margin-left:8px;">Revisar ahora →</a>
        </div>
    </div>
    @endif

</main>

@endsection
