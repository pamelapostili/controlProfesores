@extends('layouts.app')

@section('title', $profesor->nombre)

@section('content')
<div class="container py-3">

    {{-- Botón de Regreso --}}
    <div class="mb-3">
        <a href="{{ route('profesores.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            <span>Volver al Directorio</span>
        </a>
    </div>

    @php
        // Mapeo dinámico de estatus con colores y luces de pulso
        $statusConfig = [
            'libre'     => ['bg' => 'bg-emerald-soft', 'text' => 'text-emerald', 'dot' => 'dot-emerald', 'label' => 'Disponible para Atención', 'icon' => 'bi-check-circle-fill'],
            'en_clase'  => ['bg' => 'bg-rose-soft',    'text' => 'text-rose',    'dot' => 'dot-rose',    'label' => 'En Impartición de Clase',  'icon' => 'bi-journal-bookmark-fill'],
            'reunion'   => ['bg' => 'bg-amber-soft',   'text' => 'text-amber',   'dot' => 'dot-amber',   'label' => 'En Reunión Institucional', 'icon' => 'bi-people-fill'],
            'ausente'   => ['bg' => 'bg-slate-soft',   'text' => 'text-slate',   'dot' => 'dot-slate',   'label' => 'Fuera del Campus',         'icon' => 'bi-building-dash']
        ];
        $st = $statusConfig[$profesor->estatus] ?? ['bg' => 'bg-slate-soft', 'text' => 'text-slate', 'dot' => 'dot-slate', 'label' => $profesor->estatus_label ?? ucfirst($profesor->estatus), 'icon' => 'bi-info-circle-fill'];
    @endphp

    {{-- Profile Hero Dashboard Header --}}
    <div class="profile-header-card mb-4">
        {{-- Banner superior decorativo --}}
        <div class="profile-banner">
            <div class="banner-overlay"></div>
        </div>

        <div class="profile-header-body p-4 p-md-5">
            <div class="row align-items-end g-4">
                {{-- Foto y Datos Personales --}}
                <div class="col-lg-7">
                    <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-end gap-4 text-center text-sm-start">
                        <div class="profile-avatar-wrapper">
                            <img src="{{ $profesor->foto ?? 'https://ui-avatars.com/api/?name='.urlencode($profesor->nombre).'&background=6f7e49&color=fff' }}" 
                                 class="profile-avatar" 
                                 alt="{{ $profesor->nombre }}">
                            <span class="pulse-indicator {{ $st['dot'] }}" title="Estatus actual"></span>
                        </div>

                        <div class="profile-main-info">
                            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill {{ $st['bg'] }} {{ $st['text'] }} fw-semibold small mb-2">
                                <i class="bi {{ $st['icon'] }}"></i>
                                <span>{{ $st['label'] }}</span>
                            </div>

                            <h1 class="profile-name mb-1">{{ $profesor->nombre }}</h1>

                            <p class="profile-dept mb-2">
                                <i class="bi bi-mortarboard-fill me-1 text-brand"></i> {{ $profesor->departamento }}
                            </p>

                            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start gap-3 mt-3">
                                <a href="mailto:{{ $profesor->email }}" class="btn-hero-action primary">
                                    <i class="bi bi-envelope-at-fill"></i>
                                    <span>{{ $profesor->email }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tarjetas Rápidas de Jornada --}}
                <div class="col-lg-5">
                    <div class="quick-stats-grid">
                        <div class="quick-stat-box">
                            <span class="stat-caption">Horario Laboral</span>
                            <div class="stat-value">
                                <i class="bi bi-clock-history text-brand me-1"></i>
                                {{ is_object($profesor->entrada) ? $profesor->entrada->format('H:i') : ($profesor->entrada ? date('H:i', strtotime($profesor->entrada)) : '--:--') }}
                                <span class="text-muted fw-normal">a</span>
                                {{ is_object($profesor->salida) ? $profesor->salida->format('H:i') : ($profesor->salida ? date('H:i', strtotime($profesor->salida)) : '--:--') }}
                            </div>
                        </div>

                        <div class="quick-stat-box">
                            <span class="stat-caption">Carga Académica</span>
                            <div class="stat-value">
                                <i class="bi bi-book-half text-brand me-1"></i>
                                {{ $profesor->horarios ? $profesor->horarios->count() : 0 }} <span class="fs-6 fw-normal text-muted">Sesiones</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid Contenido Principal --}}
    <div class="row g-4">
        {{-- Columna Izquierda: Ficha de Ubicación y Estatus --}}
        <div class="col-lg-4">
            <div class="info-card h-100">
                <div class="card-header-styled mb-4">
                    <div class="icon-circle bg-brand-soft text-brand">
                        <i class="bi bi-pin-map-fill"></i>
                    </div>
                    <div>
                        <h3 class="h6 fw-bold text-dark mb-0">Ubicación y Estado</h3>
                        <span class="text-muted extra-small">Localización física en tiempo real</span>
                    </div>
                </div>

                {{-- Banner de Detalle de Estado --}}
                <div class="status-detail-card p-3 rounded-4 mb-4 {{ $st['bg'] }} border-0">
                    <span class="extra-small text-uppercase fw-bold tracking-wide d-block mb-1 {{ $st['text'] }}" style="opacity: 0.8;">
                        Actividad Reportada
                    </span>
                    <p class="fw-semibold {{ $st['text'] }} mb-0 fs-6">
                        {{ $profesor->estatus_detalle ?? 'Sin actividad detallada en este momento.' }}
                    </p>
                </div>

                {{-- Datos de Edificio y Oficina --}}
                <div class="location-list">
                    <div class="location-item">
                        <div class="loc-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <span class="loc-label">Ubicación Actual</span>
                            <span class="loc-value">{{ $profesor->ubicacion ?? 'No especificada' }}</span>
                        </div>
                    </div>

                    <div class="location-item">
                        <div class="loc-icon">
                            <i class="bi bi-door-open-fill"></i>
                        </div>
                        <div>
                            <span class="loc-label">Oficina de Atención</span>
                            <span class="loc-value">{{ $profesor->oficina ?? 'No asignada' }}</span>
                        </div>
                    </div>

                    <div class="location-item">
                        <div class="loc-icon">
                            <i class="bi bi-envelope-check-fill"></i>
                        </div>
                        <div>
                            <span class="loc-label">Correo Institucional</span>
                            <span class="loc-value text-truncate">{{ $profesor->email }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <a href="mailto:{{ $profesor->email }}" class="btn-brand-solid w-100">
                        <i class="bi bi-send-fill me-2"></i> Enviar Mensaje Directo
                    </a>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Timeline del Horario --}}
        <div class="col-lg-8">
            <div class="info-card h-100">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                    <div class="card-header-styled mb-0">
                        <div class="icon-circle bg-brand-soft text-brand">
                            <i class="bi bi-calendar3-week-fill"></i>
                        </div>
                        <div>
                            <h3 class="h6 fw-bold text-dark mb-0">Horario Académico Semanal</h3>
                            <span class="text-muted extra-small">Distribución de clases, laboratorios y asesorías</span>
                        </div>
                    </div>

                    <span class="badge-total-classes">
                        {{ $profesor->horarios ? $profesor->horarios->count() : 0 }} Clases
                    </span>
                </div>

                {{-- Lista Estilizada de Horarios / Timeline --}}
                <div class="timeline-container">
                    @forelse($profesor->horarios as $horario)
                        @php
                            // Mapeo de tipo de clase para cambiar color
                            $tipoClass = match(strtolower($horario->tipo ?? '')) {
                                'asesoría', 'asesoria' => 'type-advisor',
                                'tutoría', 'tutoria'   => 'type-tutoring',
                                default                => 'type-class'
                            };
                        @endphp
                        <div class="timeline-card">
                            <div class="timeline-day-pill">
                                <span class="day-name">{{ $horario->dia }}</span>
                                <span class="day-time">
                                    {{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_fin, 0, 5) }}
                                </span>
                            </div>

                            <div class="timeline-content">
                                <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                    <h4 class="subject-title mb-0">{{ $horario->materia }}</h4>
                                    <span class="type-badge {{ $tipoClass }}">
                                        {{ $horario->tipo ?? 'Clase' }}
                                    </span>
                                </div>

                                <div class="subject-meta">
                                    <span class="meta-item">
                                        <i class="bi bi-building"></i>
                                        <strong>Edificio:</strong> {{ $horario->edificio }}
                                    </span>
                                    <span class="meta-divider">•</span>
                                    <span class="meta-item">
                                        <i class="bi bi-door-closed"></i>
                                        <strong>Aula:</strong> {{ $horario->aula }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-schedule-box">
                            <i class="bi bi-calendar-x display-5 text-muted mb-3 d-block"></i>
                            <h5 class="fw-bold text-dark">Sin Horario Registrado</h5>
                            <p class="text-muted small mb-0">Este docente no cuenta con asignaturas o asesorías programadas en el sistema.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hoja de Estilos CSS Optimizada --}}
