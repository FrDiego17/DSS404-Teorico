@extends('layouts.ong')

@section('title', 'Calificaciones')

@section('content')
<main class="container mb-5" style="padding-top:20px;">
    <h2 style="font-size:1.8rem; font-weight:800; color:#1a2a32; margin-bottom:24px;">Calificaciones</h2>

    <div id="calificacionesList">
        <div class="text-center py-5" style="color:#aaa;">
            <i class="fas fa-star fa-3x mb-3"></i>
            <p>Cargando calificaciones...</p>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
async function cargarCalificaciones() {
    try {
        const res = await fetch('{{ route("ong.api.calificaciones.index") }}');
        const data = await res.json();
        const c = document.getElementById('calificacionesList');

        if (!data.length) {
            c.innerHTML = '<div class="text-center py-5" style="color:#aaa;"><i class="fas fa-star fa-3x mb-3"></i><p>No hay calificaciones aún.</p></div>';
            return;
        }

        let html = '';
        data.forEach(cal => {
            html += `<div style="background:white;border-radius:16px;padding:20px;box-shadow:0 4px 20px rgba(0,0,0,0.06);margin-bottom:16px;">
                <div style="font-weight:700;color:#1a2a32;">${'★'.repeat(cal.puntaje)}${'☆'.repeat(5-cal.puntaje)}</div>
                <p style="color:#718096;font-size:14px;margin:8px 0 0;">${cal.comentario ?? ''}</p>
            </div>`;
        });
        c.innerHTML = html;
    } catch(e) {
        document.getElementById('calificacionesList').innerHTML = '<div class="alert alert-warning">No se pudieron cargar las calificaciones.</div>';
    }
}
cargarCalificaciones();
</script>
@endpush
