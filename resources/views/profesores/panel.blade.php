@extends('layouts.app')

@section('title', 'Inicio | Profesor')

@section('content')

<style>
/* Contenedor de las notificaciones */
#notificacionesWrapper {
    position: relative;
    z-index: 9999;
}

/* Panel desplegable */
#notificacionesPanel {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    z-index: 10000;
}

/* Evitar que el banner recorte el panel */
.welcome-banner {
    overflow: visible !important;
}

/* Mantener el contenido de las tarjetas debajo */

/* CONTENEDOR */
.notificaciones-wrapper {
    position: relative;
    display: inline-flex;
    z-index: 1000;
}

/* BOTÓN DE CAMPANA */
.notificaciones-toggle {
    position: relative;
    width: 46px;
    height: 46px;
    border: 1px solid #e5e9df;
    border-radius: 14px;
    background: #ffffff;
    color: #53643b;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .25s ease;
}

.notificaciones-toggle:hover {
    background: #f2f5eb;
    border-color: #b9d27b;
    transform: translateY(-2px);
}

.notificaciones-toggle svg {
    width: 22px;
    height: 22px;
}

/* CONTADOR */
.notificaciones-contador {
    position: absolute;
    top: -6px;
    right: -6px;
    min-width: 20px;
    height: 20px;
    padding: 0 5px;
    border: 2px solid white;
    border-radius: 20px;
    background: #e74c3c;
    color: white;
    font-size: 10px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* PANEL */
.notificaciones-panel {
    position: absolute;
    top: calc(100% + 14px);
    right: 0;
    width: 390px;
    max-width: calc(100vw - 30px);
    background: #ffffff;
    border: 1px solid #e9ede4;
    border-radius: 18px;
    box-shadow: 0 16px 50px rgba(36, 48, 25, .15);
    overflow: hidden;
    animation: notificacionesEntrada .22s ease;
}

.notificaciones-panel[hidden] {
    display: none;
}

@keyframes notificacionesEntrada {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ENCABEZADO */
.notificaciones-header {
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 1px solid #edf0e9;
}

.notificaciones-header h3 {
    margin: 0;
    color: #263321;
    font-size: 17px;
    font-weight: 750;
}

.notificaciones-header p {
    margin: 5px 0 0;
    color: #879080;
    font-size: 12px;
}

.notificaciones-header strong {
    color: #657d43;
}

.notificaciones-cerrar {
    border: none;
    background: transparent;
    color: #879080;
    font-size: 26px;
    cursor: pointer;
    line-height: 1;
}

.notificaciones-cerrar:hover {
    color: #263321;
}

/* LISTA */
.notificaciones-lista {
    max-height: 420px;
    overflow-y: auto;
}

.notificacion-item {
    display: flex;
    gap: 13px;
    padding: 17px 19px;
    border-bottom: 1px solid #f0f2ed;
    transition: background .2s ease;
}

.notificacion-item:hover {
    background: #f8faf5;
}

.notificacion-item.no-leida {
    background: #f7f9f2;
}

.notificacion-item.no-leida:hover {
    background: #f0f4e8;
}

/* ICONO */
.notificacion-icono {
    width: 39px;
    height: 39px;
    flex-shrink: 0;
    border-radius: 12px;
    background: #eaf0dc;
    color: #687f45;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notificacion-icono svg {
    width: 20px;
    height: 20px;
}

/* CONTENIDO */
.notificacion-contenido {
    flex: 1;
    min-width: 0;
}

.notificacion-titulo {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.notificacion-titulo h4 {
    margin: 0;
    color: #293526;
    font-size: 13px;
    font-weight: 700;
}

.notificacion-contenido p {
    margin: 7px 0;
    color: #70796b;
    font-size: 12px;
    line-height: 1.6;
}

.notificacion-punto {
    width: 8px;
    height: 8px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #7d9c4e;
}

.notificacion-detalles {
    margin-top: 7px;
    color: #687f45;
    font-size: 11px;
    font-weight: 600;
}

/* PIE DE NOTIFICACIÓN */
.notificacion-pie {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
}

.notificacion-pie small {
    color: #9aa194;
    font-size: 10px;
}

.notificacion-marcar {
    border: none;
    background: transparent;
    color: #70894a;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
    padding: 4px 0;
}

.notificacion-marcar:hover {
    color: #435b27;
    text-decoration: underline;
}

.notificacion-estado {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    color: #899383;
    font-size: 10px;
}

.notificacion-estado svg {
    width: 13px;
    height: 13px;
}

/* ESTADO VACÍO */
.notificaciones-vacio {
    padding: 40px 20px;
    text-align: center;
}

.notificaciones-vacio-icono {
    width: 65px;
    height: 65px;
    margin: 0 auto 15px;
    border-radius: 50%;
    background: #f0f4e8;
    color: #78924e;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notificaciones-vacio-icono svg {
    width: 29px;
    height: 29px;
}

.notificaciones-vacio h4 {
    margin: 0;
    color: #35432e;
    font-size: 15px;
}

.notificaciones-vacio p {
    margin: 8px 0 0;
    color: #929a8b;
    font-size: 12px;
}

/* PIE DEL PANEL */
.notificaciones-footer {
    padding: 12px;
    text-align: center;
    background: #fafbf8;
    border-top: 1px solid #edf0e9;
}

.notificaciones-footer span {
    color: #9aa194;
    font-size: 10px;
}

/* MÓVIL */
@media (max-width: 480px) {
    .notificaciones-panel {
        position: fixed;
        top: 75px;
        left: 12px;
        right: 12px;
        width: auto;
        max-width: none;
    }

    .notificaciones-lista {
        max-height: calc(100vh - 180px);
    }
}

.horario-compacto {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    margin-top: 10px;
    border: 1px solid #e8ebdf;
    border-radius: 14px;
    background: #fff;
    transition: background .2s, border-color .2s;
}

.horario-compacto:hover {
    background: #fafbf7;
    border-color: #cbd5b9;
}

.horario-compacto-icono {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 11px;
    background: #f4f6ef;
    color: #6f7e49;
    font-size: 1.1rem;
}

.horario-compacto-info {
    flex: 1;
    min-width: 0;
}

.horario-compacto-titulo {
    font-weight: 700;
    font-size: .95rem;
    overflow-wrap: anywhere;
}

.horario-compacto-detalle {
    display: flex;
    flex-wrap: wrap;
    gap: 4px 14px;
    margin-top: 3px;
    color: #777e70;
    font-size: .78rem;
}

.horario-compacto-horas {
    flex-shrink: 0;
    padding: 6px 9px;
    border-radius: 9px;
    background: #edf2e5;
    color: #53663a;
    font-size: .8rem;
    font-weight: 700;
    white-space: nowrap;
}

@media (max-width: 650px) {
    .horario-compacto {
        flex-wrap: wrap;
    }

    .horario-compacto-info {
        flex-basis: calc(100% - 55px);
    }

    .horario-compacto-horas {
        margin-left: 50px;
    }
}

/* Modal de edición del perfil con scroll interno */
#editarProfesorModal .modal-dialog {
    height: calc(100vh - 2rem);
    max-height: calc(100vh - 2rem);
    margin: 1rem auto;
}

#editarProfesorModal .modal-content {
    height: 100%;
    max-height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-radius: 22px;
}

/* El encabezado permanece visible */
#editarProfesorModal .modal-header-uni {
    flex-shrink: 0;
}

