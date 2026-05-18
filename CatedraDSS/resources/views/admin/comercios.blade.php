@extends('layouts.admin')

@section('title', 'Comercios')

@section('content')
<main class="container" style="padding-top: 20px; min-height: 75vh; padding-bottom: 60px;">

    <h2 class="admin-section-title mb-4">Lista de Comercios</h2>

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
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:40px; color:#aaa; font-style:italic;">
                            No hay comercios registrados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>
@endsection
