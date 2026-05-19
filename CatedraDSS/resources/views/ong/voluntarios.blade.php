@extends('layouts.ong')

@section('title', 'Registro de Voluntarios')

@section('content')

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
                    <tbody id="tablaVoluntarios">
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                No hay voluntarios registrados aún.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
    <!-- Modal de Registro y edicion de Voluntarios -->
<div id="modalRegistro" class="fs-modal-overlay">
    <div class="fs-modal-content registration-modal">
        <button class="fs-modal-close" onclick="cerrarModalRegistro()">&times;</button>

        <div class="registration-header">
            <div class="avatar-icon-container">
                <img src="https://cdn-icons-png.flaticon.com/512/6840/6840478.png" alt="Avatar" width="80">
            </div>
        </div>

        <h4 id="modalVolTitulo" style="text-align:center; font-weight:800; color:#1a2a32; margin-bottom:16px;">Registrar Voluntario</h4>

        <div id="volErrorBox" style="display:none; background:#fff5f5; border:1px solid #feb2b2; border-radius:8px; padding:10px 14px; font-size:13px; color:#c53030; margin-bottom:14px;">
            <i class="fas fa-exclamation-circle me-1"></i><span id="volErrorMsg"></span>
        </div>

        <div class="fs-modal-body">
            <form id="formRegistroVoluntario">
                <input type="hidden" id="vol_id" value="">

                <div class="mb-3">
                    <label class="form-label-custom">Nombre del Voluntario</label>
                    <input type="text" class="form-control fs-input" id="vol_nombre" placeholder="Nombre Completo">
                </div>

                <div class="mb-3">
                    <label class="form-label-custom">Correo electrónico</label>
                    <input type="email" class="form-control fs-input" id="vol_email" placeholder="Correo personal del voluntario">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">DUI</label>
                        <input type="text" class="form-control fs-input" id="vol_dui" placeholder="00000000-0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Teléfono</label>
                        <input type="text" class="form-control fs-input" id="vol_telefono" placeholder="0000-0000">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Género</label>
                        <select class="form-select fs-input" id="vol_genero">
                            <option selected disabled>Seleccionar</option>
                            <option>Masculino</option>
                            <option>Femenino</option>
                            <option>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Fecha de Nacimiento <span style="font-size:11px; color:#a0aec0;">(mín. 18 años)</span></label>
                        <input type="date" class="form-control fs-input" id="vol_fecha">
                    </div>
                </div>

                <button type="button" class="btn-fs-registrar-v" id="btnGuardarVol" onclick="confirmarRegistro()">Registrar</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const csrfToken = '{{ csrf_token() }}';
    let modoEdicion = false;

    // Calcular fecha máxima para 18 años
    const hoy = new Date();
    hoy.setFullYear(hoy.getFullYear() - 18);
    document.getElementById('vol_fecha').max = hoy.toISOString().split('T')[0];

    async function cargarVoluntarios() {
        try {
            const res  = await fetch('{{ route("ong.api.voluntarios.index") }}');
            const data = await res.json();
            renderTabla(data);
        } catch (e) {
            console.error('Error cargando voluntarios', e);
        }
    }

    function abrirModalRegistro() {
        modoEdicion = false;
        document.getElementById('vol_id').value    = '';
        document.getElementById('modalVolTitulo').innerText = 'Registrar Voluntario';
        document.getElementById('btnGuardarVol').innerText  = 'Registrar';
        document.getElementById('formRegistroVoluntario').reset();
        document.getElementById('volErrorBox').style.display = 'none';
        document.getElementById('modalRegistro').classList.add('active');
    }

    function abrirModalEditar(vol) {
        modoEdicion = true;
        document.getElementById('vol_id').value           = vol.id;
        document.getElementById('vol_nombre').value       = vol.nombre;
        document.getElementById('vol_email').value        = vol.email ?? '';
        document.getElementById('vol_dui').value          = vol.dui;
        document.getElementById('vol_telefono').value     = vol.telefono;
        document.getElementById('vol_genero').value       = vol.genero;
        document.getElementById('vol_fecha').value        = vol.fecha_nacimiento;
        document.getElementById('modalVolTitulo').innerText = 'Editar Voluntario';
        document.getElementById('btnGuardarVol').innerText  = 'Guardar Cambios';
        document.getElementById('volErrorBox').style.display = 'none';
        document.getElementById('modalRegistro').classList.add('active');
    }

    function cerrarModalRegistro() {
        document.getElementById('modalRegistro').classList.remove('active');
        document.getElementById('formRegistroVoluntario').reset();
    }

    async function confirmarRegistro() {
        const id       = document.getElementById('vol_id').value;
        const nombre   = document.getElementById('vol_nombre').value.trim();
        const email    = document.getElementById('vol_email').value.trim();
        const dui      = document.getElementById('vol_dui').value.trim();
        const telefono = document.getElementById('vol_telefono').value.trim();
        const genero   = document.getElementById('vol_genero').value;
        const fecha    = document.getElementById('vol_fecha').value;

        const body = { nombre, email, dui, telefono, genero, fecha_nacimiento: fecha };

        const url    = modoEdicion ? `{{ url('ong/api/voluntarios') }}/${id}` : '{{ route("ong.api.voluntarios.store") }}';
        const method = modoEdicion ? 'PUT' : 'POST';

        try {
            const res  = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(body)
            });

            const data = await res.json();

            if (res.ok) {
                cargarVoluntarios();
                cerrarModalRegistro();
            } else {
                let errorMsg = '';
                if (data.errors) {
                    errorMsg = Object.values(data.errors).map(e => e[0]).join(' | ');
                } else {
                    errorMsg = data.message || 'Error desconocido.';
                }
                document.getElementById('volErrorMsg').textContent = errorMsg;
                document.getElementById('volErrorBox').style.display = 'block';
            }
        } catch (e) {
            document.getElementById('volErrorMsg').textContent = 'Error de conexión al guardar voluntario.';
            document.getElementById('volErrorBox').style.display = 'block';
        }
    }

    function renderTabla(voluntarios) {
        const tbody = document.getElementById('tablaVoluntarios');
        if (!voluntarios.length) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-4">
                <i class="fas fa-users fa-2x mb-2 d-block"></i>No hay voluntarios registrados aún.</td></tr>`;
            return;
        }
        tbody.innerHTML = voluntarios.map(v => `
            <tr>
                <td class="fw-bold text-muted">${v.id}</td>
                <td><div class="d-flex align-items-center">
                    <div class="avatar-circle me-2">${v.nombre.charAt(0).toUpperCase()}</div>
                    <span>${v.nombre}</span>
                </div></td>
                <td><i class="fas fa-phone-alt me-2 text-success"></i>${v.telefono}</td>
                <td>${v.dui}</td>
                <td><span class="badge-gender">${v.genero}</span></td>
                <td>${v.fecha_nacimiento}</td>
                <td>${v.email || 'N/A'}</td>
                <td class="text-center">
                    <div class="btn-group gap-1">
                        <button class="btn btn-sm" onclick='abrirModalEditar(${JSON.stringify(v)})'
                            style="background:#e8f5e9; color:#2e7d32; border:1px solid #c6f0d6; border-radius:6px; padding:4px 10px;">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-action-delete" onclick="eliminarVoluntario(${v.id})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>`).join('');
    }

    async function eliminarVoluntario(id) {
        if (confirm('¿Estás seguro de eliminar este voluntario?')) {
            try {
                const res = await fetch(`{{ url('ong/api/voluntarios') }}/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                if (res.ok) { cargarVoluntarios(); }
                else { alert('Error al eliminar el voluntario.'); }
            } catch (e) {
                alert('Error de conexión al eliminar.');
            }
        }
    }

    document.getElementById('modalRegistro').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalRegistro();
    });

    document.addEventListener('DOMContentLoaded', cargarVoluntarios);
</script>
@endpush
