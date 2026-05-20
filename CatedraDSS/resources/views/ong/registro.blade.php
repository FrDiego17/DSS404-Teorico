@extends('layouts.app')

@section('title', 'Registro de ONG')

@section('content')

<div class="register-container" style="min-height: 100vh; display: flex; align-items: center; padding-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card register-card">
                    <div class="row g-0">

                        <div class="col-md-6 register-image">
                            <div class="register-image-overlay">
                                <div class="register-image-content">
                                    <img src="{{ asset('resources/img/logofooter.png') }}"
                                         alt="Foodshare" class="register-logo"
                                         onerror="this.style.display='none'">
                                    <h2>¡Bienvenido a Foodshare!</h2>
                                    <p>Regístrate como Organización Social y comienza a recibir
                                       excedentes de alimentos para ayudar a quienes más lo necesitan.</p>
                                    <div class="mt-4">
                                        <i class="fa-solid fa-hand-holding-heart fa-2x me-3"></i>
                                        <i class="fa-solid fa-people-arrows fa-2x me-3"></i>
                                        <i class="fa-solid fa-apple-alt fa-2x"></i>
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

                                <h3 class="text-center">Registro y Verificación de ONG</h3>
                                <p class="text-center text-muted mb-4">Completa tus datos para comenzar</p>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form id="formRegistroOng" method="POST" action="{{ route('ong.registro.post') }}">
                                    @csrf

                                    <div id="step1" class="form-section active-section">
                                        <div class="mb-3">
                                            <label class="form-label">Nombre de la Organización</label>
                                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"
                                                   placeholder="ej. Banco de Alimentos de El Salvador"
                                                   value="{{ old('nombre') }}">
                                            @error('nombre')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Correo Electrónico</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                                       placeholder="organizacion@ejemplo.com"
                                                       value="{{ old('email') }}">
                                            </div>
                                            @error('email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                                       placeholder="Mínimo 8 caracteres">
                                                <button class="input-group-text" type="button" id="togglePwdOng"
                                                        style="cursor:pointer; border-left:none; background:#f8f9fa;">
                                                    <i class="fa-regular fa-eye-slash" id="eyeIconOng"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted d-block mt-1">La contraseña debe tener al menos <strong>8 caracteres</strong></small>
                                            @error('password')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Confirmar Contraseña</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                       name="password_confirmation" placeholder="Repite la contraseña">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">NIT</label>
                                            <input type="text" class="form-control @error('nit') is-invalid @enderror" id="nit" name="nit"
                                                   placeholder="00000000000000" value="{{ old('nit') }}">
                                            @error('nit')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">No. Registro de Asociaciones y Fundaciones</label>
                                            <input type="text" class="form-control @error('registro_asociacion') is-invalid @enderror" id="registro" name="registro_asociacion"
                                                   placeholder="0000" value="{{ old('registro_asociacion') }}">
                                            @error('registro_asociacion')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="button" class="btn-register-next" onclick="nextStep()">
                                            Siguiente <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </button>

                                        <p class="text-center mt-4 mb-0">
                                            ¿Ya tienes una cuenta?
                                            <a href="{{ route('login') }}" class="register-link">Inicia sesión</a>
                                        </p>
                                    </div>

                                    <div id="step2" class="form-section">
                                        <div class="mb-3">
                                            <label class="form-label">Departamento</label>
                                            <select class="form-control @error('departamento') is-invalid @enderror" id="departamento" name="departamento">
                                                <option value="">Selecciona un departamento</option>
                                                @foreach (['Ahuachapán','Santa Ana','Sonsonate','Chalatenango','La Libertad','San Salvador','Cuscatlán','La Paz','Cabañas','San Vicente','Usulután','San Miguel','Morazán','La Unión'] as $dep)
                                                    <option value="{{ $dep }}" {{ old('departamento') == $dep ? 'selected' : '' }}>{{ $dep }}</option>
                                                @endforeach
                                            </select>
                                            @error('departamento')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Dirección de la Sede</label>
                                            <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion"
                                                   placeholder="Calle, Número de Local y Ciudad"
                                                   value="{{ old('direccion') }}">
                                            @error('direccion')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Capacidad de Logística Aproximada</label>
                                            <input type="number" class="form-control @error('capacidad') is-invalid @enderror" id="capacidad" name="capacidad"
                                                   placeholder="Número de personas que pueden recoger excedentes"
                                                   value="{{ old('capacidad') }}">
                                            @error('capacidad')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Horario de Inicio</label>
                                                <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" id="hora_inicio"
                                                       name="hora_inicio" value="{{ old('hora_inicio') }}">
                                                @error('hora_inicio')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Horario de Cierre</label>
                                                <input type="time" class="form-control @error('hora_cierre') is-invalid @enderror" id="hora_cierre"
                                                       name="hora_cierre" value="{{ old('hora_cierre') }}">
                                                @error('hora_cierre')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" class="btn-register-back" onclick="prevStep()">
                                                    <i class="fa-solid fa-arrow-left me-2"></i> Anterior
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" class="btn-register-submit">
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
    // Formato automático para el NIT 
    document.getElementById('nit').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); // Elimina todo lo que no sea dígito
        let formattedValue = '';

        if (value.length > 0) {
            formattedValue = value.substring(0, 4);
        }
        if (value.length > 4) {
            formattedValue += '-' + value.substring(4, 10);
        }
        if (value.length > 10) {
            formattedValue += '-' + value.substring(10, 13);
        }
        if (value.length > 13) {
            formattedValue += '-' + value.substring(13, 14);
        }

        e.target.value = formattedValue;
    });

    // Mostrar/Ocultar contraseña
    document.getElementById('togglePwdOng').addEventListener('click', function () {
        const pwd = document.getElementById('password');
        const eye = document.getElementById('eyeIconOng');
        const isPassword = pwd.getAttribute('type') === 'password';
        pwd.setAttribute('type', isPassword ? 'text' : 'password');
        eye.classList.toggle('fa-eye-slash', !isPassword);
        eye.classList.toggle('fa-eye', isPassword);
    });

    // Si hay errores de servidor, muestra paso 2 si los campos son del paso 2
    const hayErrorPaso2 = {{ $errors->hasAny(['departamento','direccion','capacidad','hora_inicio','hora_cierre']) ? 'true' : 'false' }};
    if (hayErrorPaso2) { 
        // Esperamos a que cargue el DOM por si acaso
        window.addEventListener('DOMContentLoaded', () => { irAPaso2(); });
    }

    function nextStep() {
        const nombre   = document.getElementById('nombre').value.trim();
        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirm  = document.getElementById('password_confirmation').value;
        const nit      = document.getElementById('nit').value.trim();
        const registro = document.getElementById('registro').value.trim();

        // Validar campos vacíos
        if (!nombre || !email || !password || !confirm || !nit || !registro) {
            alert('Por favor completa todos los campos del paso 1.');
            return;
        }
        
        // Validar estructura de correo básica
        if (!email.includes('@')) {
            alert('Por favor ingresa un correo válido.');
            return;
        }
        
        // Validar longitud de contraseña (Corregido)
        if (password.length < 8) {
            alert('La contraseña debe tener al menos 8 caracteres.');
            return;
        }
        
        // Validar que coincidan
        if (password !== confirm) {
            alert('Las contraseñas no coinciden.');
            return;
        }
        
        // Si todo está bien, avanza
        irAPaso2();
    } // <-- Aquí se cierra correctamente nextStep

    function irAPaso2() {
        document.getElementById('step1').classList.remove('active-section');
        document.getElementById('step2').classList.add('active-section');
        document.getElementById('step1-indicator').classList.remove('active');
        document.getElementById('step1-indicator').classList.add('completed');
        document.getElementById('step2-indicator').classList.add('active');
        document.getElementById('line1').classList.add('active');
    }

    function prevStep() {
        document.getElementById('step2').classList.remove('active-section');
        document.getElementById('step1').classList.add('active-section');
        document.getElementById('step2-indicator').classList.remove('active');
        document.getElementById('step1-indicator').classList.remove('completed');
        document.getElementById('step1-indicator').classList.add('active');
        document.getElementById('line1').classList.remove('active');
    }
</script>
@endpush