@extends('layouts.app')

@section('title', 'Profesores')

@section('content')
<div class="pagina-profesores">
    <div class="contenido-profesores">

        {{-- Encabezado y estadísticas --}}
        <div class="hero mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="text-uppercase fw-bold small" style="color:#6f7e49">
                        <i class="bi bi-broadcast-pin"></i>
                        Consulta Universitaria
                    </span>

                    <h1 class="display-6 mt-2" style="color:#6f7e49">
                        Localiza a tu Profesor Fácilmente
                    </h1>

                    <p>
                        Consulta su estatus, ubicación, horario laboral,
                        horario de clases y su contacto.
                    </p>
                </div>

                <div class="col-lg-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-4">
                                <strong class="fs-4" id="totalProfesores">
                                    {{ $profesores->count() }}
                                </strong>
                                <div class="small text-secondary">
                                    Profesores
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 bg-white rounded-4">
                                <strong class="fs-4" id="totalHorarios">
                                    {{ $profesores->count() }}
                                </strong>
                                <div class="small text-secondary">
                                    Horarios
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Buscador y filtro de estatus --}}
        <form id="formBusqueda" class="search-box mb-5">
            <div class="row align-items-center g-3">
                <div class="col-lg">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0">
                            <i class="bi bi-search fs-5"></i>
                        </span>

                        <input
                            type="text"
                            id="buscarProfesor"
                            class="form-control border-0 shadow-none"
                            placeholder="Buscar profesor, departamento, edificio o correo..."
                            autocomplete="off"
                        >
                    </div>
                </div>

                <div class="col-lg-auto">
                    <select id="filtrarEstatus" class="form-select border-0">
                        <option value="">Todos los Estatus</option>

                        @foreach($estatuses as $key => $label)
                            <option value="{{ $key }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- <div class="col-lg-auto">
                    <button type="button" id="limpiarBusqueda"
                            class="btn btn-outline-secondary px-3">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Limpiar
                    </button>
                </div> --}}
            </div>
        </form>

        {{-- Tarjetas de profesores --}}
        <div class="row g-4" id="listaProfesores">

            @forelse($profesores as $profesor)
                <div
                    class="col-md-6 col-xl-4 tarjeta-profesor"
                    data-estatus="{{ $profesor->estatus }}"
                    data-search="{{ \Illuminate\Support\Str::lower(
                        $profesor->nombre . ' ' .
                        $profesor->departamento . ' ' .
                        $profesor->ubicacion . ' ' .
                        $profesor->email
                    ) }}"
                    data-horarios="{{ $profesor->horarios->count() }}"
                >
                    <div class="teacher-card h-100">

                        <span class="status-pill {{ $profesor->estatus_class }}">
                            {{ $profesor->estatus_label }}
                        </span>

                        <div class="card-top">
                            <div class="d-flex gap-3 align-items-center">

                                {{-- Fotografía --}}
                                @if($profesor->foto)
                                    <img
                                        src="{{ asset('storage/' . $profesor->foto) }}"
                                        class="avatar"
                                        alt="Foto de {{ $profesor->nombre }}"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="avatar avatar-placeholder">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif

                                {{-- Nombre y departamento --}}
                                <div>
                                    <div class="teacher-name">
                                        {{ $profesor->nombre }}
                                    </div>

                                    <div class="department" style="color: #6f7e49">
                                        {{ $profesor->departamento }}
                                    </div>
                                </div>
                            </div>

                            {{-- Ubicación --}}
                            <div class="location mt-4">
                                <i class="bi bi-geo-alt-fill"
                                   style="color:#6f7e49"></i>
                                {{ $profesor->ubicacion }}
                            </div>

                            {{-- Correo --}}
                            <div class="location mt-2">
                                <i class="bi bi-envelope"></i>
                                {{ $profesor->email }}
                            </div>
                        </div>

                        {{-- Horario laboral --}}
                        <div class="meta-row">
                            <div class="row">
                                <div class="col-6 border-end">
                                    <div class="meta-label">Entrada</div>
                                    <div class="meta-value">
                                        {{ $profesor->entrada?->format('H:i') ?? 'No disponible' }}
                                    </div>
                                </div>

                                <div class="col-6 ps-3">
                                    <div class="meta-label">Salida</div>
                                    <div class="meta-value">
                                        {{ $profesor->salida?->format('H:i') ?? 'No disponible' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Acciones --}}
                        <div class="card-actions">
                            <span class="small text-secondary">
                                <i class="bi bi-calendar3"></i>
                                {{ $profesor->horarios->count() }}
                                {{ $profesor->horarios->count() === 1 ? 'horario disponible' : 'horarios disponibles' }}
                            </span>

                            <div class="d-flex gap-2">
                                <a
                                    href="mailto:{{ $profesor->email }}"
                                    class="btn-icon"
                                    title="Enviar correo"
                                    aria-label="Enviar correo a {{ $profesor->nombre }}"
                                >
                                    <i class="bi bi-envelope"></i>
                                </a>

                                <a
                                    href="{{ route('profesores.show', $profesor) }}"
                                    class="btn-icon"
                                    title="Ver detalles"
                                    aria-label="Ver detalles de {{ $profesor->nombre }}"
                                >
                                    <i class="bi bi-three-dots"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-search fs-1 text-secondary"></i>
                    <h3 class="mt-3">No hay profesores registrados.</h3>
                    <p class="text-secondary">
                        Cuando se registren profesores, aparecerán aquí.
                    </p>
                </div>
            @endforelse

            {{-- Mensaje cuando los filtros no encuentran coincidencias --}}
            <div
                class="col-12 text-center py-5 d-none"
                id="mensajeSinResultados"
            >
                <i class="bi bi-search fs-1 text-secondary"></i>
                <h3 class="mt-3">No encontramos profesores.</h3>
                <p class="text-secondary">
                    Intenta otra búsqueda o cambia el estatus seleccionado.
                </p>
            </div>
        </div>

    </div>
