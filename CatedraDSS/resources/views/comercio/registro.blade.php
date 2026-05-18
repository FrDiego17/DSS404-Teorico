@extends('layouts.app')

@section('title', 'Registro de Comercio')

@section('content')

<div class="register-container" style="min-height: 100vh; display: flex; align-items: center; background: linear-gradient(135deg,#eaf1fb 0%,#dce8f8 50%,#f3f8ff 100%); padding-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card register-card">
                    <div class="row g-0">

                        <div class="col-md-6 register-image"
                             style="background: linear-gradient(180deg, #1565c0 0%, #0d47a1 100%);">
                            <div class="register-image-overlay">
                                <div class="register-image-content">
                                    <img src="{{ asset('resources/img/logofooter.png') }}"
                                         alt="Foodshare" class="register-logo"
                                         onerror="this.style.display='none'">
                                    <h2>Únete como Comercio</h2>
                                    <p>Registra tu negocio en Foodshare y comienza a donar tus
                                       excedentes de alimentos a organizaciones que los necesitan.</p>
                                    <div class="mt-4">
                                        <i class="fa-solid fa-store fa-2x me-3"></i>
                                        <i class="fa-solid fa-hand-holding-heart fa-2x me-3"></i>
                                        <i class="fa-solid fa-leaf fa-2x"></i>
                                    </div>
                                    <div class="mt-4 p-3" style="background:rgba(255,255,255,0.12); border-radius:12px;">
                                        <small style="opacity:0.9;">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Tu cuenta sera revisada por nuestro equipo antes de ser activada.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="register-form">

                                <div class="step-indicator">
                                    <div class="step active" id="step1-indicator">1</div>
                                    <div class="step-line" id="line1"></div>
                                    <div class="step" id="step2-indicator">2</div>
                                </div>

                                <h3 class="text-center">Registro de Comercio</h3>
                                <p class="text-center text-muted mb-4">Completa los datos de tu negocio</p>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form id="formRegistroCom" method="POST" action="{{ route('comercio.registro.post') }}">
                                    @csrf

                                    <div id="step1" class="form-section active-section">

                                        <div class="mb-3">
                                            <label class="form-label">Nombre Comercial</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-store"></i></span>
                                                <input type="text" class="form-control" id="nombre_comercial"
                                                       name="nombre_comercial" placeholder="Ej. Supermercado La Colonia"
                                                       value="{{ old('nombre_comercial') }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nombre Registrado (Legal)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                                <input type="text" class="form-control" id="nombre_registrado"
                                                       name="nombre_registrado" placeholder="Ej. Colonia S.A. de C.V."
                                                       value="{{ old('nombre_registrado') }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Correo Electrónico</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                                <input type="email" class="form-control" id="email_com"
                                                       name="email" placeholder="negocio@ejemplo.com"
                                                       value="{{ old('email') }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" class="form-control" id="password_com"
                                                       name="password" placeholder="Mínimo 8 caracteres">
                                                <button class="input-group-text" type="button" id="togglePwdCom"
                                                        style="cursor:pointer; border-left:none; background:#f8f9fa;">
                                                    <i class="fa-regular fa-eye-slash" id="eyeIconCom"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">La contraseña debe tener al menos <strong>8 caracteres</strong></small>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Confirmar Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" class="form-control" id="password_confirmation_com"
                                                       name="password_confirmation" placeholder="Repite la contraseña">
                                            </div>
                                        </div>

                                        <button type="button" class="btn-register-next" onclick="nextStepCom()"
                                                style="background:linear-gradient(135deg,#1976d2,#1565c0);">
                                            Siguiente <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>

                                        <p class="text-center mt-4 mb-0">
                                            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="register-link">Inicia sesión</a>
                                        </p>
                                        <p class="text-center mt-2 mb-0" style="font-size:0.88rem;">
                                            <a href="{{ route('auth.registro') }}" style="color:#607d8b;">
                                                <i class="fas fa-arrow-left me-1"></i> Volver a elegir tipo de cuenta
                                            </a>
                                        </p>
                                    </div>

                                    <div id="step2_com" class="form-section">

                                        <div class="mb-3">
                                            <label class="form-label">NIT del Comercio</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                <input type="text" class="form-control" id="nit_com"
                                                       name="nit" placeholder="00000000000000"
                                                       value="{{ old('nit') }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">No. Autorización Sanitaria</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                                                <input type="text" class="form-control" id="sanitaria_com"
                                                       name="no_autorizacion_sanitaria"
                                                       placeholder="Número de autorización sanitaria"
                                                       value="{{ old('no_autorizacion_sanitaria') }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Teléfono de Contacto</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="text" class="form-control" id="telefono_com"
                                                       name="telefono" placeholder="7000-0000"
                                                       value="{{ old('telefono') }}">
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Dirección</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                <input type="text" class="form-control" id="direccion_com"
                                                       name="direccion"
                                                       placeholder="Calle, número, ciudad"
                                                       value="{{ old('direccion') }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" class="btn-register-back" onclick="prevStepCom()">
                                                    <i class="fa-solid fa-arrow-left me-2"></i> Anterior
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" class="btn-register-submit"
                                                        style="background:linear-gradient(135deg,#1976d2,#1565c0);">
                                                    Registrar <i class="fa-solid fa-check ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

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
    // Mostrar/Ocultar contraseña
    document.getElementById('togglePwdCom').addEventListener('click', function () {
        const pwd = document.getElementById('password_com');
        const eye = document.getElementById('eyeIconCom');
        const isPassword = pwd.getAttribute('type') === 'password';
        pwd.setAttribute('type', isPassword ? 'text' : 'password');
        eye.classList.toggle('fa-eye-slash', !isPassword);
        eye.classList.toggle('fa-eye', isPassword);
    });

    // Si hay errores del paso 2, ir al paso 2
    const hayErrorPaso2Com = {{ $errors->hasAny(['nit','no_autorizacion_sanitaria','telefono','direccion']) ? 'true' : 'false' }};
    if (hayErrorPaso2Com) { irAPaso2Com(); }

    function nextStepCom() {
        const nombre_c = document.getElementById('nombre_comercial').value.trim();
        const nombre_r = document.getElementById('nombre_registrado').value.trim();
        const email    = document.getElementById('email_com').value.trim();
        const password = document.getElementById('password_com').value;
        const confirm  = document.getElementById('password_confirmation_com').value;

        if (!nombre_c || !nombre_r || !email || !password || !confirm) {
            alert('Por favor completa todos los campos del paso 1.');
            return;
        }
        if (!email.includes('@')) {
            alert('Por favor ingresa un correo válido.');
            return;
        }
        if (password.length < 8) {
            alert('La contraseña debe tener al menos 8 caracteres.');
            return;
        }
        if (password !== confirm) {
            alert('Las contraseñas no coinciden.');
            return;
        }
        irAPaso2Com();
    }

    function irAPaso2Com() {
        document.getElementById('step1').classList.remove('active-section');
        document.getElementById('step2_com').classList.add('active-section');
        document.getElementById('step1-indicator').classList.remove('active');
        document.getElementById('step1-indicator').classList.add('completed');
        document.getElementById('step2-indicator').classList.add('active');
        document.getElementById('line1').classList.add('active');
    }

    function prevStepCom() {
        document.getElementById('step2_com').classList.remove('active-section');
        document.getElementById('step1').classList.add('active-section');
        document.getElementById('step2-indicator').classList.remove('active');
        document.getElementById('step1-indicator').classList.remove('completed');
        document.getElementById('step1-indicator').classList.add('active');
        document.getElementById('line1').classList.remove('active');
    }
</script>
@endpush
