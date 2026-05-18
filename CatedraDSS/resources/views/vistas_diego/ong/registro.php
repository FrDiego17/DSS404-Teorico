<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/DSS404-TEORICO/resources/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Registro de ONG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<div class="register-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card register-card">
                    <div class="row g-0">
                        <!-- Columna izquierda con imagen -->
                        <div class="col-md-6 register-image">
                            <div class="register-image-overlay">
                                <div class="register-image-content">
                                    <img src="../../resources/img/logofooter.png" alt="Foodshare" class="register-logo" onerror="this.style.display='none'">
                                    <h2>¡Bienvenido a Foodshare!</h2>
                                    <p>Regístrate como Organización Social y comienza a recibir excedentes de alimentos para ayudar a quienes más lo necesitan.</p>
                                    <div class="mt-4">
                                        <i class="fa-solid fa-hand-holding-heart fa-2x me-3"></i>
                                        <i class="fa-solid fa-people-arrows fa-2x me-3"></i>
                                        <i class="fa-solid fa-apple-alt fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Columna derecha con formulario -->
                        <div class="col-md-6">
                            <div class="register-form">
                                <!-- Indicador de pasos -->
                                <div class="step-indicator">
                                    <div class="step active" id="step1-indicator">1</div>
                                    <div class="step-line" id="line1"></div>
                                    <div class="step" id="step2-indicator">2</div>
                                </div>
                                
                                <h3 class="text-center">Registro y Verificación de ONG</h3>
                                <p class="text-center text-muted mb-4">Completa tus datos para comenzar</p>
                                
                                <!-- PASO 1 -->
                                <div id="step1" class="form-section active-section">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre de la Organización</label>
                                        <input type="text" class="form-control" id="nombre" placeholder="ej. Banco de Alimentos de El Salvador">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Correo Electrónico</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" placeholder="organizacion@ejemplo.com">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                            <input type="password" class="form-control" id="password" placeholder="......">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">NIT</label>
                                        <input type="text" class="form-control" id="nit" placeholder="00000000000000">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label">No. Registro de Asociaciones y Fundaciones</label>
                                        <input type="text" class="form-control" id="registro" placeholder="0000">
                                    </div>
                                    
                                    <button type="button" class="btn-register-next" onclick="nextStep()">Siguiente <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                    
                                    <p class="text-center mt-4 mb-0">
                                        ¿Ya tienes una cuenta? <a href="../../login.php" class="register-link">Inicia sesión</a>
                                    </p>
                                </div>
                                
                                <!-- PASO 2 -->
                                <div id="step2" class="form-section">
                                    <div class="mb-3">
                                        <label class="form-label">Departamento</label>
                                        <select class="form-control" id="departamento">
                                            <option value="">Selecciona un departamento</option>
                                            <option value="ahuachapan">Ahuachapán</option>
                                            <option value="santa-ana">Santa Ana</option>
                                            <option value="sononate">Sonsonate</option>
                                            <option value="chalatenango">Chalatenango</option>
                                            <option value="la-libertad">La Libertad</option>
                                            <option value="san-salvador">San Salvador</option>
                                            <option value="cuscatlan">Cuscatlán</option>
                                            <option value="la-paz">La Paz</option>
                                            <option value="cabanas">Cabañas</option>
                                            <option value="san-vicente">San Vicente</option>
                                            <option value="usulutan">Usulután</option>
                                            <option value="san-miguel">San Miguel</option>
                                            <option value="morazan">Morazán</option>
                                            <option value="la-union">La Unión</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Dirección de la Sede</label>
                                        <input type="text" class="form-control" id="direccion" placeholder="Calle, Número de Local y Ciudad">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Capacidad de Logística Aproximada</label>
                                        <input type="number" class="form-control" id="capacidad" placeholder="Número de personas que pueden recoger excedentes">
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Horario de Inicio</label>
                                            <input type="time" class="form-control" id="hora_inicio">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Horario de Cierre</label>
                                            <input type="time" class="form-control" id="hora_cierre">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn-register-back" onclick="prevStep()"><i class="fa-solid fa-arrow-left me-2"></i> Anterior</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn-register-submit" onclick="registrar()">Registrar <i class="fa-solid fa-check ms-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function nextStep() {
        // Validar paso 1
        const nombre = document.getElementById('nombre').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const nit = document.getElementById('nit').value;
        const registro = document.getElementById('registro').value;
        
        if(!nombre || !email || !password || !nit || !registro) {
            alert('Por favor completa todos los campos');
            return;
        }
        
        if(!email.includes('@')) {
            alert('Por favor ingresa un correo válido');
            return;
        }
        
        if(password.length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres');
            return;
        }
        
        // Cambiar vistas
        document.getElementById('step1').classList.remove('active-section');
        document.getElementById('step2').classList.add('active-section');
        
        // Actualizar indicadores
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
    
    function registrar() {
        // Validar paso 2
        const departamento = document.getElementById('departamento').value;
        const direccion = document.getElementById('direccion').value;
        const capacidad = document.getElementById('capacidad').value;
        const horaInicio = document.getElementById('hora_inicio').value;
        const horaCierre = document.getElementById('hora_cierre').value;
        
        if(!departamento || !direccion || !capacidad || !horaInicio || !horaCierre) {
            alert('Por favor completa todos los campos');
            return;
        }
        
        // Recoger todos los datos
        const datos = {
            nombre: document.getElementById('nombre').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            nit: document.getElementById('nit').value,
            registro_asociacion: document.getElementById('registro').value,
            departamento: departamento,
            direccion: direccion,
            capacidad: capacidad,
            hora_inicio: horaInicio,
            hora_cierre: horaCierre
        };
        
        console.log('Datos a registrar:', datos);
        alert('Registro exitoso! (Demo)');
        
        // Aquí puedes enviar los datos a tu servidor
        // fetch('../../index.php?controller=Ong&action=store', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify(datos)
        // })
    }
</script>

</body>
</html>