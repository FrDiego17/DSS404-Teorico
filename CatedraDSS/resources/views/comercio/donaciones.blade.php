@extends('layouts.comercio')

@section('title', 'Mis Publicaciones')

@section('content')
<main class="container mb-5" style="padding-top: 20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32;">Mis Publicaciones</h2>
        <button class="btn" style="background:#45b66f; color:white; border-radius:20px; padding:8px 20px; font-weight:600;" id="btnNuevaPub">
            <i class="fas fa-plus me-2"></i>Nueva Publicación
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius:12px;">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($donaciones as $don)
            @php
                $iconos = ['Platos Preparados'=>'fa-utensils','Panadería y Repostería'=>'fa-bread-slice','Frutas y Verduras'=>'fa-apple-alt','Bebidas y Jugos'=>'fa-wine-bottle','Lácteos y Embutidos'=>'fa-cheese','Carnes'=>'fa-drumstick-bite'];
                $icono = $iconos[$don->categoria->nombre ?? ''] ?? 'fa-box-open';
                $hora  = $don->fecha_limite ? \Carbon\Carbon::parse($don->fecha_limite)->format('d/m/Y H:i') : '--/--/---- --:--';
                $esReservada = $don->estado === 'reservada';
                $esEntregada = $don->estado === 'entregada';
                $esVencida   = $don->estado === 'publicada' && $don->fecha_limite && \Carbon\Carbon::parse($don->fecha_limite)->isPast();
                $tieneReservasActivas = $don->reservas && $don->reservas->count() > 0;
            @endphp
            <div class="col-md-4 mb-4">
                <div class="fs-pub-card" id="card_don_{{ $don->id }}" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; background:white; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border:1px solid {{ $esEntregada ? '#c6f6d5' : ($esReservada ? '#bee3f8' : ($esVencida ? '#fed7d7' : '#e8f5e9')) }};">
                    <div>
                        <div class="pub-category-icon" style="background:#45b66f22; color:#45b66f; width:50px; height:50px; display:flex; align-items:center; justify-content:center; border-radius:50%; margin-bottom:15px; font-size:24px;">
                            <i class="fas {{ $icono }}"></i>
                        </div>
                        <h5 style="font-weight:800; color:#1a2a32; margin-bottom:8px;">
                            {{ $don->titulo }}
                            <span class="badge bg-success ms-2" style="font-size:11px; vertical-align:middle;">{{ $don->cantidad }} uds</span>
                            @if($esEntregada)
                                <span class="badge ms-1" style="font-size:11px; vertical-align:middle; background:#c6f6d5; color:#22543d;" id="badge_estado_{{ $don->id }}">
                                    Entregada
                                </span>
                            @elseif($esReservada)
                                <span class="badge ms-1" style="font-size:11px; vertical-align:middle; background:#bee3f8; color:#2c5282;" id="badge_estado_{{ $don->id }}">
                                    Reservada
                                </span>
                            @elseif($esVencida)
                                <span class="badge ms-1" style="font-size:11px; vertical-align:middle; background:#fed7d7; color:#9b2c2c;" id="badge_estado_{{ $don->id }}">
                                    Tiempo Agotado
                                </span>
                            @else
                                <span class="badge ms-1" style="font-size:11px; vertical-align:middle; background:#fff3cd; color:#e65100;" id="badge_estado_{{ $don->id }}">
                                    {{ ucfirst($don->estado) }}
                                </span>
                            @endif
                        </h5>
                        <p style="font-size:13px; color:#718096; margin-bottom:16px;">{{ \Illuminate\Support\Str::limit($don->descripcion, 70) }}</p>

                        <div class="pub-meta mb-3" style="font-size:13px; font-weight:600; color:{{ $esVencida ? '#e53e3e' : '#e65100' }};">
                            <i class="far fa-clock me-1"></i> Límite: {{ $hora }}
                        </div>
                    </div>


                    <div style="display:flex; flex-direction:column; gap:8px; margin-top:4px;">

                        @if(!$esEntregada && ($esReservada || $tieneReservasActivas))
                            <!-- Boton para verificar entrega, solo si está reservada o tiene reservas activas -->
                            <button
                                onclick="abrirModalVerificar({{ $don->id }}, '{{ addslashes($don->titulo) }}')"
                                style="background:#2b6cb0; color:#fff; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:14px; cursor:pointer; transition:background 0.2s; display:flex; align-items:center; justify-content:center; gap:8px;"
                                onmouseover="this.style.background='#1a4a7a'"
                                onmouseout="this.style.background='#2b6cb0'"
                                id="btn_verificar_{{ $don->id }}"
                            >
                                <i class="fas fa-shield-alt"></i> Verificar Entrega
                            </button>
                        @endif

                        @if(!$esEntregada)
                            <div style="display:flex; gap:8px;">
                                @if(!$esVencida)
                                <button class="pub-request-btn fs-pub-btn" onclick='abrirModalEditar(@json($don))' style="flex:1; background:#f8f9fa; color:#45b66f; border:1px solid #45b66f; padding:10px; border-radius:8px; font-weight:600; text-align:center; transition: all 0.3s; cursor:pointer;">
                                    Editar <i class="fas fa-pencil-alt ms-1"></i>
                                </button>
                                @endif
                                
                                @if(!$esReservada && !$tieneReservasActivas)
                                    <form action="{{ route('comercio.donaciones.destroy', $don->id) }}" method="POST" style="flex:1;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta publicación?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="pub-request-btn fs-pub-btn w-100" style="background:#fff5f5; color:#e53e3e; border:1px solid #feb2b2; padding:10px; border-radius:8px; font-weight:600; text-align:center; transition: all 0.3s; cursor:pointer;">
                                            Eliminar <i class="fas fa-trash-alt ms-1"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <div style="text-align:center; padding:10px; border-radius:8px; background:#f0fff4; color:#276749; font-size:13px; font-weight:600; border:1px solid #c6f6d5;">
                                <i class="fas fa-check-double me-1"></i> Proceso completado
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5" style="color:#aaa;">
                <i class="fas fa-box-open fa-3x mb-3"></i>
                <p>Aún no tienes publicaciones activas.</p>
            </div>
        @endforelse
    </div>

