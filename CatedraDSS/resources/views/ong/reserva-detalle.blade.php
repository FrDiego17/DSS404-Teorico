@extends('layouts.ong')

@section('title', 'Detalle de Reserva')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <div class="mb-4">
        <a href="{{ route('ong.reservados') }}" style="color:#45b66f; font-weight:600; text-decoration:none;">
            <i class="fas fa-arrow-left me-2"></i>Volver a Reservados
        </a>
    </div>
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Detalle de Reserva</h2>

    <div style="background:white; border-radius:16px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
        <div class="text-center py-5" style="color:#aaa;">
            <i class="fas fa-box fa-3x mb-3"></i>
            <p>Cargando detalle de la reserva...</p>
        </div>
    </div>
</main>
@endsection
