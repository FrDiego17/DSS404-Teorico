<?php
// views/admin/organizaciones-admin.php

$organizaciones = [
    ['id' => 1, 'nombre' => 'Banco de Alimentos', 'nombreCNR' => 'BDA El Salvador', 'correo' => 'bda@foodshare.sv', 'nit' => '0614-010190-101-1', 'numRAS' => 'RAS-0023', 'departamento' => 'San Salvador', 'distrito' => 'Soyapango', 'direccion' => 'Av. Don Bosco #16', 'aprobado' => true],
    ['id' => 2, 'nombre' => 'Dona tu Comida', 'nombreCNR' => 'Fundación Dona', 'correo' => 'dona@foodshare.sv', 'nit' => '0614-020280-201-2', 'numRAS' => 'RAS-0047', 'departamento' => 'La Libertad', 'distrito' => 'Santa Tecla', 'direccion' => 'Calle Principal #8', 'aprobado' => false],
    ['id' => 3, 'nombre' => 'Mesa Solidaria', 'nombreCNR' => 'Mesa Solidaria SV', 'correo' => 'mesa@foodshare.sv', 'nit' => '0614-030370-301-3', 'numRAS' => 'RAS-0051', 'departamento' => 'Sonsonate', 'distrito' => 'Izalco', 'direccion' => 'Col. Las Flores #4', 'aprobado' => true],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodshare - Organizaciones Admin</title>
    <style>
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; transform: translateX(20px); } }
        .btn-action.approved { background: #2e7d32 !important; }
    </style>
</head>
<body>

<?php include '../../includes/headeradmin.php'; ?>

<main class="container" style="padding-top: 20px; min-height: 75vh; padding-bottom: 60px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="admin-section-title mb-0">Lista de Organizaciones No Gubernamentales</h2>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>NombreCNR</th>
                    <th>Correo</th>
                    <th>NIT</th>
                    <th>Registro Asociación</th>
                    <th>Departamento</th>
                    <th>Distrito</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="orgTableBody">
                <?php foreach ($organizaciones as $org): ?>
                    <tr data-id="<?php echo $org['id']; ?>"
                        data-nombre="<?php echo htmlspecialchars($org['nombre']); ?>"
                        data-correo="<?php echo htmlspecialchars($org['correo']); ?>"
                        data-nit="<?php echo htmlspecialchars($org['nit']); ?>"
                        data-departamento="<?php echo htmlspecialchars($org['departamento']); ?>"
                        data-direccion="<?php echo htmlspecialchars($org['direccion']); ?>">
                        <td><?php echo $org['id']; ?></td>
                        <td><?php echo htmlspecialchars($org['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($org['nombreCNR']); ?></td>
                        <td><?php echo htmlspecialchars($org['correo']); ?></td>
                        <td><?php echo htmlspecialchars($org['nit']); ?></td>
                        <td><?php echo htmlspecialchars($org['numRAS']); ?></td>
                        <td><?php echo htmlspecialchars($org['departamento']); ?></td>
                        <td><?php echo htmlspecialchars($org['distrito']); ?></td>
                        <td><?php echo htmlspecialchars($org['direccion']); ?></td>
                        <td>
                            <button class="btn-action approve btn-aprobar" title="Aprobar organización"
                                    <?php echo $org['aprobado'] ? 'style="background:#2e7d32;" title="Ya aprobada"' : ''; ?>>
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn-action delete btn-eliminar" title="Eliminar organización">
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

<!-- MODAL: Confirmar Aprobación -->
<div class="fs-modal-overlay" id="modalAprobar">
    <div class="fs-modal-content" style="max-width: 420px; text-align: center;">
        <button class="fs-modal-close" onclick="cerrarModal('modalAprobar')">&times;</button>
        <div style="font-size: 56px; margin-bottom: 16px;">✅</div>
        <h4 style="font-weight:800; color:#1a2a32; margin-bottom:8px;">Aprobar Organización</h4>
        <p style="color:#718096; font-size:14px; margin-bottom:20px;">
            ¿Confirmas la aprobación de <strong id="modalAprobarNombre"></strong>?<br>
            Se le notificará por correo a <span id="modalAprobarCorreo" style="color:#45b66f;"></span>
        </p>
        <div class="d-flex gap-2">
            <button class="btn-fs-modal-submit" style="background:#e2e8f0; color:#333;" onclick="cerrarModal('modalAprobar')">Cancelar</button>
            <button class="btn-fs-modal-submit" id="btnConfirmarAprobar">Sí, Aprobar</button>
        </div>
    </div>
</div>

<!-- MODAL: Confirmar Eliminación -->
<div class="fs-modal-overlay" id="modalEliminar">
    <div class="fs-modal-content" style="max-width: 420px; text-align: center;">
        <button class="fs-modal-close" onclick="cerrarModal('modalEliminar')">&times;</button>
        <div style="font-size: 56px; margin-bottom: 16px;">🗑️</div>
        <h4 style="font-weight:800; color:#e53e3e; margin-bottom:8px;">Eliminar Organización</h4>
        <p style="color:#718096; font-size:14px; margin-bottom:20px;">
            Estás a punto de eliminar a <strong id="modalElimNombre"></strong>.<br>Esta acción no se puede deshacer.
        </p>
        <div class="d-flex gap-2">
            <button class="btn-fs-modal-submit" style="background:#e2e8f0; color:#333;" onclick="cerrarModal('modalEliminar')">Cancelar</button>
            <button class="btn-fs-modal-submit" style="background:#e53e3e;" id="btnConfirmarEliminar">Sí, Eliminar</button>
        </div>
    </div>
</div>

<script>
var filaActual = null;

document.addEventListener("DOMContentLoaded", function () {

    // Botón Aprobar
    document.querySelectorAll(".btn-aprobar").forEach(function (btn) {
        btn.addEventListener("click", function () {
            filaActual = this.closest("tr");
            document.getElementById("modalAprobarNombre").innerText = filaActual.dataset.nombre;
            document.getElementById("modalAprobarCorreo").innerText = filaActual.dataset.correo;
            abrirModal("modalAprobar");
        });
    });

    // Confirmar Aprobar
    document.getElementById("btnConfirmarAprobar").addEventListener("click", function () {
        if (filaActual) {
            var btn = filaActual.querySelector(".btn-aprobar");
            btn.style.background = "#2e7d32";
            btn.title = "Ya aprobada";
            btn.innerHTML = '<i class="fas fa-check-double"></i>';
        }
        cerrarModal("modalAprobar");
        mostrarToast("✅ Organización aprobada con éxito");
    });

    // Botón Eliminar
    document.querySelectorAll(".btn-eliminar").forEach(function (btn) {
        btn.addEventListener("click", function () {
            filaActual = this.closest("tr");
            document.getElementById("modalElimNombre").innerText = filaActual.dataset.nombre;
            abrirModal("modalEliminar");
        });
    });

    // Confirmar Eliminar
    document.getElementById("btnConfirmarEliminar").addEventListener("click", function () {
        if (filaActual) {
            filaActual.style.animation = "fadeOut 0.3s ease forwards";
            setTimeout(() => filaActual.remove(), 300);
        }
        cerrarModal("modalEliminar");
        mostrarToast("🗑️ Organización eliminada");
    });

    // Cerrar modal al hacer click fuera
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
        boxShadow: "0 8px 20px rgba(0,0,0,0.2)", zIndex: "9999",
        animation: "fadeIn 0.3s ease"
    });
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

</body>
</html>