</main>
<!-- Modal para crear/editar publicación -->
<div class="fs-modal-overlay" id="modalNuevaPub">
    <div class="fs-modal-content">
        <button class="fs-modal-close" id="btnCloseModal">&times;</button>
        <h3 style="color: #45b66f; margin-bottom: 20px;">Nueva Publicación</h3>

        @if ($errors->any())
            <div class="alert alert-danger" style="border-radius:12px; font-size:0.9rem;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formDonacion" method="POST" action="{{ route('comercio.donaciones.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="mb-3">
                <label class="form-label text-muted">Categoría</label>
                <select class="form-select" name="categoria_id" required>
                    <option disabled selected value="">Selecciona una categoría</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">Título</label>
                <input type="text" class="form-control" name="titulo" placeholder="Ej: Platos preparados del día" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-muted">Descripción</label>
                <textarea class="form-control" rows="3" name="descripcion" placeholder="Describe el excedente..."></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                    <label class="form-label text-muted">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad" min="1" required>
                </div>
                <div class="col-4">
                    <label class="form-label text-muted">Peso estimado (kg)</label>
                    <input type="number" step="0.01" class="form-control" name="peso_estimado_kg" placeholder="0.00" min="0" value="0">
                </div>
                <div class="col-4">
                    <label class="form-label text-muted">Recoger antes de</label>
                    <input type="datetime-local" class="form-control" name="fecha_limite" required>
                </div>
            </div>
            <button type="submit" class="btn-fs-modal-submit">Publicar Excedente</button>
        </form>
    </div>
</div>

<!-- Modal para verificar entrega -->
<div class="fs-modal-overlay" id="modalVerificar">
    <div class="fs-modal-content" style="max-width:440px;">
        <button class="fs-modal-close" id="btnCloseVerificar">&times;</button>

        <div style="text-align:center; margin-bottom:20px;">
            <div style="width:60px; height:60px; background:linear-gradient(135deg,#2b6cb0,#1a4a7a); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 14px auto;">
                <i class="fas fa-shield-alt" style="color:#fff; font-size:26px;"></i>
            </div>
            <h3 style="color:#1a2a32; font-size:1.2rem; font-weight:800; margin:0 0 4px 0;">Verificar Entrega</h3>
            <p id="verif_titulo" style="font-size:13px; color:#718096; margin:0;"></p>
        </div>

        <div style="background:#f7fafc; border-radius:12px; padding:20px; margin-bottom:20px;">
            <label style="font-size:12px; font-weight:700; color:#4a5568; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:10px;">
                Ingresa el código del voluntario
            </label>
            <input
                type="text"
                id="inputCodigo"
                maxlength="4"
                placeholder="0000"
                style="width:100%; text-align:center; font-size:42px; font-weight:900; letter-spacing:14px; font-family:'Courier New', monospace; border:2px solid #e2e8f0; border-radius:12px; padding:14px 8px; color:#1a2a32; outline:none; transition:border 0.2s;"
                oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,4)"
                onfocus="this.style.borderColor='#2b6cb0'"
                onblur="this.style.borderColor='#e2e8f0'"
            >
        </div>

        <div id="verif_error" style="display:none; background:#fff5f5; border:1px solid #feb2b2; border-radius:8px; padding:10px 14px; font-size:13px; color:#c53030; margin-bottom:14px;">
            <i class="fas fa-times-circle me-1"></i><span id="verif_error_msg"></span>
        </div>

        <button
            id="btnConfirmarVerif"
            onclick="confirmarVerificacion()"
            style="width:100%; background:linear-gradient(135deg,#2b6cb0,#1a4a7a); color:#fff; border:none; border-radius:10px; padding:13px; font-size:15px; font-weight:700; cursor:pointer; transition:opacity 0.2s; display:flex; align-items:center; justify-content:center; gap:10px;"
            onmouseover="this.style.opacity='0.9'"
            onmouseout="this.style.opacity='1'"
        >
            <i class="fas fa-check-circle"></i> Validar Código
        </button>
    </div>
