@extends('layouts.comercio')

@section('title', 'Impacto Social')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Impacto Social</h2>

    <div class="row mb-5">
        <div class="col-md-4 mb-4">
            <div style="background:white; border-radius:16px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.06); text-align:center; border:1px solid #e8f5e9;">
                <h5 style="font-weight:800; color:#1a2a32;">Tu contribución</h5>
                <p style="font-size:13px; color:#718096;">Cada excedente que publicas se convierte en una oportunidad de nutrición para quienes más lo necesitan.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div style="background:white; border-radius:16px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.06); text-align:center; border:1px solid #e8f5e9;">
                <h5 style="font-weight:800; color:#1a2a32;">Alianzas</h5>
                <p style="font-size:13px; color:#718096;">Trabajamos con organizaciones verificadas que garantizan que los alimentos lleguen a quienes los necesitan.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div style="background:white; border-radius:16px; padding:28px; box-shadow:0 4px 20px rgba(0,0,0,0.06); text-align:center; border:1px solid #e8f5e9;">
                <h5 style="font-weight:800; color:#1a2a32;">Sostenibilidad</h5>
                <p style="font-size:13px; color:#718096;">Reducimos el desperdicio alimentario y generamos un impacto positivo en el medio ambiente.</p>
            </div>
        </div>
    </div>

    <div style="background:linear-gradient(135deg, #45b66f, #2d8a4e); border-radius:20px; padding:40px; color:white; text-align:center;">
        <h3 style="font-weight:900; margin-bottom:12px;">¡Gracias por ser parte del cambio!</h3>
        <p style="opacity:0.9; max-width:500px; margin:0 auto;">Tu compromiso con Foodshare ayuda a combatir el hambre y reducir el desperdicio alimentario en El Salvador.</p>
    </div>
</main>
@endsection