/* El formulario ocupa el espacio disponible */
#editarProfesorModal form {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    min-height: 0;
    overflow: hidden;
}

/* Scroll de los campos de edición */
#editarProfesorModal .modal-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    overscroll-behavior: contain;
    scrollbar-width: thin;
    scrollbar-color: #8b9873 #f1f3ec;
}

#editarProfesorModal .modal-body::-webkit-scrollbar {
    width: 9px;
}

#editarProfesorModal .modal-body::-webkit-scrollbar-track {
    background: #f1f3ec;
    border-radius: 10px;
}

#editarProfesorModal .modal-body::-webkit-scrollbar-thumb {
    background: #8b9873;
    border-radius: 10px;
}

#editarProfesorModal .modal-body::-webkit-scrollbar-thumb:hover {
    background: #6f7e49;
}

/* Botones siempre visibles al pie */
#editarProfesorModal .modal-footer {
    flex-shrink: 0;
    display: flex !important;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    padding: 14px 24px;
    background: #fff;
    border-top: 1px solid #dee2e6;
    position: relative;
    z-index: 2;
}

#editarProfesorModal .modal-footer button {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    visibility: visible !important;
    opacity: 1 !important;
}

#editarProfesorModal .btn-cancelar {
    background: #f1f2ed;
    color: #34402d;
    border: 1px solid #d5d9ce;
}

#editarProfesorModal .btn-cancelar:hover {
    background: #e3e6dc;
    color: #34402d;
}

