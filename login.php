<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/DSS404-TEORICO/resources/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #bffcd0 0%, #dcdcdc 100%);
            min-height: 100vh;
        }

        
    </style>
</head>
<body>

<div class="login-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card login-card">
                    <div class="row g-0">
                        <div class="col-md-6 login-image">
                            <div class="login-image-overlay">
                                <div class="login-image-content">
                                    <img src="../DSS404-Teorico/resources/img/logofooter.png" alt="Foodshare" class="login-logo" onerror="this.style.display='none'">
                                    <h2>¡Bienvenido de vuelta!</h2>
                                    <p>Inicia sesión en tu cuenta para gestionar tu organización, recibir excedentes de alimentos y continuar ayudando a quienes más lo necesitan.</p>
                                    <div class="mt-4">
                                        <i class="fa-solid fa-hand-holding-heart fa-2x me-3"></i>
                                        <i class="fa-solid fa-people-arrows fa-2x me-3"></i>
                                        <i class="fa-solid fa-apple-alt fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="login-form">
                                <h3 class="text-center">Iniciar Sesión</h3>
                                <p class="text-center text-muted mb-4">Accede a tu cuenta de Foodshare</p>
                                
                                <!-- Alerta para mensajes -->
                                <div id="alertMessage" class="custom-alert"></div>
                                
                                <form id="loginForm">
                                    <div class="mb-3">
                                        <label class="form-label">Correo Electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" placeholder="organizacion@ejemplo.com" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" class="form-control" id="password" placeholder="••••••••" required>
                                            <button class="input-group-text" type="button" id="togglePassword" style="cursor: pointer; border-left: none; background-color: #f8f9fa;">
                                                <i class="fa-regular fa-eye-slash" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end mb-4">
                                        <a href="#" class="forgot-link" id="forgotPassword">¿Olvidaste tu contraseña?</a>
                                    </div>
                                    
                                    <button type="submit" class="btn-login">Iniciar Sesión <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle para mostrar/ocultar contraseña
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'text') {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    });

    // Función para mostrar alerta
    function showAlert(message, isError = true) {
        const alertDiv = document.getElementById('alertMessage');
        alertDiv.textContent = message;
        alertDiv.style.display = 'block';
        
        if (isError) {
            alertDiv.style.backgroundColor = '#fee2e2';
            alertDiv.style.color = '#dc2626';
            alertDiv.style.border = '1px solid #fecaca';
        } else {
            alertDiv.style.backgroundColor = '#dcfce7';
            alertDiv.style.color = '#16a34a';
            alertDiv.style.border = '1px solid #bbf7d0';
        }
        
        // Ocultar después de 4 segundos
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 4000);
    }

    // Validar email
    function isValidEmail(email) {
        const re = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
        return re.test(email);
    }

    // Manejar el inicio de sesión
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        
        // Validaciones
        if (!email) {
            showAlert('Por favor ingrese su correo electrónico', true);
            document.getElementById('email').focus();
            return;
        }
        
        if (!isValidEmail(email)) {
            showAlert('Por favor ingrese un correo electrónico válido', true);
            document.getElementById('email').focus();
            return;
        }
        
        if (!password) {
            showAlert('Por favor ingrese su contraseña', true);
            document.getElementById('password').focus();
            return;
        }
        
        if (password.length < 8) {
            showAlert('La contraseña debe tener al menos 8 caracteres', true);
            document.getElementById('password').focus();
            return;
        }
    });
</script>

</body>
</html>