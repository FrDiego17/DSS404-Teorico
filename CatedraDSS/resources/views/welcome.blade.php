@extends('layouts.app')

@section('title', 'Conectando excedentes')

@section('content')

{{-- HERO --}}
<header class="hero-section"
        style="background-image: url('{{ asset('resources/img/index.png') }}');
               background-size: cover; background-position: center; background-repeat: no-repeat;
               min-height: 100vh; display: flex; align-items: center; position: relative;">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            {{-- Texto --}}
            <div class="col-lg-7 col-md-12 hero-content">
                <h1 class="hero-title mb-3">Alimentando comunidades que necesitan, reduciendo desperdicios.</h1>
                <p class="hero-subtitle">Juntos transformamos excedentes en oportunidades para quienes más lo necesitan.</p>
                <a href="{{ route('ong.registro') }}" class="btn btn-fs-primary btn-lg mt-3">¡Iniciemos!</a>
            </div>

            {{-- Círculos animados --}}
            <div class="col-lg-5 col-md-12 d-flex flex-column align-items-center align-items-lg-end mt-5 mt-lg-0">
                <div class="hero-icon-circle">
                    <i class="fa-solid fa-utensils"></i>
                    <span>Donar Excedentes</span>
                </div>
                <div class="hero-icon-circle">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    <span>Organización Social</span>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- CÓMO FUNCIONA --}}
<section class="how-it-works-section bg-light">
    <div class="container text-center">
        <h2 class="section-title mb-5">¿Cómo Funciona Foodshare?</h2>
        <div class="row g-5 justify-content-center">

            <div class="col-md-4 col-sm-12 d-flex">
                <div class="card h-100 fs-card w-100 border-0 shadow">
                    <div class="text-center mt-5">
                        <div class="card-icon-circle mx-auto">
                            <i class="fa-solid fa-file-pen fs-1 text-success"></i>
                        </div>
                    </div>
                    <div class="card-body fs-card-body text-center px-4 pb-5">
                        <h3 class="fs-card-number-title mb-3">1. Publica tu excedente</h3>
                        <p class="fs-card-text card-text mb-0">Comidas y bebidas cercanas a caducar o que ya no se pueden guardar.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 d-flex">
                <div class="card h-100 fs-card w-100 border-0 shadow">
                    <div class="text-center mt-5">
                        <div class="card-icon-circle mx-auto">
                            <i class="fa-solid fa-calendar-check fs-1 text-success"></i>
                        </div>
                    </div>
                    <div class="card-body fs-card-body text-center px-4 pb-5">
                        <h3 class="fs-card-number-title mb-3">2. Reserva de ONG</h3>
                        <p class="fs-card-text card-text mb-0">Organizaciones sociales descubren y reservan tu publicación.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 d-flex">
                <div class="card h-100 fs-card w-100 border-0 shadow">
                    <div class="text-center mt-5">
                        <div class="card-icon-circle mx-auto">
                            <i class="fa-solid fa-truck-ramp-box fs-1 text-success"></i>
                        </div>
                    </div>
                    <div class="card-body fs-card-body text-center px-4 pb-5">
                        <h3 class="fs-card-number-title mb-3">3. Alimenta y transforma</h3>
                        <p class="fs-card-text card-text mb-0">Se recogerá el alimento y se donará a la comunidad de personas necesitadas.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