@media (max-width: 576px) {
    #editarProfesorModal .modal-dialog {
        height: calc(100vh - 1rem);
        max-height: calc(100vh - 1rem);
        margin: .5rem;
    }

    #editarProfesorModal .modal-footer {
        padding: 12px;
        flex-wrap: wrap;
    }
}

    :root {
        --uni-green: #6f7e49;
        --uni-dark: #34402d;
        --uni-light: #f4f6ef;
        --uni-border: #e8ebdf;
    }

    .teacher-dashboard {
        color: #30382e;
    }

    .teacher-dashboard .welcome-banner {
        background: #6f7e49;
        color: white;
        border-radius: 24px;
        padding: 32px;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border: 35px solid rgba(255,255,255,.08);
        border-radius: 50%;
        right: -55px;
        top: -90px;
        pointer-events: none;
    }

    .welcome-banner .welcome-content {
        position: relative;
        z-index: 1;
    }

    .teacher-dashboard .eyebrow {
        font-size: .75rem;
        letter-spacing: 2px;
        font-weight: 800;
        text-transform: uppercase;
        opacity: .85;
    }

    .teacher-dashboard .custom-card {
        border: 1px solid var(--uni-border);
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 5px 22px rgba(44, 55, 35, .045);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .teacher-dashboard .custom-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(44, 55, 35, .09);
    }

    .teacher-dashboard .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: 1.35rem;
        background: var(--uni-light);
        color: var(--uni-green);
        flex-shrink: 0;
    }

    .teacher-dashboard .profile-avatar {
        width: 108px;
        height: 108px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 0 0 2px #dfe5d3;
    }

    .teacher-dashboard .profile-placeholder {
        width: 108px;
        height: 108px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--uni-light);
        color: var(--uni-green);
        font-size: 3rem;
        border: 4px solid white;
        box-shadow: 0 0 0 2px #dfe5d3;
    }

    .teacher-dashboard .section-title {
        font-size: 1.15rem;
        font-weight: 750;
        letter-spacing: -.3px;
    }

    .teacher-dashboard .muted-label {
        color: #899080;
        font-size: .72rem;
        letter-spacing: 1px;
        font-weight: 750;
        text-transform: uppercase;
    }

    .teacher-dashboard .info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 18px;
    }

    .teacher-dashboard .info-row:last-child {
        margin-bottom: 0;
    }

    .teacher-dashboard .info-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--uni-light);
        color: var(--uni-green);
        border-radius: 11px;
        flex-shrink: 0;
    }

    .teacher-dashboard .schedule-item {
        border: 1px solid var(--uni-border);
        border-radius: 15px;
        padding: 18px;
        transition: background .2s, border-color .2s;
    }

    .teacher-dashboard .schedule-item:hover {
        background: #fafbf7;
        border-color: #cbd5b9;
    }

    .teacher-dashboard .time-pill {
        background: #edf2e5;
        color: #6f7e49;
        border-radius: 10px;
        padding: 7px 11px;
        font-size: .85rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .teacher-dashboard .btn-uni {
        background: var(--uni-green);
        color: white;
        border: 1px solid var(--uni-green);
    }

    .teacher-dashboard .btn-uni:hover {
        background: #6f7e49;
        color: white;
    }

    .teacher-dashboard .empty-state {
        background: #fafbf7;
        border: 1px dashed #d9dfce;
        border-radius: 16px;
        padding: 30px 15px;
        text-align: center;
    }

    .teacher-dashboard .modal-content {
        border: 0;
        border-radius: 22px;
        overflow: hidden;
    }

    .teacher-dashboard .modal-header-uni {
        background: #6f7e49;
        color: white;
        padding: 24px;
    }

    .teacher-dashboard .form-control:focus,
    .teacher-dashboard .form-select:focus {
        border-color: #6f7e49;
        box-shadow: 0 0 0 .2rem rgba(111,126,73,.15);
    }

    @media (max-width: 576px) {
        .teacher-dashboard .welcome-banner {
            padding: 24px 20px;
        }

        .teacher-dashboard .schedule-heading {
            align-items: flex-start !important;
            flex-direction: column;
        }
    }
</style>

<div class="container py-4 py-lg-5 teacher-dashboard">

    {{-- Mensajes de respuesta --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm"
             role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-4 border-0 shadow-sm">
            <strong>Revisa los datos del formulario:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Bienvenida --}}
    <div class="welcome-banner mb-4">
        <div class="welcome-content d-flex flex-wrap justify-content-between align-items-center gap-4">
            <div>
                <div class="eyebrow mb-3">
                    <i class="bi bi-mortarboard-fill me-2"></i>
                    Panel de Control de Profesores
                </div>

                <h1 class="fw-bold mb-2">
                    ¡Hola, {{ $profesor->nombre }}!
                </h1>

                <p class="mb-0 text-white-100">
                    Bienvenido a tu espacio de trabajo.
                    Consulta tu jornada y organiza tus horarios.
                </p>
            </div>

        <div class="d-flex align-items-center gap-3">

            {{-- Botón Editar Perfil --}}
            <button type="button"
                    class="btn btn-light rounded-pill px-4 py-2 fw-semibold"
                    data-bs-toggle="modal"
                    data-bs-target="#editarProfesorModal">
                <i class="bi bi-pencil-square me-2"></i>
                Editar Perfil
            </button>

            {{-- Notificaciones --}}
            <div class="notificaciones-wrapper" id="notificacionesWrapper">

                <!-- Botón de notificaciones -->
                <button
                    type="button"
                    class="notificaciones-toggle"
                    id="notificacionesToggle"
                    aria-label="Abrir notificaciones"
                    aria-expanded="false"
                    aria-controls="notificacionesPanel"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>

                    @if ($notificacionesNoLeidas->count() > 0)
                        <span class="notificaciones-contador">
                            {{ $notificacionesNoLeidas->count() > 99 ? '99+' : $notificacionesNoLeidas->count() }}
                        </span>
                    @endif
                </button>

                <!-- Panel desplegable -->
                <div
                    class="notificaciones-panel"
                    id="notificacionesPanel"
                    aria-hidden="true"
                    hidden
                >

                    <div class="notificaciones-header">
                        <div>
                            <h3>Notificaciones</h3>
                            <p>
                                Tienes
                                <strong>{{ $notificacionesNoLeidas->count() }}</strong>
                                pendientes de leer
                            </p>
                        </div>

                        <button
                            type="button"
                            class="notificaciones-cerrar"
                            id="notificacionesCerrar"
                            aria-label="Cerrar notificaciones"
                        >
                            &times;
                        </button>
                    </div>

                    <div class="notificaciones-lista">

                        @forelse ($notificaciones as $notificacion)

                            <div class="notificacion-item {{ $notificacion->read_at ? 'leida' : 'no-leida' }}">

                                <div class="notificacion-icono">
                                    @if (($notificacion->data['tipo'] ?? '') === 'clase_proxima')
                                        <svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="5" width="18" height="16" rx="2"/>
                                            <path d="M16 3v4M8 3v4M3 10h18"/>
                                            <path d="m9 15 2 2 4-4"/>
                                        </svg>
                                    @else
                                        <svg viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.8">
                                            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                                        </svg>
                                    @endif
                                </div>

                                <div class="notificacion-contenido">

                                    <div class="notificacion-titulo">
                                        <h4>
                                            {{ $notificacion->data['titulo'] ?? 'Notificación' }}
                                        </h4>

                                        @if (!$notificacion->read_at)
                                            <span class="notificacion-punto"></span>
                                        @endif
                                    </div>

                                    <p>
                                        {{ $notificacion->data['mensaje'] ?? '' }}
                                    </p>

                                    @if (isset($notificacion->data['aula']))
                                        <div class="notificacion-detalles">
                                            <span>
                                                {{ $notificacion->data['edificio'] ?? '' }}
                                                · Aula {{ $notificacion->data['aula'] }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="notificacion-pie">
                                        <small>
                                            {{ $notificacion->created_at->diffForHumans() }}
                                        </small>

                                        @if (!$notificacion->read_at)
                                            <form
                                                action="{{ route('profesor.notificaciones.leer', $notificacion->id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="notificacion-marcar">
                                                    Marcar como leída
                                                </button>
                                            </form>
                                        @else
                                            <span class="notificacion-estado">
                                                <svg viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path d="m5 12 4 4L19 6"/>
                                                </svg>
                                                Leída
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                        @empty

                            <div class="notificaciones-vacio">
                                <div class="notificaciones-vacio-icono">
                                    <svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                                        <path d="M10 21h4"/>
                                    </svg>
                                </div>

                                <h4>¡Todo al día!</h4>
                                <p>No tienes notificaciones por el momento.</p>
                            </div>

                        @endforelse

                    </div>

                    <div class="notificaciones-footer">
                        <span>Notificaciones de tu actividad académica</span>
                    </div>

                </div>
            </div>
 
        </div> {{-- Cierre notificaciones-wrapper --}}

    </div> {{-- Cierre contenedor de botones --}}

</div>

{{-- Indicadores --}}
@php
    use Illuminate\Support\Carbon;

    // Fecha y hora actuales
    $ahora = now();
    $horaActual = $ahora->format('H:i:s');

    // Día actual en español: lunes, martes, miércoles...
    $diaActual = mb_strtolower($ahora->locale('es')->dayName);

    // Normalizar texto para comparar los días
    $normalizarDia = function ($dia) {
        $dia = mb_strtolower(trim($dia));

        return str_replace(
            ['á', 'é', 'í', 'ó', 'ú'],
            ['a', 'e', 'i', 'o', 'u'],
            $dia
        );
    };

    // Obtener solamente los horarios del profesor correspondientes a hoy
    $horariosDeHoy = $profesor->horarios
        ->filter(function ($horario) use ($diaActual, $normalizarDia) {

            if (!$horario->dia || !$horario->hora_inicio || !$horario->hora_fin) {
                return false;
            }

            return $normalizarDia($horario->dia) ===
                   $normalizarDia($diaActual);
        })
        ->sortBy('hora_inicio')
        ->values();

    // CLASE ACTUAL
    $claseActual = $horariosDeHoy->first(function ($horario) use ($horaActual) {

        $inicio = Carbon::parse($horario->hora_inicio)->format('H:i:s');
        $fin = Carbon::parse($horario->hora_fin)->format('H:i:s');

        return $horaActual >= $inicio && $horaActual < $fin;
    });

    // SIGUIENTE CLASE
    $siguienteClase = $horariosDeHoy->first(function ($horario) use ($horaActual) {

        $inicio = Carbon::parse($horario->hora_inicio)->format('H:i:s');

        return $inicio > $horaActual;
    });
@endphp
<div class="row g-3 mb-4 w-100 mx-0">

    {{-- Clase actual --}}
    <div class="col-12 col-md-6">
        <div class="custom-card p-3 h-100 w-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-book-half"></i>
                </div>

                <div class="min-w-0">
                    <div class="muted-label">Clase actual</div>

                    @if($claseActual)
                        <div class="fw-bold text-truncate">
                            {{ $claseActual->materia }}
                        </div>

                        <small class="text-secondary">
                            {{ \Illuminate\Support\Carbon::parse($claseActual->hora_inicio)->format('H:i') }}
                            –
                            {{ \Illuminate\Support\Carbon::parse($claseActual->hora_fin)->format('H:i') }}
                        </small>
                    @else
                        <div class="fw-bold">Sin Clase Ahora</div>
                        <small class="text-secondary">
                            No hay clase asignada en este horario
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Siguiente clase --}}
    <div class="col-12 col-md-6">
        <div class="custom-card p-3 h-100 w-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon">
                    <i class="bi bi-calendar2-event"></i>
                </div>

                <div class="min-w-0">
                    <div class="muted-label">Siguiente clase</div>

                    @if($siguienteClase)
                        <div class="fw-bold text-truncate">
                            {{ $siguienteClase->materia }}
                        </div>

                        <small class="text-secondary">
                            {{ \Illuminate\Support\Carbon::parse($siguienteClase->hora_inicio)->format('H:i') }}
                            –
                            {{ \Illuminate\Support\Carbon::parse($siguienteClase->hora_fin)->format('H:i') }}
                        </small>
                    @else
                        <div class="fw-bold">Sin Más Clases</div>
                        <small class="text-secondary">
                            No quedan clases posteriores
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

    <div class="row g-4">

        {{-- Perfil --}}
        <div class="col-lg-4">
            <div class="custom-card p-4 h-100">

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h2 class="section-title mb-0">Mi Perfil</h2>
                    <i class="bi bi-person-badge fs-4 text-secondary"></i>
                </div>

                <div class="text-center mb-4">
