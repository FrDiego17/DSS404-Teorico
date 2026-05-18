@extends('layouts.ong')

@section('title', 'Documentos')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Mis Documentos</h2>

    <div style="background:white; border-radius:16px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,0.06);">
        <div class="text-center py-5" style="color:#aaa;">
            <i class="fas fa-folder-open fa-3x mb-3"></i>
            <p>No tienes documentos subidos aún.</p>
            <button class="btn" style="background:#45b66f; color:white; border-radius:20px; padding:8px 24px; font-weight:600;">
                <i class="fas fa-upload me-2"></i>Subir Documento
            </button>
        </div>
    </div>
</main>
@endsection
