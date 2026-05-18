<?php
// views/admin/comercios-admin.php

$comercios = [
    ['id' => 1, 'nombre' => 'Comedor Esperanza', 'cnr' => 'COM-001', 'correo' => 'esperanza@foodshare.sv', 'autorizacion' => 'AS-20210045', 'nit' => '0614-010190-101-5', 'departamento' => 'San Salvador', 'distrito' => 'Soyapango', 'capacidad' => 150],
    ['id' => 2, 'nombre' => 'Panadería La Vega', 'cnr' => 'COM-002', 'correo' => 'vega@foodshare.sv', 'autorizacion' => 'AS-20190023', 'nit' => '0614-020280-201-6', 'departamento' => 'La Libertad', 'distrito' => 'Santa Tecla', 'capacidad' => 80],
    ['id' => 3, 'nombre' => 'Supermercado Don Pepe', 'cnr' => 'COM-003', 'correo' => 'donpepe@foodshare.sv', 'autorizacion' => 'AS-20220067', 'nit' => '0614-030370-301-7', 'departamento' => 'Cuscatlán', 'distrito' => 'Suchitoto', 'capacidad' => 400],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Comercios Admin</title>
    <style>
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; transform: translateX(20px); } }
    </style>
</head>
<body>

<?php include '../../includes/headeradmin.php'; ?>

<main class="container" style="padding-top: 20px; min-height: 75vh; padding-bottom: 60px;">

    <h2 class="admin-section-title mb-4">Lista de Comercios</h2>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Comercial</th>
                    <th>CNR</th>
                    <th>Correo</th>
                    <th>Autorización Sanitaria</th>
                    <th>NIT</th>
                    <th>Departamento</th>
                    <th>Distrito</th>
                    <th>Capacidad Log</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="comercioTableBody">
                <?php foreach ($comercios as $com): ?>
                    <tr data-id="<?php echo $com['id']; ?>"
                        data-nombre="<?php echo htmlspecialchars($com['nombre']); ?>"
                        data-correo="<?php echo htmlspecialchars($com['correo']); ?>"
                        data-nit="<?php echo htmlspecialchars($com['nit']); ?>"
                        data-departamento="<?php echo htmlspecialchars($com['departamento']); ?>">
                        <td><?php echo $com['id']; ?></td>
                        <td><?php echo htmlspecialchars($com['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($com['cnr']); ?></td>
                        <td><?php echo htmlspecialchars($com['correo']); ?></td>
                        <td><?php echo htmlspecialchars($com['autorizacion']); ?></td>
                        <td><?php echo htmlspecialchars($com['nit']); ?></td>
                        <td><?php echo htmlspecialchars($com['departamento']); ?></td>
                        <td><?php echo htmlspecialchars($com['distrito']); ?></td>
                        <td><?php echo $com['capacidad']; ?> kg</td>
                        <td>
                            <button class="btn-action delete btn-eliminar" title="Eliminar comercio">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<?php include '../../includes/footer.php'; ?>

<!-- MODAL: Confirmar Eliminación Comercio -->
<div class="fs-modal-overlay" id="modalElimComercio">
    <div class="fs-modal-content" style="max-width: 420px; text-align: center;">
        <button class="fs-modal-close" onclick="cerrarModal('modalElimComercio')">&times;</button>
        <div style="font-size: 56px; margin-bottom: 16px;">🗑️</div>
        <h4 style="font-weight:800; color:#e53e3e; margin-bottom:8px;">Eliminar Comercio</h4>
        <p style="color:#718096; font-size:14px; margin-bottom: 8px;">
            Estás a punto de eliminar a <strong id="modalElimComNombre"></strong>.
        </p>
        <p style="color:#718096; font-size:13px; margin-bottom:20px;">
            Correo registrado: <span id="modalElimComCorreo" style="color:#45b66f;"></span>
        </p>
        <div class="d-flex gap-2">
            <button class="btn-fs-modal-submit" style="background:#e2e8f0; color:#333;" onclick="cerrarModal('modalElimComercio')">Cancelar</button>
            <button class="btn-fs-modal-submit" style="background:#e53e3e;" id="btnConfirmarElimCom">Sí, Eliminar</button>
        </div>
    </div>
</div>

<script>
var filaActual = null;

document.addEventListener("DOMContentLoaded", function () {

    // Botón Eliminar
    document.querySelectorAll(".btn-eliminar").forEach(function (btn) {
        btn.addEventListener("click", function () {
            filaActual = this.closest("tr");
            document.getElementById("modalElimComNombre").innerText = filaActual.dataset.nombre;
            document.getElementById("modalElimComCorreo").innerText = filaActual.dataset.correo;
            abrirModal("modalElimComercio");
        });
    });

    // Confirmar Eliminar
    document.getElementById("btnConfirmarElimCom").addEventListener("click", function () {
        if (filaActual) {
            filaActual.style.animation = "fadeOut 0.3s ease forwards";
            setTimeout(() => filaActual.remove(), 300);
        }
        cerrarModal("modalElimComercio");
        mostrarToast("🗑️ Comercio eliminado correctamente");
    });

    // Cerrar al hacer click fuera
    document.querySelectorAll(".fs-modal-overlay").forEach(function (overlay) {
        overlay.addEventListener("click", function (e) {
            if (e.target === overlay) overlay.classList.remove("active");
        });
    });
});

function abrirModal(id) { document.getElementById(id).classList.add("active"); }
function cerrarModal(id) { document.getElementById(id).classList.remove("active"); }

function mostrarToast(mensaje) {
    var toast = document.createElement("div");
    toast.innerText = mensaje;
    Object.assign(toast.style, {
        position: "fixed", bottom: "30px", right: "30px",
        background: "#1a2a32", color: "white", padding: "14px 24px",
        borderRadius: "12px", fontSize: "14px", fontWeight: "600",
        boxShadow: "0 8px 20px rgba(0,0,0,0.2)", zIndex: "9999"
    });
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

</body>
</html>