@if($profesor->foto)
    <img
        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($profesor->foto) }}"
        alt="Foto de {{ $profesor->nombre }}"
        class="profile-avatar mb-3"
        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

    <div class="profile-placeholder mx-auto mb-3"
         style="display:none;">
        <i class="bi bi-person"></i>
    </div>
@else
    <div class="profile-placeholder mx-auto mb-3">
        <i class="bi bi-person"></i>
    </div>
@endif

                    <h4 class="fw-bold mb-1">{{ $profesor->nombre }}</h4>

                    <p class="text-secondary mb-3">
                        {{ $profesor->departamento ?: 'Departamento no asignado' }}
                    </p>

                    <span class="badge rounded-pill px-3 py-2
                        {{ strtolower($profesor->estatus ?? '') === 'activo'
                            ? 'bg-success-subtle text-success'
                            : 'bg-secondary-subtle text-secondary' }}">
                        <i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i>
                        {{ $profesor->estatus ?: 'Sin estatus' }}
                    </span>
                </div>

                <hr class="border-light">

                <div class="info-row">
                    <div class="info-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="muted-label mb-1">Correo electrónico</div>
                        <div class="text-break">
                            {{ $profesor->email ?: 'No registrado' }}
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <div class="muted-label mb-1">Ubicación</div>
                        <div>{{ $profesor->ubicacion ?: 'No asignada' }}</div>
                    </div>
                </div>

                <button type="button"
                        class="btn btn-uni rounded-pill w-100 py-2 mt-3"
                        data-bs-toggle="modal"
                        data-bs-target="#editarProfesorModal">
                    <i class="bi bi-pencil me-2"></i>
                    Actualizar Información
                </button>

            </div>
        </div>

        {{-- Jornada y horarios --}}
        <div class="col-lg-8">

            <div class="custom-card p-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="stat-icon">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                    <div>
                        <h2 class="section-title mb-1">Mi Jornada Laboral</h2>
                        <p class="text-secondary small mb-0">
                            Consulta tus horarios registrados de trabajo
                        </p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-4" style="background:#f5f7f0">
                            <div class="muted-label mb-2">
                                <i class="bi bi-sunrise me-1"></i> Hora Entrada
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-success fs-4"></i>
                                <span class="fs-2 fw-bold">
                                    {{ $profesor->entrada?->format('H:i') ?? '--:--' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="p-3 rounded-4" style="background:#f5f7f0">
                            <div class="muted-label mb-2">
                                <i class="bi bi-sunset me-1"></i> Hora Salida
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock-history text-success fs-4"></i>
                                <span class="fs-2 fw-bold">
                                    {{ $profesor->salida?->format('H:i') ?? '--:--' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
    <div>
        <h2 class="section-title mb-1">Mis Horarios y Grupos</h2>
        <p class="text-secondary small mb-0">
            Consulta, modifica y organiza tus materias y espacios asignados.
        </p>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-2">
        <span class="badge rounded-pill px-3 py-3"
              style="background:#edf2e5;color:#53663a">
            {{ $profesor->horarios->count() }}
            {{ $profesor->horarios->count() === 1 ? 'Horario' : 'Horarios' }}
        </span>

        <button type="button"
                class="btn btn-uni rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#editarProfesorModal">
            Editar Horarios
        </button>
    </div>
</div>

<div class="row g-3 mt-1">
    @forelse($profesor->horarios as $horario)
        <div class="col-12 col-md-6">
            <div class="horario-compacto h-100">
                <div class="horario-compacto-icono">
                    <i class="bi bi-book"></i>
                </div>

                <div class="horario-compacto-info">
                    <div class="horario-compacto-titulo">
                        {{ $horario->materia }}
                    </div>

                    <div class="horario-compacto-detalle">
                        <span>
                            <i class="bi bi-people me-1"></i>
                            Grupo: {{ $horario->grupo ?: 'Sin asignar' }}
                        </span>

                        <span>
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $horario->edificio ?: 'Sin edificio' }}
                            · Aula {{ $horario->aula ?: 'Sin asignar' }}
                        </span>
                        <span>
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $horario->dia ?: 'Día no asignado' }}
                        </span>
                    </div>

                    <div class="horario-compacto-horas mt-2 d-inline-block">
                        <i class="bi bi-clock me-1"></i>
                        {{ \Illuminate\Support\Carbon::parse($horario->hora_inicio)->format('H:i') }}
                        – {{ \Illuminate\Support\Carbon::parse($horario->hora_fin)->format('H:i') }}
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state mt-2">
                <i class="bi bi-calendar-x fs-2" style="color:#8b9873"></i>
                <p class="fw-bold mt-2 mb-1">Todavía no tienes horarios</p>
                <p class="text-secondary small mb-0">
                    Agrega una materia y su horario para comenzar.
                </p>
            </div>
        </div>
    @endforelse
