@extends('layouts.comercio')

@section('title', 'Estadísticas')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Estadísticas de Donaciones</h2>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border-left:4px solid #45b66f; text-align:center;">
                <div style="font-size:2rem; font-weight:900; color:#45b66f;">{{ $totalDonaciones }}</div>
                <div style="font-size:13px; color:#718096; font-weight:600;">Total Publicaciones</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border-left:4px solid #45b66f; text-align:center;">
                <div style="font-size:2rem; font-weight:900; color:#45b66f;">{{ $donacionesEntregadas }}</div>
                <div style="font-size:13px; color:#718096; font-weight:600;">Entregadas</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div style="background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border-left:4px solid #45b66f; text-align:center;">
                <div style="font-size:2rem; font-weight:900; color:#45b66f;">{{ number_format($totalKg, 1) }} kg</div>
                <div style="font-size:13px; color:#718096; font-weight:600;">Kg Donados</div>
            </div>
        </div>
    </div>

    <div style="background:white; border-radius:16px; padding:30px; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
        <h5 style="font-weight:700; color:#1a2a32; margin-bottom:20px;">Donaciones por Categoría</h5>
        @forelse($porCategoria as $cat)
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span style="font-size:14px; font-weight:600; color:#2d3748;">{{ $cat->nombre }}</span>
                    <span style="font-size:14px; color:#718096;">{{ $cat->total }} publicaciones</span>
                </div>
                <div style="background:#e8f5e9; border-radius:10px; height:10px; overflow:hidden;">
                    <div style="background:#45b66f; height:100%; width:{{ $totalDonaciones > 0 ? round($cat->total / $totalDonaciones * 100) : 0 }}%; border-radius:10px; transition:width 0.5s;"></div>
                </div>
            </div>
        @empty
            <p style="color:#aaa;">No hay datos de categorías aún.</p>
        @endforelse
    </div>
</main>
@endsection
