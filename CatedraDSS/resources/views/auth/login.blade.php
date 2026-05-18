@extends('layouts.app')

@section('title', 'Inicio de Sesión')

@section('content')

<div class="login-container" style="min-height: 100vh; display: flex; align-items: center; padding-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card login-card">
                    <div class="row g-0">

                        {{-- LADO IZQUIERDO (imagen/branding) --}}
                        <div class="col-md-6 login-image">
                            <div class="login-image-overlay">
                                <div class="login-image-content">
                                    <img src="{{ asset('resources/img/logofooter.png') }}"
                                         alt="Foodshare" class="login-logo"
                                         onerror="this.style.display='none'">
                                    <h2>¡Bienvenido de vuelta!</h2>
                                    <p>Inicia sesión en tu cuenta para gestionar tu organización,
                                       recibir excedentes de alimentos y continuar ayudando a
                                       quienes más lo necesitan.</p>
                                    <div class="mt-4">
                                        <i class="fa-solid fa-hand-holding-heart fa-2x me-3"></i>
                                        <i class="fa-solid fa-people-arrows fa-2x me-3"></i>
                                        <i class="fa-solid fa-apple-alt fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- LADO DERECHO (formulario) --}}
                        <div class="col-md-6">
                            <div class="login-form">
                                <h3 class="text-center">Iniciar Sesión</h3>
                                <p class="text-center text-muted mb-4">Accede a tu cuenta de Foodshare</p>

                                {{-- Mensajes de éxito (ej. tras registro) --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                {{-- Errores de validación --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $errors->first() }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Correo Electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   id="email" name="email"
                                                   placeholder="organizacion@ejemplo.com"
                                                   value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" class="form-control"
                                                   id="password" name="password"
                                                   placeholder="••••••••" required>
                                            <button class="input-group-text" type="button" id="togglePassword"
                                                    style="cursor:pointer; border-left:none; background-color:#f8f9fa;">
                                                <i class="fa-regular fa-eye-slash" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="text-end mb-4">
                                        <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                                    </div>

                                    <button type="submit" class="btn-login">
                                        Iniciar Sesión <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </button>

                                    <p class="text-center mt-4 mb-0">
                                        ¿No tienes cuenta?
                                        <a href="{{ route('ong.registro') }}" class="register-link">Registra tu ONG</a>
                                    </p>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    //  Muestra o oculta la contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const pwd = document.getElementById('password');
        const eye = document.getElementById('eyeIcon');
        const isPassword = pwd.getAttribute('type') === 'password';
        pwd.setAttribute('type', isPassword ? 'text' : 'password');
        eye.classList.toggle('fa-eye-slash', !isPassword);
        eye.classList.toggle('fa-eye', isPassword);
    });
</script>
@endpush
