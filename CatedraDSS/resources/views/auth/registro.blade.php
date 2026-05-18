@extends('layouts.app')

@section('title', 'Crear Cuenta - Foodshare')

@section('content')

<style>
    .registro-selector {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f0faf4 0%, #e8f5e9 50%, #f3f8ff 100%);
        padding: 80px 0 40px;
    }

    .selector-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .selector-header .logo-wrap img {
        height: 60px;
        margin-bottom: 20px;
    }

    .selector-header h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1a2a32;
        margin-bottom: 10px;
    }

    .selector-header p {
        color: #607d8b;
        font-size: 1.05rem;
        max-width: 480px;
        margin: 0 auto;
    }

    .type-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        max-width: 860px;
        margin: 0 auto;
    }

    .type-card {
        background: #fff;
        border-radius: 24px;
        padding: 48px 36px 40px;
        text-align: center;
        box-shadow: 0 8px 40px rgba(0,0,0,0.08);
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .type-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 5px;
        background: var(--card-color, #45b66f);
        border-radius: 24px 24px 0 0;
    }

    .type-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.14);
        border-color: var(--card-color, #45b66f);
        text-decoration: none;
    }

    .type-card.ong-card {
        --card-color: #45b66f;
    }

    .type-card.comercio-card {
        --card-color: #1976d2;
    }

    .card-icon-wrap {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
        font-size: 2.2rem;
    }

    .ong-card .card-icon-wrap {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        color: #2e7d32;
    }

    .comercio-card .card-icon-wrap {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #1565c0;
    }

    .type-card h3 {
        font-size: 1.45rem;
        font-weight: 800;
        color: #1a2a32;
        margin-bottom: 12px;
    }

    .type-card p {
        color: #607d8b;
        font-size: 0.92rem;
        line-height: 1.6;
        flex-grow: 1;
        margin-bottom: 28px;
    }

    .card-benefits {
        list-style: none;
        padding: 0;
        margin: 0 0 28px;
        text-align: left;
        width: 100%;
    }

    .card-benefits li {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.88rem;
        color: #455a64;
        padding: 6px 0;
        border-bottom: 1px solid #f0f4f8;
    }

    .card-benefits li:last-child { border-bottom: none; }

    .card-benefits li i {
        font-size: 0.8rem;
        width: 18px;
        text-align: center;
    }

    .ong-card .card-benefits li i { color: #45b66f; }
    .comercio-card .card-benefits li i { color: #1976d2; }

    .btn-select-type {
        display: block;
        width: 100%;
        padding: 13px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.97rem;
        letter-spacing: 0.3px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .ong-card .btn-select-type {
        background: linear-gradient(135deg, #45b66f, #2e7d32);
        color: white;
    }

    .ong-card .btn-select-type:hover {
        background: linear-gradient(135deg, #3ca862, #256427);
        transform: scale(1.02);
    }

    .comercio-card .btn-select-type {
        background: linear-gradient(135deg, #1976d2, #1565c0);
        color: white;
    }

    .comercio-card .btn-select-type:hover {
        background: linear-gradient(135deg, #1565c0, #0d47a1);
        transform: scale(1.02);
    }

    .back-login {
        text-align: center;
        margin-top: 30px;
        color: #607d8b;
        font-size: 0.92rem;
    }

    .back-login a {
        color: #45b66f;
        font-weight: 600;
        text-decoration: none;
    }

    .back-login a:hover { text-decoration: underline; }

    @media (max-width: 640px) {
        .type-cards { grid-template-columns: 1fr; }
        .selector-header h1 { font-size: 1.7rem; }
    }
</style>

<div class="registro-selector">
    <div class="container">

        <div class="selector-header">
            <div class="logo-wrap">
                <img src="{{ asset('resources/img/logofooter.png') }}"
                     alt="Foodshare" onerror="this.style.display='none'">
            </div>
            <h1>Crear una cuenta</h1>
            <p>Elige el tipo de cuenta que mejor describe tu organización para comenzar en Foodshare.</p>
        </div>

        <div class="type-cards">

            <a href="{{ route('ong.registro') }}" class="type-card ong-card">
                <div class="card-icon-wrap">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3>Organización Social</h3>
                <p>Soy una ONG, fundación o comedor social que quiere recibir excedentes de alimentos.</p>
                <ul class="card-benefits">
                    <li><i class="fas fa-check-circle"></i> Recibe excedentes de alimentos</li>
                    <li><i class="fas fa-check-circle"></i> Conecta con comercios locales</li>
                    <li><i class="fas fa-check-circle"></i> Gestiona reservas y entregas</li>
                    <li><i class="fas fa-check-circle"></i> Registro con verificación</li>
                </ul>
                <span class="btn-select-type">Registrar como ONG <i class="fas fa-arrow-right ms-2"></i></span>
            </a>

            <a href="{{ route('comercio.registro') }}" class="type-card comercio-card">
                <div class="card-icon-wrap">
                    <i class="fas fa-store"></i>
                </div>
                <h3>Comercio</h3>
                <p>Soy un restaurante, supermercado o negocio de alimentos que desea donar sus excedentes.</p>
                <ul class="card-benefits">
                    <li><i class="fas fa-check-circle"></i> Publica tus excedentes fácilmente</li>
                    <li><i class="fas fa-check-circle"></i> Reduce el desperdicio alimentario</li>
                    <li><i class="fas fa-check-circle"></i> Mide tu impacto social</li>
                    <li><i class="fas fa-check-circle"></i> Conecta con ONGs verificadas</li>
                </ul>
                <span class="btn-select-type">Registrar como Comercio <i class="fas fa-arrow-right ms-2"></i></span>
            </a>

        </div>

        <div class="back-login">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
        </div>

    </div>
</div>

@endsection
