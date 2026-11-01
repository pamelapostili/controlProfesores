@extends('layouts.app')

@section('title', $profesor->nombre)

@section('content')
<div class="pagina-profesores">
    <div class="contenido-profesores">

        {{-- Navegación --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <a href="{{ route('profesores.index') }}"
               class="volver-profesores">
                <i class="bi bi-arrow-left"></i>
                Volver
            </a>

            {{-- <span class="text-secondary small">
                <i class="bi bi-person-vcard"></i>
                Perfil de Profesor
            </span> --}}
        </div>

        {{-- Encabezado del perfil --}}
        <section class="perfil-profesor mb-4">
            <div class="perfil-fondo"></div>

            <div class="perfil-contenido">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-4 flex-wrap">

                            {{-- Fotografía --}}
                            @if($profesor->foto)
                                <img
                                    src="{{ asset('storage/' . $profesor->foto) }}"
                                    alt="Fotografía de {{ $profesor->nombre }}"
                                    class="detail-avatar"
                                >
                            @else
                                <div class="detail-avatar detail-avatar-placeholder">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            @endif

                            {{-- Datos principales --}}
                            <div class="perfil-identidad">
                                <span class="perfil-etiqueta">
                                    <i class="bi bi-mortarboard-fill"></i>
                                    Información Académica del Profesor
                                </span>

                                <h1>{{ $profesor->nombre }}</h1>

                                <p class="perfil-departamento">
                                    <i class="bi bi-building"></i>
                                    {{ $profesor->departamento ?: 'Departamento no especificado' }}
                                </p>

                                <span class="status-pill {{ $profesor->estatus_class }} position-static">
                                    <span class="punto-estatus"></span>
                                    {{ $profesor->estatus_label }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="perfil-contacto">
                            <span class="dato-etiqueta">CORREO ELECTRÓNICO</span>

                            <div class="correo-profesor">
                                <i class="bi bi-envelope-fill"></i>
                                <span>{{ $profesor->email }}</span>
                            </div>

                            <a href="mailto:{{ $profesor->email }}"
                               class="btn btn-brand w-100 mt-3">
                                <i class="bi bi-send"></i>
                                Contactar Profesor
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Resumen --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="resumen-card">
                    <div class="resumen-icono">
                        <i class="bi bi-calendar-week"></i>
                    </div>
                    <div>
                        <div class="resumen-numero">
                            {{ $profesor->horarios->count() }}
                        </div>
                        <div class="resumen-texto">
                            {{ $profesor->horarios->count() === 1 ? 'Clase registrada' : 'Clases Registradas' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="resumen-card">
                    <div class="resumen-icono">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <div class="resumen-numero">
                            {{ $profesor->entrada?->format('H:i') ?? '--:--' }}
                        </div>
                        <div class="resumen-texto">Hora Entrada</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="resumen-card">
                    <div class="resumen-icono">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div class="resumen-numero">
                            {{ $profesor->salida?->format('H:i') ?? '--:--' }}
                        </div>
                        <div class="resumen-texto">Hora Salida</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- Columna de información --}}
            <div class="col-lg-4">
                <div class="detail-box h-100">

                    <div class="seccion-titulo">
                        <div class="seccion-icono">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <div>
                            <h2>Datos</h2>
                            <p>Estado y ubicación del profesor</p>
                        </div>
                    </div>

                    <div class="situacion-panel">
                        <span class="dato-etiqueta">ESTATUS ACTUAL</span>

                        <div class="situacion-estatus">
                            <span class="punto-estatus"></span>
                            <strong>{{ $profesor->estatus_label }}</strong>
                        </div>

                        <p class="text-secondary mb-0 mt-2">
                            {{ $profesor->estatus_detalle ?: 'No hay información adicional disponible.' }}
                        </p>
                    </div>

                    <div class="dato-perfil">
                        <div class="dato-icono">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <span class="dato-etiqueta">UBICACIÓN</span>
                            <div class="dato-valor">
                                {{ $profesor->ubicacion ?: 'No Especificada' }}
                            </div>
                        </div>
                    </div>

                    <div class="dato-perfil">
                        <div class="dato-icono">
                            <i class="bi bi-door-open-fill"></i>
                        </div>
                        <div>
                            <span class="dato-etiqueta">CUBO</span>
                            <div class="dato-valor">
                                {{ $profesor->oficina ?: 'No Especificada' }}
                            </div>
                        </div>
                    </div>

                    <div class="dato-perfil">
                        <div class="dato-icono">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <span class="dato-etiqueta">CORREO</span>
                            <div class="dato-valor correo-lateral">
                                {{ $profesor->email }}
                            </div>
                        </div>
                    </div>

                    <a href="mailto:{{ $profesor->email }}"
                       class="btn btn-brand w-100 mt-4">
                        <i class="bi bi-envelope"></i>
                        Enviar Correo
                    </a>
                </div>
            </div>

            {{-- Columna de horarios --}}
            <div class="col-lg-8">
                <div class="detail-box">

                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                        <div class="seccion-titulo mb-0">
                            <div class="seccion-icono">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <div>
                                <h2>Horario de Clases</h2>
                                <p>Consulta las materias, aulas y horas de tu profesor</p>
                            </div>
                        </div>

                        <span class="contador-clases">
                            {{ $profesor->horarios->count() }}
                            {{ $profesor->horarios->count() === 1 ? 'clase' : 'clases' }}
                        </span>
                    </div>

                    {{-- Buscador de horarios --}}
                    @if($profesor->horarios->isNotEmpty())
                        <div class="buscador-horarios mb-4">
                            <i class="bi bi-search"></i>
                            <input
                                type="text"
                                id="buscarHorario"
                                placeholder="Buscar materia, día, edificio o aula..."
                                autocomplete="off"
                                aria-label="Buscar en el horario"
                            >
                        </div>
                    @endif

                    <div id="listaHorarios">
                        @forelse($profesor->horarios as $horario)
                            <article
                                class="schedule schedule-dinamico"
                                data-search="{{ \Illuminate\Support\Str::lower(
                                    ($horario->dia ?? '') . ' ' .
                                    ($horario->materia ?? '') . ' ' .
                                    ($horario->edificio ?? '') . ' ' .
                                    ($horario->aula ?? '') . ' ' .
                                    ($horario->tipo ?? '')
                                ) }}"
                            >
                                <div class="row align-items-center g-3">

                                    <div class="col-md-2 col-sm-3">
                                        <div class="dia-horario">
                                            <i class="bi bi-calendar"></i>
                                            <span>{{ $horario->dia }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-9">
                                        <h3 class="materia-horario">
                                            {{ $horario->materia }}
                                        </h3>

                                        <div class="ubicacion-horario">
                                            <span>
                                                <i class="bi bi-building"></i>
                                                {{ $horario->edificio ?: 'No Especificado' }}
                                            </span>

                                            <span>
                                                <i class="bi bi-door-closed"></i>
                                                Aula {{ $horario->aula ?: 'Sin Asignar' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 text-md-end">
                                        <div class="horas-clase">
                                            <i class="bi bi-clock"></i>
                                            {{ $horario->hora_inicio ? substr($horario->hora_inicio, 0, 5) : '--:--' }}
                                            –
                                            {{ $horario->hora_fin ? substr($horario->hora_fin, 0, 5) : '--:--' }}
                                        </div>

                                        @if($horario->tipo)
                                            <span class="tipo-clase">
                                                {{ $horario->tipo }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="estado-vacio">
                                <i class="bi bi-calendar-x"></i>
                                <h3>Sin horarios registrados</h3>
                                <p>Este profesor todavía no tiene clases registradas.</p>
                            </div>
                        @endforelse
                    </div>

                    <div id="horariosSinResultados" class="estado-vacio d-none">
                        <i class="bi bi-search"></i>
                        <h3>No se encontraron horarios</h3>
                        <p>Prueba con otra materia, día, edificio o aula.</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="text-center mt-4 mb-3">
            <a href="{{ route('profesores.index') }}"
               class="volver-profesores">
                <i class="bi bi-arrow-left"></i>
                Volver al Inicio
            </a>
        </div>

    </div>
</div>

{{-- Filtro dinámico de horarios --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buscador = document.getElementById('buscarHorario');

    if (!buscador) {
        return;
    }

    const horarios = document.querySelectorAll('.schedule-dinamico');
    const mensajeVacio = document.getElementById('horariosSinResultados');

    buscador.addEventListener('input', function () {
        const texto = buscador.value.trim().toLocaleLowerCase('es');
        let visibles = 0;

        horarios.forEach(function (horario) {
            const contenido = (horario.dataset.search || '')
                .toLocaleLowerCase('es');

            const coincide = contenido.includes(texto);

            horario.classList.toggle('d-none', !coincide);

            if (coincide) {
                visibles++;
            }
        });

        mensajeVacio.classList.toggle('d-none', visibles > 0);
    });
});
</script>

{{-- Estilos exclusivos del detalle --}}
<style>
.pagina-profesores {
    width: 100%;
    padding: 30px 36px 48px;
}

.contenido-profesores {
    max-width: 1400px;
    width: 100%;
    margin: 0 auto;
}

.volver-profesores {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #979a8f;
    font-weight: 600;
    text-decoration: none;
    transition: color .2s, transform .2s;
}

.volver-profesores:hover {
    color: #787a71;
    transform: translateX(-3px);
}

.perfil-profesor {
    position: relative;
    overflow: hidden;
    background: #fff;
    border: 1px solid #e8ebdf;
    border-radius: 24px;
    box-shadow: 0 8px 28px rgba(39, 48, 27, .06);
}

.perfil-fondo {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 105px;
    background: linear-gradient(115deg, #e9eedf, #f7f8f2 75%);
}

.perfil-contenido {
    position: relative;
    padding: 38px;
}

.detail-avatar {
    width: 145px;
    height: 145px;
    flex: 0 0 145px;
    object-fit: cover;
    border-radius: 22px;
    border: 5px solid #fff;
    background: #eef1e7;
    box-shadow: 0 5px 18px rgba(0, 0, 0, .10);
}

.detail-avatar-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6f7e49;
    font-size: 4rem;
}

.perfil-etiqueta {
    display: inline-block;
    margin-bottom: 7px;
    color: #6f7e49;
    font-size: .75rem;
    font-weight: 800;
    letter-spacing: .09em;
    text-transform: uppercase;
}

.perfil-identidad h1 {
    margin: 0 0 8px;
    color: #252a20;
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 800;
    overflow-wrap: anywhere;
}

.perfil-departamento {
    margin-bottom: 14px;
    color: #72776c;
}

.perfil-contacto {
    padding: 23px;
    background: #f8f9f5;
    border: 1px solid #e9ecdf;
    border-radius: 18px;
}

.dato-etiqueta {
    display: block;
    margin-bottom: 7px;
    color: #858a7c;
    font-size: .7rem;
    font-weight: 800;
    letter-spacing: .08em;
}

.correo-profesor {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    color: #343a2d;
    font-size: .9rem;
    overflow-wrap: anywhere;
}

.correo-profesor i {
    color: #6f7e49;
    margin-top: 3px;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 12px;
    border-radius: 30px;
    font-size: .8rem;
    font-weight: 700;
}

.punto-estatus {
    display: inline-block;
    width: 8px;
    height: 8px;
    flex: 0 0 8px;
    background: currentColor;
    border-radius: 50%;
}

.resumen-card {
    display: flex;
    align-items: center;
    gap: 17px;
    height: 100%;
    padding: 22px;
    background: #fff;
    border: 1px solid #e9ecdf;
    border-radius: 18px;
    box-shadow: 0 5px 18px rgba(39, 48, 27, .035);
    transition: transform .2s, box-shadow .2s;
}

.resumen-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(39, 48, 27, .08);
}

.resumen-icono,
.seccion-icono,
.dato-icono {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #647644;
    background: #edf1e4;
    border-radius: 14px;
}

.resumen-icono {
    width: 52px;
    height: 52px;
    font-size: 1.4rem;
}

.resumen-numero {
    color: #292e24;
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1.2;
}

.resumen-texto {
    margin-top: 4px;
    color: #777c70;
    font-size: .83rem;
}

.detail-box {
    padding: 28px;
    background: #fff;
    border: 1px solid #e9ecdf;
    border-radius: 22px;
    box-shadow: 0 6px 24px rgba(39, 48, 27, .045);
}

.seccion-titulo {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 24px;
}

.seccion-icono {
    width: 46px;
    height: 46px;
    font-size: 1.25rem;
}

.seccion-titulo h2 {
    margin: 0;
    color: #2d3228;
    font-size: 1.1rem;
    font-weight: 800;
}

.seccion-titulo p {
    margin: 4px 0 0;
    color: #85897f;
    font-size: .82rem;
}

.situacion-panel {
    padding: 18px;
    background: #f4f6ee;
    border: 1px solid #e8ecdc;
    border-radius: 16px;
}

.situacion-estatus {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #566a38;
}

.dato-perfil {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    margin-top: 24px;
}

.dato-icono {
    width: 42px;
    height: 42px;
    font-size: 1.1rem;
}

.dato-valor {
    color: #34392f;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.correo-lateral {
    font-size: .9rem;
}

.contador-clases {
    padding: 8px 13px;
    color: #5c6e3e;
    background: #edf1e4;
    border-radius: 12px;
    font-size: .8rem;
    font-weight: 800;
    white-space: nowrap;
}

.buscador-horarios {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 15px;
    background: #f8f9f5;
    border: 1px solid #e5e8dc;
    border-radius: 13px;
}

.buscador-horarios i {
    color: #77845d;
}

.buscador-horarios input {
    width: 100%;
    min-width: 0;
    padding: 14px 0;
    color: #34392f;
    background: transparent;
    border: 0;
    outline: none;
}

.buscador-horarios:focus-within {
    border-color: #87976a;
    box-shadow: 0 0 0 3px rgba(111, 126, 73, .10);
}

.schedule-dinamico {
    padding: 20px;
    margin-bottom: 13px;
    background: #fff;
    border: 1px solid #e8ebdf;
    border-radius: 16px;
    transition: background .2s, border-color .2s, transform .2s;
}

.schedule-dinamico:hover {
    background: #fbfcf8;
    border-color: #cfd7be;
    transform: translateY(-2px);
}

.dia-horario {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    min-height: 70px;
    padding: 10px;
    color: #5d703e;
    background: #edf1e4;
    border-radius: 13px;
    font-size: .85rem;
    font-weight: 800;
    text-align: center;
    overflow-wrap: anywhere;
}

.dia-horario i {
    font-size: 1.2rem;
}

.materia-horario {
    margin: 0 0 9px;
    color: #2d3228;
    font-size: 1rem;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.ubicacion-horario {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 14px;
    color: #777c70;
    font-size: .8rem;
}

.ubicacion-horario span {
    overflow-wrap: anywhere;
}

.ubicacion-horario i {
    margin-right: 4px;
    color: #71814f;
}

.horas-clase {
    color: #424c33;
    font-size: .95rem;
    font-weight: 800;
    white-space: nowrap;
}

.horas-clase i {
    color: #748253;
    margin-right: 4px;
}

.tipo-clase {
    display: inline-block;
    margin-top: 8px;
    padding: 5px 9px;
    color: #69734f;
    background: #f1f3eb;
    border-radius: 8px;
    font-size: .72rem;
    font-weight: 700;
}

.estado-vacio {
    padding: 38px 18px;
    color: #777c70;
    text-align: center;
}

.estado-vacio > i {
    color: #9aa486;
    font-size: 2.6rem;
}

.estado-vacio h3 {
    margin-top: 13px;
    color: #34392f;
    font-size: 1.1rem;
    font-weight: 800;
}

.estado-vacio p {
    margin-bottom: 0;
    font-size: .9rem;
}

.btn-brand {
    color: #fff;
    background: #6f7e49;
    border: 1px solid #6f7e49;
    border-radius: 12px;
    padding: 12px 18px;
    font-weight: 700;
    transition: background .2s, transform .2s;
}

.btn-brand:hover {
    color: #fff;
    background: #59683a;
    border-color: #59683a;
    transform: translateY(-1px);
}

@media (max-width: 991.98px) {
    .pagina-profesores {
        padding: 25px 22px 40px;
    }

    .perfil-contenido {
        padding: 28px;
    }

    .perfil-contacto {
        margin-top: 8px;
    }
}

@media (max-width: 575.98px) {
    .pagina-profesores {
        padding: 18px 14px 30px;
    }

    .perfil-contenido {
        padding: 22px 18px;
    }

    .detail-avatar {
        width: 112px;
        height: 112px;
        flex-basis: 112px;
        border-radius: 18px;
    }

    .detail-avatar-placeholder {
        font-size: 3.2rem;
    }

    .detail-box {
        padding: 20px 16px;
    }

    .resumen-card {
        padding: 16px;
    }

    .schedule-dinamico {
        padding: 16px;
    }

    .horas-clase {
        text-align: left;
    }
}
</style>
@endsection