<style>
    :root {
        --brand: #6f7e49;
        --brand-dark: #586538;
        --brand-light: #edf2df;
        --brand-soft: rgba(111, 126, 73, 0.12);
        --bg-canvas: #f8faf6;
    }

    body {
        background-color: var(--bg-canvas);
    }

    .text-brand { color: var(--brand) !important; }
    .bg-brand-soft { background-color: var(--brand-soft) !important; }

    /* Botón de Regreso */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        background-color: #ffffff;
        color: #495057;
        font-weight: 600;
        font-size: 0.875rem;
        border-radius: 50rem;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        background-color: var(--brand-light);
        color: var(--brand-dark);
        border-color: var(--brand);
        transform: translateX(-3px);
    }

    /* Targeta Header Perfil */
    .profile-header-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 12px 30px rgba(0,0,0,0.04);
        overflow: hidden;
        position: relative;
    }
    .profile-banner {
        height: 120px;
        background: linear-gradient(135deg, #6f7e49 0%, #3e4827 100%);
        position: relative;
    }
    .banner-overlay {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px);
        background-size: 16px 16px;
    }

    .profile-header-body {
        margin-top: -50px;
        position: relative;
        z-index: 2;
    }

    /* Avatar */
    .profile-avatar-wrapper {
        position: relative;
        display: inline-block;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ffffff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        background: #ffffff;
    }
    .pulse-indicator {
        position: absolute;
        bottom: 6px;
        right: 6px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid #ffffff;
    }

    .profile-name {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.02em;
    }
    .profile-dept {
        font-size: 0.95rem;
        color: #64748b;
        font-weight: 500;
    }

    .btn-hero-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-hero-action.primary {
        background-color: var(--brand-light);
        color: var(--brand-dark);
        border: 1px solid rgba(111, 126, 73, 0.2);
    }
    .btn-hero-action.primary:hover {
        background-color: var(--brand);
        color: #ffffff;
    }

    /* Quick Stats Grid */
    .quick-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .quick-stat-box {
        background: #f8faf6;
        border: 1px solid #e6ede0;
        padding: 16px;
        border-radius: 16px;
        text-align: center;
    }
    .stat-caption {
        font-size: 0.72rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: #64748b;
        display: block;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
    }

    /* Tarjetas Modulares */
    .info-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    .card-header-styled {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    /* Lista de Ubicación */
    .location-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .location-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px;
        border-radius: 14px;
        background: #f8faf6;
        border: 1px solid #edf2e8;
    }
    .loc-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #ffffff;
        color: var(--brand);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .loc-label {
        display: block;
        font-size: 0.72rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #94a3b8;
    }
    .loc-value {
        font-size: 0.92rem;
        font-weight: 700;
        color: #1e293b;
    }

    .btn-brand-solid {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        background-color: var(--brand);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.9rem;
        border-radius: 12px;
        text-decoration: none;
        border: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(111, 126, 73, 0.25);
    }
    .btn-brand-solid:hover {
        background-color: var(--brand-dark);
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Timeline de Horarios */
    .badge-total-classes {
        background-color: var(--brand-light);
        color: var(--brand-dark);
        font-weight: 700;
        font-size: 0.8rem;
        padding: 6px 14px;
        border-radius: 50rem;
    }

    .timeline-container {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .timeline-card {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 16px;
        border-radius: 16px;
        background: #f8faf6;
        border: 1px solid #e8efe3;
        transition: all 0.25s ease;
    }
    @media (min-width: 576px) {
        .timeline-card {
            flex-direction: row;
            align-items: center;
        }
    }
    .timeline-card:hover {
        background: #ffffff;
        border-color: var(--brand);
        box-shadow: 0 8px 24px rgba(111, 126, 73, 0.12);
        transform: translateX(4px);
    }

    .timeline-day-pill {
        min-width: 120px;
        background: #ffffff;
        padding: 10px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .day-name {
        display: block;
        font-weight: 800;
        color: #1e293b;
        font-size: 0.9rem;
    }
    .day-time {
        display: block;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--brand);
    }

    .timeline-content {
        flex-grow: 1;
    }
    .subject-title {
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f172a;
    }

    .type-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 50rem;
        text-transform: uppercase;
    }
    .type-class { background-color: #dbeafe; color: #1e40af; }
    .type-advisor { background-color: #fef3c7; color: #92400e; }
    .type-tutoring { background-color: #f3e8ff; color: #6b21a8; }

    .subject-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        color: #64748b;
        margin-top: 4px;
    }
    .meta-divider { color: #cbd5e1; }

    /* Estatus Dinámicos */
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

    .extra-small { font-size: 0.72rem; }
    .tracking-wide { letter-spacing: 0.05em; }

    .empty-schedule-box {
        text-align: center;
        padding: 48px 20px;
        background: #f8faf6;
        border-radius: 16px;
        border: 2px dashed #e2e8f0;
    }
</style>
@endsection