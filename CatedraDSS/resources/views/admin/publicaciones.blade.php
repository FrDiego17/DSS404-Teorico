@extends('layouts.admin')

@section('title', 'Publicaciones')

@section('content')
<main class="container" style="padding-top: 20px; min-height: 75vh; padding-bottom: 60px;">

    <!-- barra de busqueda -->
    <div class="admin-search-wrap">
        <input type="text" id="searchPublicaciones" placeholder="Buscar en publicaciones...">
        <i class="fas fa-search search-icon"></i>
    </div>

    <h2 class="admin-section-title">Publicaciones de Excedentes</h2>

    @if($donaciones->isEmpty())
        <div style="text-align:center; padding:60px 0; color:#aaa;">
            <i class="fas fa-box-open fa-3x mb-3"></i>
            <p>No hay publicaciones activas en este momento.</p>
        </div>
    @else
        <div class="pub-figma-grid mb-5">
            @foreach($donaciones as $don)
                @php
                    $iconos = [
                        'Platos Preparados' => '🍽️',
                        'Panadería y Repostería' => '🥐',
                        'Frutas y Verduras' => '🥦',
                        'Bebidas y Jugos' => '🧃',
                        'Lácteos y Embutidos' => '🧀',
                        'Carnes' => '🥩',
                    ];
                    $emoji = $iconos[$don->categoria->nombre ?? ''] ?? '📦';
                    $hora = $don->fecha_limite ? \Carbon\Carbon::parse($don->fecha_limite)->format('H:i') : '—';

                    $esReservada = $don->estado === 'reservada';
                    $esEntregada = $don->estado === 'entregada';
                    $esCancelada = $don->estado === 'cancelada';
                    $esVencida   = ($don->estado === 'publicada' || $don->estado === 'vencida') && $don->fecha_limite && \Carbon\Carbon::parse($don->fecha_limite)->isPast();

                    if ($esEntregada) {
                        $estadoText = 'Entregada';
                        $estadoColor = '#2c5282'; 
                    } elseif ($esVencida) {
                        $estadoText = 'Vencida';
                        $estadoColor = '#e53e3e'; 
                    } elseif ($esReservada) {
                        $estadoText = 'Reservada';
                        $estadoColor = '#d69e2e'; 
                    } elseif ($esCancelada) {
                        $estadoText = 'Cancelada';
                        $estadoColor = '#718096'; 
                    } else {
                        $estadoText = 'Publicada';
                        $estadoColor = '#45b66f'; 
                    }
                @endphp
                <div class="pub-figma-card search-card">
                    <span class="card-img">{{ $emoji }}</span>
                    <div class="card-title-row">
                        <span class="card-title search-title">{{ $don->titulo }}</span>
                        <span class="card-qty">{{ $don->cantidad }}</span>
                    </div>
                    <p class="card-desc search-desc">{{ $don->descripcion }}</p>
                    <div class="card-footer-row">
                        <span class="card-time">{{ $hora }}</span>
                        <span style="font-size:11px; color:{{ $estadoColor }}; font-weight:600;">{{ $estadoText }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</main>

@push('scripts')
<script>
document.getElementById("searchPublicaciones").addEventListener("keyup", function () {
    var filter = this.value.toLowerCase();
    document.querySelectorAll(".search-card").forEach(function (card) {
        var title = (card.querySelector(".search-title") || {innerText: ""}).innerText.toLowerCase();
        var desc = (card.querySelector(".search-desc") || {innerText: ""}).innerText.toLowerCase();
        card.style.display = (title.includes(filter) || desc.includes(filter)) ? "" : "none";
    });
});
</script>
@endpush

@endsection
