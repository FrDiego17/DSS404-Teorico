<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/DSS404-TEORICO/resources/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Registro de Voluntarios</title>
    <!-- Bootstrap 5 y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<div class="page-container">
    <?php include '../../includes/headerong.php'; ?>

    <main class="main-content">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 section-header-vols">
                <h2 class="title-vols">Lista de Voluntarios</h2>
                <button class="btn-agregar-vols" onclick="abrirModalRegistro()">
                    Agregar <i class="fas fa-plus ms-2"></i>
                </button>
            </div>

            <div class="card card-table-container">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-header-custom">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>DUI</th>
                                <th>Género</th>
                                <th>Fecha Nacimiento</th>
                                <th>Email</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-muted">1</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">F</div>
                                        <span>Fulanito Pérez</span>
                                    </div>
                                </td>
                                <td><i class="fas fa-phone-alt me-2 text-success"></i> 2257-7777</td>
                                <td>0888000-0</td>
                                <td><span class="badge-gender">Masculino</span></td>
                                <td>20-12-2009</td>
                                <td>fulanito@gmail.com</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-action-edit"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="btn btn-action-delete"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include '../../includes/footer.php'; ?>
</div>

<!-- MODAL DE REGISTRO -->
<div id="modalRegistro" class="fs-modal-overlay">
    <div class="fs-modal-content registration-modal">
        <button class="fs-modal-close" onclick="cerrarModalRegistro()">&times;</button>
        
        <div class="registration-header">
            <div class="avatar-icon-container">
                <img src="https://cdn-icons-png.flaticon.com/512/6840/6840478.png" alt="Avatar" width="80">
            </div>
        </div>

        <div class="fs-modal-body">
            <form id="formRegistroVoluntario">
                <div class="mb-3">
                    <label class="form-label-custom">Nombre del Voluntario</label>
                    <input type="text" class="form-control fs-input" placeholder="Nombre Completo">
                </div>

                <div class="mb-3">
                    <label class="form-label-custom">Correo electrónico</label>
                    <input type="email" class="form-control fs-input" placeholder="Correo personal del voluntario">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">DUI</label>
                        <input type="text" class="form-control fs-input" placeholder="00000000-0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Teléfono</label>
                        <input type="text" class="form-control fs-input" placeholder="0000-0000">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Género</label>
                        <select class="form-select fs-input">
                            <option selected disabled>Seleccionar</option>
                            <option>Masculino</option>
                            <option>Femenino</option>
                            <option>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Fecha de Nacimiento</label>
                        <input type="date" class="form-control fs-input">
                    </div>
                </div>

                <button type="button" class="btn-fs-registrar-v" onclick="confirmarRegistro()">Registrar</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function abrirModalRegistro() {
        document.getElementById('modalRegistro').classList.add('active');
    }

    function cerrarModalRegistro() {
        document.getElementById('modalRegistro').classList.remove('active');
    }

    function confirmarRegistro() {
        alert("Voluntario registrado correctamente.");
        cerrarModalRegistro();
    }

    // Cerrar al hacer clic fuera del contenido
    window.onclick = function(event) {
        let modal = document.getElementById('modalRegistro');
        if (event.target == modal) {
            cerrarModalRegistro();
        }
    }
</script>
</body>
</html>