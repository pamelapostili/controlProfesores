@extends('layouts.app')

@section('title', 'Mi Panel | Portal Docente')

@section('content')
<div class="container py-4">

    @php
        // Mapeo dinámico de estatus para colores y badges
        $statusConfig = [
            'libre'     => ['bg' => 'bg-emerald-soft', 'text' => 'text-emerald', 'dot' => 'dot-emerald', 'label' => 'Disponible', 'icon' => 'bi-check-circle-fill'],
            'en_clase'  => ['bg' => 'bg-rose-soft',    'text' => 'text-rose',    'dot' => 'dot-rose',    'label' => 'En Clase',    'icon' => 'bi-journal-bookmark-fill'],
            'reunion'   => ['bg' => 'bg-amber-soft',   'text' => 'text-amber',   'dot' => 'dot-amber',   'label' => 'En Reunión', 'icon' => 'bi-people-fill'],
            'ausente'   => ['bg' => 'bg-slate-soft',   'text' => 'text-slate',   'dot' => 'dot-slate',   'label' => 'Fuera del Campus', 'icon' => 'bi-building-dash']
        ];
        $st = $statusConfig[$profesor->estatus] ?? ['bg' => 'bg-slate-soft', 'text' => 'text-slate', 'dot' => 'dot-slate', 'label' => $profesor->estatus_label ?? ucfirst($profesor->estatus), 'icon' => 'bi-info-circle-fill'];
    @endphp

    {{-- Encabezado de Bienvenida --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 welcome-hero overflow-hidden position-relative">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-3 position-relative z-1">
                <div class="col-md-8">
                    <span class="badge bg-brand-soft text-brand fw-bold text-uppercase px-3 py-2 rounded-pill small mb-2">
                        <i class="bi bi-shield-check me-1"></i> UNILIFE · PORTAL DOCENTE
                    </span>
                    <h1 class="display-6 fw-extrabold text-dark mt-1 mb-2">¡Hola, {{ $profesor->nombre }}!</h1>
                    <p class="text-secondary mb-0 fs-6">
                        Bienvenido a tu panel de control. Administra tu información personal, consulta tus asignaciones y revisa tus horarios.
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-brand rounded-pill px-4 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-gear-fill me-1"></i> Mi Cuenta
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Columna Izquierda: Perfil y Estatus del Profesor --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="text-center pb-3 border-bottom mb-4">
                    {{-- Foto con avatar de respaldo e indicador de pulso --}}
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $profesor->foto ?? 'https://ui-avatars.com/api/?name='.urlencode($profesor->nombre).'&background=6f7e49&color=fff' }}" 
                             alt="Foto de {{ $profesor->nombre }}" 
                             class="rounded-circle object-fit-cover shadow-sm border border-3 border-white" 
                             width="110" height="110">
                        <span class="status-pulse-dot {{ $st['dot'] }}" style="width: 20px; height: 20px; bottom: 4px; right: 4px;" title="Estatus actual"></span>
                    </div>

                    <h4 class="fw-bold text-dark mb-1 h5">{{ $profesor->nombre }}</h4>
                    <span class="badge bg-light text-secondary border fw-normal mb-2 px-3 py-1 text-wrap">
                        {{ $profesor->departamento }}
                    </span>
                    <div class="small text-muted d-flex align-items-center justify-content-center gap-1 mt-1">
                        <i class="bi bi-envelope text-brand"></i>
                        <span>{{ $profesor->email }}</span>
                    </div>
                </div>

                {{-- Estatus Actual --}}
                <div class="mb-4">
                    <label class="extra-small text-uppercase fw-bold text-muted tracking-wide d-block mb-2">Estatus Actual</label>
                    <div class="p-3 rounded-3 {{ $st['bg'] }} d-flex align-items-center gap-3">
                        <i class="bi {{ $st['icon'] }} {{ $st['text'] }} fs-4"></i>
                        <div>
                            <span class="fw-bold d-block {{ $st['text'] }}">{{ $st['label'] }}</span>
                            @if(!empty($profesor->estatus_detalle))
                                <span class="extra-small {{ $st['text'] }} opacity-75 d-block">{{ $profesor->estatus_detalle }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Ubicación y Oficina --}}
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-center gap-3 p-2.5 rounded-3 bg-light border">
                        <div class="icon-box bg-white text-brand rounded-3 p-2 shadow-sm">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <span class="extra-small text-muted text-uppercase fw-semibold d-block">Ubicación Actual</span>
                            <span class="fw-semibold text-dark small">{{ $profesor->ubicacion ?? 'No especificada' }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 p-2.5 rounded-3 bg-light border">
                        <div class="icon-box bg-white text-brand rounded-3 p-2 shadow-sm">
                            <i class="bi bi-door-open-fill"></i>
                        </div>
                        <div>
                            <span class="extra-small text-muted text-uppercase fw-semibold d-block">Oficina de Atención</span>
                            <span class="fw-semibold text-dark small">{{ $profesor->oficina ?? 'No asignada' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-auto pt-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-brand w-100 rounded-3 py-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-pencil-square"></i> Editar Información
                    </a>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Jornada y Horarios --}}
        <div class="col-lg-8">
            
            {{-- Tarjeta de Jornada Laboral --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark mb-0 h6 d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-brand fs-5"></i> Mi Jornada Laboral
                    </h5>
                    <span class="badge bg-light text-muted border extra-small">Horario Regular</span>
                </div>

                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted extra-small text-uppercase fw-semibold d-block">Hora de Entrada</span>
                            <h3 class="fw-bold text-dark mt-1 mb-0">
                                {{ is_object($profesor->entrada) ? $profesor->entrada->format('H:i') : ($profesor->entrada ? date('H:i', strtotime($profesor->entrada)) : '--:--') }}
                            </h3>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="text-muted extra-small text-uppercase fw-semibold d-block">Hora de Salida</span>
                            <h3 class="fw-bold text-dark mt-1 mb-0">
                                {{ is_object($profesor->salida) ? $profesor->salida->format('H:i') : ($profesor->salida ? date('H:i', strtotime($profesor->salida)) : '--:--') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tarjeta de Horarios y Grupos --}}
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 h6 d-flex align-items-center gap-2">
                        <i class="bi bi-calendar3-week text-brand fs-5"></i> Mis Horarios y Grupos
                    </h5>
                    <span class="badge bg-brand-soft text-brand fw-bold rounded-pill px-3 py-1 extra-small">
                        {{ $profesor->horarios ? $profesor->horarios->count() : 0 }} Asignaciones
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($profesor->horarios as $horario)
                        <div class="schedule-item-card p-3 rounded-3 bg-light border transition-all">
                            <div class="row align-items-center g-2">
                                <div class="col-sm-3 col-md-2">
                                    <span class="badge bg-white text-dark border fw-bold px-2 py-2 rounded-2 w-100 text-center shadow-sm">
                                        {{ $horario->dia }}
                                    </span>
                                </div>

                                <div class="col-sm-5 col-md-6">
                                    <h6 class="fw-bold text-dark mb-1">{{ $horario->materia }}</h6>
                                    <div class="extra-small text-muted d-flex align-items-center gap-2">
                                        <span><i class="bi bi-building me-1 text-brand"></i> {{ $horario->edificio }}</span>
                                        <span>·</span>
                                        <span><i class="bi bi-door-closed me-1 text-brand"></i> Aula {{ $horario->aula }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-4 col-md-4 text-sm-end">
                                    <span class="fw-bold text-brand d-block">
                                        {{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_fin, 0, 5) }}
                                    </span>
                                    <span class="badge bg-white text-secondary border extra-small mt-1">
                                        {{ $horario->tipo ?? 'Clase' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
                            <h6 class="fw-bold text-dark">Aún no tienes horarios registrados</h6>
                            <p class="text-muted small mb-0">Cuando se te asignen materias o grupos aparecerán listados aquí.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>

{{-- Estilos personalizados basados en la marca #6f7e49 --}}
<style>
    :root {
        --brand-color: #6f7e49;
        --brand-color-hover: #5b693c;
        --brand-color-light: rgba(111, 126, 73, 0.12);
    }

    .text-brand { color: var(--brand-color) !important; }
    .bg-brand-soft { background-color: var(--brand-color-light) !important; }

    .btn-brand {
        background-color: var(--brand-color);
        color: #ffffff;
        border: none;
    }
    .btn-brand:hover {
        background-color: var(--brand-color-hover);
        color: #ffffff;
    }

    .btn-outline-brand {
        border-color: var(--brand-color);
        color: var(--brand-color);
    }
    .btn-outline-brand:hover {
        background-color: var(--brand-color);
        color: #ffffff;
    }

    .welcome-hero {
        background: linear-gradient(135deg, rgba(111, 126, 73, 0.08) 0%, rgba(255, 255, 255, 1) 100%);
        border: 1px solid rgba(111, 126, 73, 0.15) !important;
    }

    .schedule-item-card:hover {
        background-color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
        border-color: rgba(111, 126, 73, 0.3) !important;
    }

    .icon-box {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Badges de Estatus */
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

    .status-pulse-dot {
        position: absolute;
        border-radius: 50%;
        border: 2px solid #ffffff;
    }

    .extra-small { font-size: 0.72rem; }
    .tracking-wide { letter-spacing: 0.5px; }
</style>
@endsection