@extends('layouts.admin')

@section('title', 'Comercios')

@section('content')
<main class="container" style="padding-top: 20px; min-height: 75vh; padding-bottom: 60px;">

    <h2 class="admin-section-title mb-4">Lista de Comercios</h2>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius:12px;">{{ session('success') }}</div>
    @endif

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Comercial</th>
                    <th>Nombre Registrado</th>
                    <th>NIT</th>
                    <th>Autorización Sanitaria</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comercios as $com)
                    <tr>
                        <td>{{ $com->id }}</td>
                        <td>{{ $com->nombre_comercial }}</td>
                        <td>{{ $com->nombre_registrado }}</td>
                        <td>{{ $com->nit }}</td>
                        <td>{{ $com->no_autorizacion_sanitaria }}</td>
                        <td>{{ $com->telefono ?? '—' }}</td>
                        <td>{{ $com->direccion ?? '—' }}</td>
                        <td>
                            @if($com->estado === 'aprobado')
                                <span style="background:#e8f5e9; color:#2e7d32; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">Aprobado</span>
                            @elseif($com->estado === 'rechazado')
                                <span style="background:#fee2e2; color:#dc2626; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">Rechazado</span>
                            @else
                                <span style="background:#fff3cd; color:#e65100; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">Pendiente</span>
                            @endif

                            @if($com->user && $com->user->estado === 'inactivo')
                                <div class="mt-2">
                                    <span style="background:#f3f4f6; color:#4b5563; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">Suspendido</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($com->estado === 'pendiente')
                                <form method="POST" action="{{ route('admin.comercios.verificar', $com->id) }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="accion" value="aprobado">
                                    <button type="submit" class="btn-action approve" title="Aprobar comercio">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.comercios.verificar', $com->id) }}" style="display:inline;" onsubmit="return confirm('¿Rechazar este comercio?')">
                                    @csrf
                                    <input type="hidden" name="accion" value="rechazado">
                                    <button type="submit" class="btn-action delete" title="Rechazar comercio">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @elseif($com->estado === 'aprobado' && $com->user)
                                @if($com->user->estado === 'activo')
                                    <form method="POST" action="{{ route('admin.comercios.verificar', $com->id) }}" style="display:inline;" onsubmit="return confirm('¿Suspender el acceso a este comercio?')">
                                        @csrf
                                        <input type="hidden" name="accion" value="suspender">
                                        <button type="submit" class="btn-action delete" title="Suspender comercio" style="color: #d97706;">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                @elseif($com->user->estado === 'inactivo')
                                    <form method="POST" action="{{ route('admin.comercios.verificar', $com->id) }}" style="display:inline;" onsubmit="return confirm('¿Habilitar el acceso a este comercio?')">
                                        @csrf
                                        <input type="hidden" name="accion" value="habilitar">
                                        <button type="submit" class="btn-action approve" title="Habilitar comercio" style="color: #059669;">
                                            <i class="fas fa-play"></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <span style="color:#aaa; font-size:12px;">Sin acciones</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding:40px; color:#aaa; font-style:italic;">
                            No hay comercios registrados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>
@endsection
