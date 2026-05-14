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

{{-- MODAL DE REGISTRO --}}
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
                        <label class="form-label-custom">Fecha de Nacimiento</label>
                        <input type="date" class="form-control fs-input" id="vol_fecha">
                    </div>
                </div>

                <button type="button" class="btn-fs-registrar-v" onclick="confirmarRegistro()">Registrar</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const csrfToken = '{{ csrf_token() }}';

    async function cargarVoluntarios() {
        try {
            const res = await fetch('{{ route("ong.api.voluntarios.index") }}');
            const data = await res.json();
            renderTabla(data);
        } catch (e) {
            console.error('Error cargando voluntarios', e);
        }
    }

    function abrirModalRegistro() {
        document.getElementById('modalRegistro').classList.add('active');
    }

    function cerrarModalRegistro() {
        document.getElementById('modalRegistro').classList.remove('active');
        document.getElementById('formRegistroVoluntario').reset();
    }

    async function confirmarRegistro() {
        const nombre   = document.getElementById('vol_nombre').value.trim();
        const email    = document.getElementById('vol_email').value.trim();
        const dui      = document.getElementById('vol_dui').value.trim();
        const telefono = document.getElementById('vol_telefono').value.trim();
        const genero   = document.getElementById('vol_genero').value;
        const fecha    = document.getElementById('vol_fecha').value;

        const body = { nombre, email, dui, telefono, genero, fecha_nacimiento: fecha };

        try {
            const res = await fetch('{{ route("ong.api.voluntarios.store") }}', {
                method: 'POST',
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
                alert('Voluntario registrado correctamente.');
            } else {
                // Validacion de errores
                let errorMsg = 'Error en el formulario:\n';
                if (data.errors) {
                    for (const key in data.errors) {
                        errorMsg += `- ${data.errors[key][0]}\n`;
                    }
                } else {
                    errorMsg = data.message || 'Error desconocido.';
                }
                alert(errorMsg);
            }
        } catch (e) {
            alert('Error de conexión al registrar voluntario.');
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
                    <div class="btn-group">
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
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) {
                    cargarVoluntarios();
                } else {
                    alert('Error al eliminar el voluntario.');
                }
            } catch (e) {
                alert('Error de conexión al eliminar.');
            }
        }
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('modalRegistro').addEventListener('click', function(e) {
        if (e.target === this) cerrarModalRegistro();
    });

    // Cargar voluntarios al iniciar
    document.addEventListener('DOMContentLoaded', cargarVoluntarios);
</script>
@endpush
