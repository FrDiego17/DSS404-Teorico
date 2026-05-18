@extends('layouts.admin')

@section('title', 'Organizaciones')

@section('content')
<main class="container" style="padding-top: 20px; min-height: 75vh; padding-bottom: 60px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="admin-section-title mb-0">Lista de Organizaciones No Gubernamentales</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="border-radius:12px;">{{ session('success') }}</div>
    @endif

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Oficial</th>
                    <th>Representante</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="orgTableBody">
                @forelse($ongs as $org)
                    <tr data-id="{{ $org->id }}"
                        data-nombre="{{ $org->nombre_oficial }}"
                        data-correo="{{ $org->user->email ?? '' }}">
                        <td>{{ $org->id }}</td>
                        <td>{{ $org->nombre_oficial }}</td>
                        <td>{{ $org->representante_legal }}</td>
                        <td>{{ $org->telefono_contacto }}</td>
                        <td>{{ $org->direccion }}</td>
                        <td>
                            @if($org->estado_verificacion === 'verificada')
                                <span style="background:#e8f5e9; color:#2e7d32; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">✓ Verificada</span>
                            @elseif($org->estado_verificacion === 'rechazada')
                                <span style="background:#fee2e2; color:#dc2626; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">✗ Rechazada</span>
                            @else
                                <span style="background:#fff3cd; color:#e65100; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">⏳ Pendiente</span>
                            @endif
                        </td>
                        <td>
                            @if($org->estado_verificacion === 'pendiente')
                                <form method="POST" action="{{ route('admin.ongs.verificar', $org->id) }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="accion" value="verificada">
                                    <button type="submit" class="btn-action approve" title="Aprobar organización">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.ongs.verificar', $org->id) }}" style="display:inline;" onsubmit="return confirm('¿Rechazar esta organización?')">
                                    @csrf
                                    <input type="hidden" name="accion" value="rechazada">
                                    <button type="submit" class="btn-action delete" title="Rechazar organización">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @else
                                <span style="color:#aaa; font-size:12px;">Sin acciones</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:40px; color:#aaa; font-style:italic;">
                            No hay organizaciones registradas aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>
@endsection