</div>


            </div>
        </div>
    </div>
</div>

{{-- MODAL PARA EDITAR EL PERFIL --}}
<div class="modal fade teacher-dashboard"
     id="editarProfesorModal"
     tabindex="-1"
     aria-labelledby="editarProfesorModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header-uni d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="eyebrow mb-1" id="editarProfesorModalLabel">
                        Editar Mi Perfil
                    </h4>
                    <p class="text-white-800 small mb-0">
                        Actualiza tus datos personales
                    </p>
                </div>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
            </div>


<form method="POST"
      action="{{ route('profesor.perfil.actualizar') }}"
      enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    {{-- Confirma que el formulario incluye la lista de horarios --}}
    <input type="hidden" name="horarios_present" value="1">


                <div class="modal-body p-4">

                    {{-- DATOS PERSONALES --}}
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-person-circle me-2 text-success"></i>
                        Información Personal
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold">
                                Nombre Completo
                            </label>
                            <input type="text"
                                   id="nombre"
                                   name="nombre"
                                   class="form-control rounded-3"
                                   value="{{ old('nombre', $profesor->nombre) }}"
                                   maxlength="255"
                                   >
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                Correo Electrónico
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control rounded-3"
                                   value="{{ old('email', $profesor->email) }}"
                                   maxlength="255"
                                   >
                        </div>

                        <div class="col-md-6">
                            <label for="departamento" class="form-label fw-semibold">
                                Departamento
                            </label>
                            <input type="text"
                                   id="departamento"
                                   name="departamento"
                                   class="form-control rounded-3"
                                   value="{{ old('departamento', $profesor->departamento) }}"
                                   maxlength="255">
                        </div>