</div>

{{-- Búsqueda en tiempo real --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buscador = document.getElementById('buscarProfesor');
    const filtroEstatus = document.getElementById('filtrarEstatus');
    const botonLimpiar = document.getElementById('limpiarBusqueda');
    const formulario = document.getElementById('formBusqueda');

    const tarjetas = document.querySelectorAll('.tarjeta-profesor');
    const contadorProfesores = document.getElementById('totalProfesores');
    const contadorHorarios = document.getElementById('totalHorarios');
    const mensajeSinResultados = document.getElementById('mensajeSinResultados');

    function filtrarProfesores() {
        const texto = buscador.value
            .trim()
            .toLocaleLowerCase('es');

        const estatusSeleccionado = filtroEstatus.value;

        let profesoresVisibles = 0;
        let horariosVisibles = 0;

        tarjetas.forEach(function (tarjeta) {
            const contenido = (tarjeta.dataset.search || '')
                .toLocaleLowerCase('es');

            const estatus = tarjeta.dataset.estatus || '';
            const cantidadHorarios = Number(tarjeta.dataset.horarios || 0);

            const coincideTexto = contenido.includes(texto);

            const coincideEstatus =
                estatusSeleccionado === '' ||
                estatus === estatusSeleccionado;

            const mostrar = coincideTexto && coincideEstatus;

            tarjeta.classList.toggle('d-none', !mostrar);

            if (mostrar) {
                profesoresVisibles++;
                horariosVisibles += cantidadHorarios;
            }
        });

        contadorProfesores.textContent = profesoresVisibles;
        contadorHorarios.textContent = horariosVisibles;

        mensajeSinResultados.classList.toggle(
            'd-none',
            profesoresVisibles > 0 || tarjetas.length === 0
        );
    }

    // Buscar mientras se escribe.
    buscador.addEventListener('input', filtrarProfesores);

    // Aplicar el estatus inmediatamente.
    filtroEstatus.addEventListener('change', filtrarProfesores);

    // Evitar que el formulario recargue la página.
    formulario.addEventListener('submit', function (evento) {
        evento.preventDefault();
        filtrarProfesores();
    });

    // Vaciar el texto y restablecer todos los estatus.
    botonLimpiar.addEventListener('click', function () {
        buscador.value = '';
        filtroEstatus.value = '';
        filtrarProfesores();
        buscador.focus();
    });

    // Inicializar los resultados.
    filtrarProfesores();
});
</script>
@endsection
