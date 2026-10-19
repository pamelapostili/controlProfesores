@extends('layouts.app')

@section('title', 'Consulta de Profesores')

@section('content')
<div class="container py-4">

    {{-- Hero Banner --}}
    <div class="card hero-card border-0 mb-4 overflow-hidden position-relative">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4 position-relative z-1">
                <div class="col-lg-7">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill hero-badge mb-3">
                        <i class="bi bi-broadcast-pin"></i>
                        <span class="fw-bold small text-uppercase tracking-wide">Directorio Universitario</span>
                    </div>
                    <h1 class="display-5 fw-bold text-dark tracking-tight mb-2">Localiza a tu Profesor</h1>
                    <p class="text-secondary fs-6 mb-0">
                        Ubica en tiempo real la disponibilidad, aula, horario de atención y canales directos de contacto del personal docente.
                    </p>
                </div>

                <div class="col-lg-5">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card p-3 rounded-4 bg-white border text-center">
                                <span class="stat-number d-block fw-bold">{{ $profesores->count() }}</span>
                                <span class="stat-label text-muted small fw-medium">Docentes</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card p-3 rounded-4 bg-white border text-center">
                                <span class="stat-number d-block fw-bold">
                                    {{ $profesores->sum(fn($p) => $p->horarios ? $p->horarios->count() : 0) }}
                                </span>
                                <span class="stat-label text-muted small fw-medium">Horarios</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Buscador y Filtros Avanzados --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('profesores.index') }}">
                <div class="row g-2 align-items-center">
                    {{-- Campo de texto --}}
                    <div class="col-lg">
                        <div class="input-group search-input-group">
                            <span class="input-group-text bg-transparent border-0 pe-1">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   name="q" 
                                   value="{{ $search ?? '' }}" 
                                   class="form-control border-0 shadow-none ps-2" 
                                   placeholder="Buscar por nombre, materia, edificio o aula...">
                        </div>
                    </div>

                    {{-- Filtro de Estatus --}}
                    <div class="col-lg-auto border-lg-start border-1 ps-lg-3">
                        <select name="estatus" class="form-select border-0 shadow-none py-2 fw-medium text-secondary">
                            <option value="">Todos los Estatus</option>
                            @foreach($estatuses as $key => $label)
                                <option value="{{ $key }}" @selected(($estatus ?? '') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="col-lg-auto d-flex gap-2">
                        <button type="submit" class="btn btn-brand px-4 py-2 rounded-3 fw-semibold">
                            Buscar
                        </button>
                        @if(!empty($search) || !empty($estatus))
                            <a href="{{ route('profesores.index') }}" class="btn btn-light border px-3 py-2 rounded-3" title="Limpiar filtros">
                                <i class="bi bi-x-lg text-secondary"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Grid de Tarjetas de Profesores --}}
    <div class="row g-4">
        @forelse($profesores as $profesor)
            @php
                // Mapeo dinámico de estilos según estatus
                $statusMap = [
                    'libre'     => ['bg' => 'bg-emerald-soft', 'text' => 'text-emerald', 'dot' => 'dot-emerald', 'label' => 'Disponible'],
                    'en_clase'  => ['bg' => 'bg-rose-soft',    'text' => 'text-rose',    'dot' => 'dot-rose',    'label' => 'En Clase'],
                    'reunion'   => ['bg' => 'bg-amber-soft',   'text' => 'text-amber',   'dot' => 'dot-amber',   'label' => 'En Reunión'],
                    'ausente'   => ['bg' => 'bg-slate-soft',   'text' => 'text-slate',   'dot' => 'dot-slate',   'label' => 'Fuera de Campus']
                ];
                $currentStatus = $statusMap[$profesor->estatus] ?? ['bg' => 'bg-slate-soft', 'text' => 'text-slate', 'dot' => 'dot-slate', 'label' => $profesor->estatus_label ?? ucfirst($profesor->estatus)];
            @endphp

            <div class="col-md-6 col-xl-4">
                <div class="card h-100 teacher-card border-0 rounded-4 shadow-sm position-relative">
                    <div class="card-body p-4 d-flex flex-column">
                        
                        {{-- Encabezado: Avatar, Info y Badge de Estatus --}}
                        <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="position-relative">
                                    <img src="{{ $profesor->foto ?? 'https://ui-avatars.com/api/?name='.urlencode($profesor->nombre).'&background=6f7e49&color=fff' }}" 
                                         class="rounded-circle object-fit-cover shadow-sm border border-2 border-white" 
                                         width="60" height="60" 
                                         alt="{{ $profesor->nombre }}">
                                    <span class="status-pulse-dot {{ $currentStatus['dot'] }}"></span>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1 h6 text-line-clamp-1">{{ $profesor->nombre }}</h5>
                                    <span class="badge bg-light text-secondary border fw-normal text-truncate d-inline-block style-dept-badge">
                                        {{ $profesor->departamento }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Badge de Estatus Completo --}}
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} small fw-semibold">
                                <span>{{ $currentStatus['label'] }}</span>
                                @if(!empty($profesor->estatus_detalle))
                                    <span class="opacity-75 font-normal">· {{ $profesor->estatus_detalle }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Ubicación y Correo --}}
                        <div class="bg-light-subtle p-3 rounded-3 mb-3 border border-light text-secondary small d-flex flex-column gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-geo-alt-fill text-brand"></i>
                                <span class="fw-medium text-dark text-truncate">{{ $profesor->ubicacion ?? 'Oficina / Aula no asignada' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-envelope text-muted"></i>
                                <span class="text-truncate">{{ $profesor->email }}</span>
                            </div>
                        </div>

                        {{-- Horario de Trabajo --}}
                        <div class="row g-0 text-center py-2 px-3 bg-light rounded-3 mb-4 mt-auto border">
                            <div class="col-6 border-end">
                                <span class="text-muted extra-small text-uppercase fw-semibold d-block">Entrada</span>
                                <strong class="text-dark small">
                                    {{ is_object($profesor->entrada) ? $profesor->entrada->format('H:i') : ($profesor->entrada ? date('H:i', strtotime($profesor->entrada)) : '--:--') }}
                                </strong>
                            </div>
                            <div class="col-6">
                                <span class="text-muted extra-small text-uppercase fw-semibold d-block">Salida</span>
                                <strong class="text-dark small">
                                    {{ is_object($profesor->salida) ? $profesor->salida->format('H:i') : ($profesor->salida ? date('H:i', strtotime($profesor->salida)) : '--:--') }}
                                </strong>
                            </div>
                        </div>

                        {{-- Footer / Acciones --}}
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="small text-muted d-flex align-items-center gap-1">
                                <i class="bi bi-calendar-week text-brand"></i>
                                <span>{{ $profesor->horarios ? $profesor->horarios->count() : 0 }} Clases / Horarios</span>
                            </span>

                            <div class="d-flex gap-2">
                                <a href="mailto:{{ $profesor->email }}" 
                                   class="btn btn-action-icon rounded-circle" 
                                   title="Enviar correo a {{ $profesor->nombre }}">
                                    <i class="bi bi-envelope"></i>
                                </a>
                                <a href="{{ route('profesores.show', $profesor) }}" 
                                   class="btn btn-action-icon btn-action-primary rounded-circle" 
                                   title="Ver ficha completa">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5">
                <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
                    <div class="empty-state-icon mb-3">
                        <i class="bi bi-search fs-1 text-muted"></i>
                    </div>
                    <h4 class="fw-bold text-dark">No se encontraron profesores</h4>
                    <p class="text-muted mb-4 max-w-md mx-auto">No hay resultados que coincidan con la búsqueda actual. Intenta cambiar las palabras clave o borrar los filtros.</p>
                    <a href="{{ route('profesores.index') }}" class="btn btn-brand px-4 py-2 rounded-3">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Restablecer Filtros
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if(method_exists($profesores, 'links'))
        <div class="d-flex justify-content-center mt-5">
            {{ $profesores->links() }}
        </div>
    @endif
</div>

{{-- Estilos personalizados basados en la marca #6f7e49 --}}
<style>
    :root {
        --brand-color: #6f7e49;
        --brand-color-hover: #5b693c;
        --brand-color-light: rgba(111, 126, 73, 0.12);
    }

    /* Estilos Generales y Marca */
    .text-brand { color: var(--brand-color) !important; }
    .btn-brand {
        background-color: var(--brand-color);
        color: #ffffff;
        border: none;
    }
    .btn-brand:hover {
        background-color: var(--brand-color-hover);
        color: #ffffff;
    }

    .hero-card {
        background: linear-gradient(135deg, rgba(111, 126, 73, 0.08) 0%, rgba(255, 255, 255, 1) 100%);
        border: 1px solid rgba(111, 126, 73, 0.15) !important;
    }
    .hero-badge {
        background-color: var(--brand-color-light);
        color: var(--brand-color);
    }
    .stat-number {
        font-size: 1.6rem;
        color: var(--brand-color);
    }

    /* Tarjetas de Profesores */
    .teacher-card {
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(0, 0, 0, 0.06) !important;
    }
    .teacher-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(111, 126, 73, 0.3) !important;
    }

    .style-dept-badge {
        max-width: 180px;
        font-size: 0.75rem;
    }

    /* Botones de acción circular */
    .btn-action-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #e9ecef;
        transition: all 0.2s ease;
    }
    .btn-action-icon:hover {
        background-color: #e9ecef;
        color: #212529;
    }
    .btn-action-primary {
        background-color: var(--brand-color-light);
        color: var(--brand-color);
        border-color: transparent;
    }
    .btn-action-primary:hover {
        background-color: var(--brand-color);
        color: #ffffff;
    }

    /* Badges de Estatus Personalizados */
    .bg-emerald-soft { background-color: #d1fae5; }
    .text-emerald { color: #065f46; }
    .dot-emerald { background-color: #10b981; }

    .bg-rose-soft { background-color: #ffe4e6; }
    .text-rose { color: #9f1239; }
    .dot-rose { background-color: #f43f5e; }

    .bg-amber-soft { background-color: #fef3c7; }
    .text-amber { color: #92400e; }
    .dot-amber { background-color: #f59e0b; }

    .bg-slate-soft { background-color: #f1f5f9; }
    .text-slate { color: #475569; }
    .dot-slate { background-color: #94a3b8; }

    /* Indicador tipo punto con pulso de estado en la foto */
    .status-pulse-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        border: 2px solid #ffffff;
    }

    .extra-small { font-size: 0.72rem; }
    .text-line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .max-w-md { max-width: 28rem; }
</style>
@endsection