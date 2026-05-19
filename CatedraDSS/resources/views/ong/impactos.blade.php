@extends('layouts.ong')

@section('title', 'Gestionar Impactos')

@section('content')
<main class="container mb-5" style="padding-top: 20px;">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 pb-2" style="border-bottom: 1px solid #e2e8f0;">
        <h2 style="font-size: 1.6rem; font-weight: 700; color: #1e3a27; margin: 0;">
            Mis Historias de Impacto
        </h2>
        <button type="button" class="btn btn-success px-4 fw-semibold" style="background-color: #45b66f; border: none; border-radius: 20px;" data-bs-toggle="modal" data-bs-target="#modalAgregarImpacto">
            Agregar <i class="fas fa-plus ms-1" style="font-size: 0.85rem;"></i>
        </button>
    </div>

    <div class="row">
        @forelse($misImpactos as $item)
            <div class="col-md-4 mb-4">
                <div class="fs-pub-card" style="display: flex; flex-direction: column; justify-content: space-between; height: 100%; background: #ffffff; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 24px; border: 1px solid rgba(0,0,0,0.01);">
                    <div>
                        @if($item->imagen)
                            <div style="width: 100%; height: 150px; border-radius: 12px; margin-bottom: 16px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $item->imagen) }}" alt="Imagen de impacto" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @else
                            <div style="background: rgba(69, 182, 111, 0.12); color: #45b66f; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-bottom: 16px; font-size: 22px;">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                        @endif
                        <h5 style="font-weight: 700; color: #1a2a32; margin-bottom: 12px; font-size: 1.1rem;">
                            {{ $item->titulo }}
                        </h5>
                        <p style="color: #4a5568; font-size: 14px; line-height: 1.6; margin-bottom: 0;">
                            {{ $item->descripcion }}
                        </p>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-2" style="border-top: 1px solid #f7fafc;">
                        <button type="button" class="btn-link text-secondary p-0 border-0 bg-transparent btn-editar" 
                                title="Editar Publicación"
                                data-id="{{ $item->id }}"
                                data-titulo="{{ $item->titulo }}"
                                data-descripcion="{{ $item->descripcion }}">
                            <i class="fas fa-pencil-alt" style="font-size: 1.1rem;"></i>
                        </button>
                        
                        <button type="button" class="btn-link text-secondary p-0 border-0 bg-transparent btn-eliminar" 
                                title="Eliminar Publicación"
                                data-id="{{ $item->id }}">
                            <i class="fas fa-trash-alt" style="font-size: 1.1rem;"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">No has registrado ninguna publicación de impacto todavía.</p>
            </div>
        @endforelse
    </div>
</main>

<div class="modal fade" id="modalAgregarImpacto" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h5 class="modal-title fw-bold text-dark" id="modalAgregarLabel">Publicar Nueva Historia de Impacto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ong.impactos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="titulo" class="form-label fw-semibold">Título de la acción</label>
                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Ej: Comedores comunitarios" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-semibold">Descripción del impacto</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="4" placeholder="Describe detalladamente cómo ayudó esta actividad..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label fw-semibold">Fotografía (Opcional)</label>
                        <input type="file" class="form-control" name="imagen" id="imagen" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4" style="background-color: #45b66f; border: none; border-radius: 20px;">Guardar Publicación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarImpacto" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h5 class="modal-title fw-bold text-dark" id="modalEditarLabel">Editar Historia de Impacto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditar" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_titulo" class="form-label fw-semibold">Título de la acción</label>
                        <input type="text" class="form-control" name="titulo" id="edit_titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_descripcion" class="form-label fw-semibold">Descripción del impacto</label>
                        <textarea class="form-control" name="descripcion" id="edit_descripcion" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_imagen" class="form-label fw-semibold">Actualizar fotografía (Opcional)</label>
                        <input type="file" class="form-control" name="imagen" id="edit_imagen" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 20px;">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4" style="background-color: #45b66f; border: none; border-radius: 20px;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEliminarImpacto" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-body text-center p-4">
                <div class="text-danger mb-3" style="font-size: 2.5rem;">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">¿Eliminar publicación?</h5>
                <p class="text-muted small">La historia se ocultará del sistema de forma segura.</p>
                
                <form id="formEliminar" method="POST" class="d-flex justify-content-center gap-2 mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light px-3 border" data-bs-dismiss="modal" style="border-radius: 20px;">No, volver</button>
                    <button type="submit" class="btn btn-danger px-3" style="border-radius: 20px;">Sí, eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarImpacto'));
        const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminarImpacto'));

        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const titulo = this.getAttribute('data-titulo');
                const descripcion = this.getAttribute('data-descripcion');

                document.getElementById('edit_titulo').value = titulo;
                document.getElementById('edit_descripcion').value = descripcion;

                document.getElementById('formEditar').action = `/ong/impactos/actualizar/${id}`;

                modalEditar.show();
            });
        });

        document.querySelectorAll('.btn-eliminar').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                document.getElementById('formEliminar').action = `/ong/impactos/eliminar/${id}`;

                modalEliminar.show();
            });
        });
    });
</script>
@endsection