<div class="col-md-6">
    <label for="estatus" class="form-label fw-semibold">
        Estatus
    </label>

    <select id="estatus"
            name="estatus"
            class="form-select rounded-3"
            >

        <option value=""
            disabled
            {{ old('estatus', $profesor->estatus) ? '' : 'selected' }}>
            Selecciona un estatus
        </option>

        @foreach([
            'En Clase',
            'Libre',
            'Horario de Comida',
            'Ya No Tarda en Llegar',
            'Fin Jornada',
            'Está Cerca',
            'Ocupado',
        ] as $opcion)
            <option value="{{ $opcion }}"
                {{ old('estatus', $profesor->estatus) === $opcion ? 'selected' : '' }}>
                {{ $opcion }}
            </option>
        @endforeach
    </select>
</div>

                        <div class="col-12">
                            <label for="ubicacion" class="form-label fw-semibold">
                                Ubicación
                            </label>
                            <input type="text"
                                   id="ubicacion"
                                   name="ubicacion"
                                   class="form-control rounded-3"
                                   value="{{ old('ubicacion', $profesor->ubicacion) }}"
                                   maxlength="255">
                        </div>

                        <div class="col-12">
                            <label for="foto" class="form-label fw-semibold">
                                Foto de Perfil
                            </label>

@if($profesor->foto)
    <div class="mb-3">
        <img
            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($profesor->foto) }}"
            alt="Foto actual de {{ $profesor->nombre }}"
            class="rounded-circle"
            style="width:80px;height:80px;object-fit:cover"
            onerror="this.style.display='none';">
    </div>