</div>

<!-- Toast notificación -->
<div id="toastComercio" style="
    position:fixed; bottom:28px; right:28px; z-index:9999;
    background:#1a2a32; color:#fff; border-radius:12px;
    padding:14px 22px; font-size:14px; font-weight:600;
    box-shadow:0 8px 32px rgba(0,0,0,0.22);
    display:none; align-items:center; gap:10px; min-width:280px;
">
    <i id="toastComercioIcon" class="fas fa-check-circle" style="color:#45b66f; font-size:18px;"></i>
    <span id="toastComercioMsg"></span>
</div>

@endsection

@push('scripts')
<script>
    const csrfToken = '{{ csrf_token() }}';
    let donacionIdActual = null;

    //  Modal Editar/Crear 
    const btn      = document.getElementById("btnNuevaPub");
    const modal    = document.getElementById("modalNuevaPub");
    const close    = document.getElementById("btnCloseModal");
    const form     = document.getElementById("formDonacion");
    const formMethod = document.getElementById("formMethod");
    const modalTitle = modal.querySelector("h3");

    const fechaInput = document.querySelector('input[name="fecha_limite"]');
    if(fechaInput){
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        fechaInput.min = now.toISOString().slice(0, 16);
    }

    btn.addEventListener("click", () => {
        form.action   = "{{ route('comercio.donaciones.store') }}";
        formMethod.value = "POST";
        form.reset();
        modalTitle.innerText = "Nueva Publicación";
        modal.classList.add("active");
    });
    close.addEventListener("click", () => modal.classList.remove("active"));
    modal.addEventListener("click", (e) => { if (e.target === modal) modal.classList.remove("active"); });

    window.abrirModalEditar = function(donacion) {
        form.action = `{{ url('/comercio/donaciones') }}/${donacion.id}`;
        formMethod.value = "PUT";
        form.querySelector('[name="categoria_id"]').value  = donacion.categoria_id;
        form.querySelector('[name="titulo"]').value        = donacion.titulo;
        form.querySelector('[name="descripcion"]').value   = donacion.descripcion;
        form.querySelector('[name="cantidad"]').value      = donacion.cantidad;
        form.querySelector('[name="peso_estimado_kg"]').value = donacion.peso_estimado_kg;
        if (donacion.fecha_limite) {
            form.querySelector('[name="fecha_limite"]').value = donacion.fecha_limite.slice(0, 16);
        }
        modalTitle.innerText = "Editar / Renovar Publicación";
        modal.classList.add("active");
    };

    @if ($errors->any())
        modal.classList.add("active");
    @endif

    // Modal Verificar Entrega
    const modalVerif    = document.getElementById("modalVerificar");
    const closeVerif    = document.getElementById("btnCloseVerificar");

    closeVerif.addEventListener("click", () => cerrarModalVerif());
    modalVerif.addEventListener("click", (e) => { if(e.target === modalVerif) cerrarModalVerif(); });

    window.abrirModalVerificar = function(donacionId, titulo) {
        donacionIdActual = donacionId;
        document.getElementById('verif_titulo').textContent = titulo;
        document.getElementById('inputCodigo').value        = '';
        document.getElementById('verif_error').style.display = 'none';
        modalVerif.classList.add('active');
        setTimeout(() => document.getElementById('inputCodigo').focus(), 200);
    };

    function cerrarModalVerif() {
        modalVerif.classList.remove('active');
        donacionIdActual = null;
    }

    async function confirmarVerificacion() {
        const codigo = document.getElementById('inputCodigo').value.trim();
        const btn    = document.getElementById('btnConfirmarVerif');
        const errDiv = document.getElementById('verif_error');
        const errMsg = document.getElementById('verif_error_msg');

        if (codigo.length !== 4) {
            errMsg.textContent = 'El código debe tener exactamente 4 dígitos.';
            errDiv.style.display = 'block';
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Validando...';
        errDiv.style.display = 'none';

        try {
            const res  = await fetch('{{ route("comercio.donaciones.verificar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ donacion_id: donacionIdActual, codigo })
            });
            const data = await res.json();

            if (res.ok) {
                cerrarModalVerif();
                mostrarToast('¡Entrega verificada correctamente!', true); 
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                errMsg.textContent = data.message || 'Código incorrecto.';
                errDiv.style.display = 'block';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle"></i> Validar Código';
            }
        } catch(e) {
            errMsg.textContent = 'Error de conexión. Intenta de nuevo.';
            errDiv.style.display = 'block';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check-circle"></i> Validar Código';
        }
    }

    document.getElementById('inputCodigo').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') confirmarVerificacion();
    });

    function mostrarToast(msg, exito = true) {
        const toast = document.getElementById('toastComercio');
        const icon  = document.getElementById('toastComercioIcon');
        const texto = document.getElementById('toastComercioMsg');
        icon.className  = exito ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        icon.style.color = exito ? '#45b66f' : '#e53e3e';
        texto.textContent = msg;
        toast.style.display = 'flex';
        setTimeout(() => { toast.style.display = 'none'; }, 5000);
    }
</script>
@endpush
