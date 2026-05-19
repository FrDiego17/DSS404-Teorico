@extends('layouts.ong')

@section('title', 'Entregas')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Mis Entregas</h2>

    <div id="entregasList">
        <div class="text-center py-5" style="color:#aaa;">
            <i class="fas fa-spinner fa-spin fa-2x mb-3"></i>
            <p>Cargando entregas...</p>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
async function cargarEntregas() {
    try {
        const res = await fetch('{{ route("ong.api.entregas.index") }}');
        const data = await res.json();
        const c = document.getElementById('entregasList');

        if (!data.length) {
            c.innerHTML = '<div class="text-center py-5" style="color:#aaa;"><i class="fas fa-truck fa-3x mb-3"></i><p>No hay entregas registradas aún.</p></div>';
            return;
        }

        let html = '';
        data.forEach(e => {
            html += `<div style="background:white;border-radius:16px;padding:20px;box-shadow:0 4px 20px rgba(0,0,0,0.06);margin-bottom:16px;display:flex;align-items:center;gap:16px;">
                <div style="width:48px;height:48px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">📦</div>
                <div>
                    <div style="font-weight:700;color:#1a2a32;">${e.donacion?.titulo ?? 'Entrega'}</div>
                    <div style="font-size:13px;color:#718096;">Estado: ${e.estado ?? '—'}</div>
                </div>
            </div>`;
        });
        c.innerHTML = html;
    } catch(e) {
        document.getElementById('entregasList').innerHTML = '<div class="alert alert-warning">No se pudieron cargar las entregas.</div>';
    }
}
cargarEntregas();
</script>
@endpush