@endif

                            <input type="file"
                                   id="foto"
                                   name="foto"
                                   class="form-control rounded-3"
                                   accept="image/jpeg,image/png,image/webp">

                            <small class="text-secondary">
                                Formatos JPG, PNG o WEBP. Máximo 2 MB.
                                Deja el campo vacío para conservar tu foto actual.
                            </small>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- JORNADA LABORAL --}}
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-clock-history me-2 text-success"></i>
                        Jornada laboral
                    </h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="entrada" class="form-label fw-semibold">
                                Hora de Entrada
                            </label>
                            <input type="time"
                                   id="entrada"
                                   name="entrada"
                                   class="form-control rounded-3"
                                   value="{{ old('entrada', $profesor->entrada ? \Illuminate\Support\Carbon::parse($profesor->entrada)->format('H:i') : '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="salida" class="form-label fw-semibold">
                                Hora de Salida
                            </label>
                            <input type="time"
                                   id="salida"
                                   name="salida"
                                   class="form-control rounded-3"
                                   value="{{ old('salida', $profesor->salida ? \Illuminate\Support\Carbon::parse($profesor->salida)->format('H:i') : '') }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- HORARIOS Y GRUPOS --}}
                    <div class="d-flex flex-wrap justify-content-between
                                align-items-center gap-2 mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="bi bi-calendar-week me-2 text-success"></i>
                                Mis Horarios y Grupos
                            </h5>
                            <p class="text-secondary small mb-0">
                                Modifica los existentes o agrega una nueva materia.
                            </p>
                        </div>

                        <button type="button"
                                class="btn btn-outline-success rounded-pill"
                                id="agregarHorario">
                            <i class="bi bi-plus-lg me-1"></i>
                            Nuevo Horario
                        </button>
                    </div>

                    <div id="listaHorarios">
                        @foreach(old('horarios', $profesor->horarios) as $i => $horario)
                            <div class="border rounded-4 p-3 mb-3 horario-form">
                                <input type="hidden"
                                       name="horarios[{{ $i }}][id]"
                                       value="{{ old("horarios.$i.id", data_get($horario, 'id')) }}">

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <strong>Horario <span class="numero-horario">{{ $i + 1 }}</span></strong>

                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger rounded-pill quitar-horario">
                                        <i class="bi bi-trash me-1"></i> Quitar
                                    </button>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Materia</label>
                                        <input type="text"
                                               name="horarios[{{ $i }}][materia]"
                                               class="form-control"
                                               value="{{ old("horarios.$i.materia", data_get($horario, 'materia')) }}"
                                               maxlength="255"
                                               >
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Grupo</label>
                                        <input
                                            type="text"
                                            name="horarios[{{ $i }}][grupo]"
                                            class="form-control"
                                            value="{{ old("horarios.$i.grupo", data_get($horario, 'grupo')) }}"
                                            maxlength="100"
                                            placeholder="Ej. 10D, 3A, 5B"
                                            pattern="(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]+"
                                            title="Ingresa letras y números, por ejemplo: 10D"
                                        >
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Edificio</label>
                                        <input type="text"
                                               name="horarios[{{ $i }}][edificio]"
                                               class="form-control"
                                               value="{{ old("horarios.$i.edificio", data_get($horario, 'edificio')) }}"
                                               maxlength="100">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Aula</label>
                                        <input type="text"
                                               name="horarios[{{ $i }}][aula]"
                                               class="form-control"
                                               value="{{ old("horarios.$i.aula", data_get($horario, 'aula')) }}"
                                               maxlength="100">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Hora Inicio</label>
                                        <input type="time"
                                               name="horarios[{{ $i }}][hora_inicio]"
                                               class="form-control"
                                               value="{{ old("horarios.$i.hora_inicio", data_get($horario, 'hora_inicio') ? \Illuminate\Support\Carbon::parse(data_get($horario, 'hora_inicio'))->format('H:i') : '') }}"
                                               >
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Hora Fin</label>
                                        <input type="time"
                                               name="horarios[{{ $i }}][hora_fin]"
                                               class="form-control"
                                               value="{{ old("horarios.$i.hora_fin", data_get($horario, 'hora_fin') ? \Illuminate\Support\Carbon::parse(data_get($horario, 'hora_fin'))->format('H:i') : '') }}"
                                               >
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="sinHorarios"
                         class="alert alert-light border text-secondary small"
                         style="{{ count(old('horarios', $profesor->horarios)) ? 'display:none' : '' }}">
                        No hay horarios. Puedes agregar uno con el botón anterior.
                    </div>

                    <div class="alert alert-light border rounded-3 mt-4 mb-0 small">
                        <i class="bi bi-info-circle text-success me-2"></i>
                        Los cambios se aplicarán al guardar. Si quitas un horario
                        existente, se eliminará de tus asignaciones.
                    </div>

                </div>

