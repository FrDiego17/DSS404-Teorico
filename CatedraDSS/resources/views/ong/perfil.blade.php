@extends('layouts.ong')

@section('title', 'Mi Perfil')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Mi Perfil</h2>

    <div style="background:white; border-radius:16px; padding:32px; box-shadow:0 4px 20px rgba(0,0,0,0.06); max-width:600px;">
        <div style="text-align:center; margin-bottom:28px;">
            <div style="width:80px; height:80px; background:#e8f5e9; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:36px;">🏢</div>
            <h4 style="font-weight:800; color:#1a2a32;">{{ Auth::user()->name }}</h4>
            <p style="color:#45b66f; font-weight:600; font-size:14px;">Organización No Gubernamental</p>
        </div>

        <div style="border-top:1px solid #e8f5e9; padding-top:20px;">
            <div class="mb-3">
                <label style="font-size:12px; color:#718096; font-weight:600; text-transform:uppercase;">Correo Electrónico</label>
                <p style="font-weight:600; color:#1a2a32; margin:0;">{{ Auth::user()->email }}</p>
            </div>
            <div class="mb-3">
                <label style="font-size:12px; color:#718096; font-weight:600; text-transform:uppercase;">Estado de Cuenta</label>
                <p style="margin:0;">
                    @if(Auth::user()->estado === 'activo')
                        <span style="background:#e8f5e9; color:#2e7d32; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">✓ Activa</span>
                    @else
                        <span style="background:#fff3cd; color:#e65100; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">⏳ Pendiente</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