<div class="modal-footer">
    <button type="button"
            class="btn btn-cancelar rounded-pill px-4"
            data-bs-dismiss="modal">
            Cancelar
    </button>

    <button type="submit"
            class="btn btn-uni rounded-pill px-4">
            Actualizar información
    </button>
</div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const lista = document.getElementById('listaHorarios');
    const botonAgregar = document.getElementById('agregarHorario');
    const sinHorarios = document.getElementById('sinHorarios');

    let siguienteIndice = {{ count(old('horarios', $profesor->horarios)) }};

    function actualizarHorarios() {
        const tarjetas = lista.querySelectorAll('.horario-form');

        tarjetas.forEach((tarjeta, indice) => {
            tarjeta.querySelector('.numero-horario').textContent = indice + 1;
        });

        sinHorarios.style.display = tarjetas.length ? 'none' : 'block';
    }

    botonAgregar.addEventListener('click', function () {
        const i = siguienteIndice++;

        const tarjeta = document.createElement('div');
        tarjeta.className = 'border rounded-4 p-3 mb-3 horario-form';

        tarjeta.innerHTML = `
            <input type="hidden" name="horarios[${i}][id]" value="">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <strong>Horario <span class="numero-horario"></span></strong>
                <button type="button"
                        class="btn btn-sm btn-outline-danger rounded-pill quitar-horario">
                    <i class="bi bi-trash me-1"></i> Quitar
                </button>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Materia</label>
                    <input type="text" name="horarios[${i}][materia]"
                           class="form-control" maxlength="255" >
                </div>

            <div class="col-md-6">
                <label class="form-label">Grupo</label>
                <input
                    type="text"
                    name="horarios[${i}][grupo]"
                    class="form-control"
                    maxlength="100"
                    placeholder="Ej. 10D, 3A, 5B"
                    pattern="(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]+"
                    title="Ingresa letras y números, por ejemplo: 10D"
                >
            </div>

                <div class="col-md-6">
                    <label class="form-label">Edificio</label>
                    <input type="text" name="horarios[${i}][edificio]"
                           class="form-control" maxlength="100">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Aula</label>
                    <input type="text" name="horarios[${i}][aula]"
                           class="form-control" maxlength="100">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Hora Inicio</label>
                    <input type="time" name="horarios[${i}][hora_inicio]"
                           class="form-control" >
                </div>

                <div class="col-md-4">
                    <label class="form-label">Hora Fin</label>
                    <input type="time" name="horarios[${i}][hora_fin]"
                           class="form-control" >
                </div>
            </div>
        `;

        lista.appendChild(tarjeta);
        actualizarHorarios();
    });

    lista.addEventListener('click', function (evento) {
        const boton = evento.target.closest('.quitar-horario');

        if (boton) {
            boton.closest('.horario-form').remove();
            actualizarHorarios();
        }
    });

    actualizarHorarios();

    @if($errors->any())
        if (window.bootstrap) {
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('editarProfesorModal')
            ).show();
        }
    @endif
});
</script>

{{-- Reabrir el modal si la validación falla --}}
@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('editarProfesorModal');

            if (modal && window.bootstrap) {
                bootstrap.Modal.getOrCreateInstance(modal).show();
            }
        });
    </script>
@endif


<script>
    // Actualiza las tarjetas cada minuto para reflejar la hora actual.
    setInterval(function () {
        window.location.reload();
    }, 60000);
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ELEMENTOS DEL PANEL
    const wrapper = document.getElementById('notificacionesWrapper');
    const toggle = document.getElementById('notificacionesToggle');
    const panel = document.getElementById('notificacionesPanel');
    const cerrar = document.getElementById('notificacionesCerrar');

    // Comprobar que existen los elementos
    if (!wrapper || !toggle || !panel) {
        console.error('No se encontraron los elementos de notificaciones.');
        return;
    }

    // ABRIR PANEL
    function abrirNotificaciones() {
        panel.hidden = false;
        panel.setAttribute('aria-hidden', 'false');
        toggle.setAttribute('aria-expanded', 'true');
    }

    // CERRAR PANEL
    function cerrarNotificaciones() {
        panel.hidden = true;
        panel.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-expanded', 'false');
    }

    // CLIC EN LA CAMPANA
    toggle.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (panel.hidden) {
            abrirNotificaciones();
        } else {
            cerrarNotificaciones();
        }
    });

    // CLIC EN LA X
    if (cerrar) {
        cerrar.addEventListener('click', function (event) {
            event.preventDefault();
            cerrarNotificaciones();
        });
    }

    // CLIC FUERA DEL PANEL
    document.addEventListener('click', function (event) {
        if (!wrapper.contains(event.target)) {
            cerrarNotificaciones();
        }
    });

    // CERRAR CON ESCAPE
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            cerrarNotificaciones();
        }
    });

});
</script>

@endsection