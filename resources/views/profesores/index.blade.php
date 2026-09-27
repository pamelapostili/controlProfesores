@extends('layouts.app')

@section('title', 'Profesores')

@section('content')


<div class="hero mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <span
                class="text-uppercase fw-bold small"
                style="color:#6f7e49"
            >

                <i class="bi bi-broadcast-pin"></i>

                Consulta Universitaria

            </span>


            <h1 class="display-6 mt-2">
                Localiza a tu Profesor Fácilmente
            </h1>


            <p>

                Consulta su estatus, ubicación,
                horario laboral, horario de clases y su contacto

            </p>

        </div>


        <div class="col-lg-4">

            <div class="row g-2">

                <div class="col-6">

                    <div class="p-3 bg-white rounded-4">

                        <strong class="fs-4">

                            {{ $profesores->count() }}

                        </strong>

                        <div class="small text-secondary">

                            Profesores

                        </div>

                    </div>

                </div>


                <div class="col-6">

                    <div class="p-3 bg-white rounded-4">

                        <strong class="fs-4">

                            {{ $profesores->sum(fn($p) => $p->horarios->count()) }}

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



<form
    method="GET"
    action="{{ route('profesores.index') }}"
    class="search-box mb-5"
>

    <div class="row align-items-center">

        <div class="col-lg">

            <div class="input-group">

                <span class="input-group-text bg-transparent border-0">

                    <i class="bi bi-search fs-5"></i>

                </span>


                <input
                    type="text"
                    name="q"
                    value="{{ $search }}"
                    class="form-control border-0 shadow-none"
                    placeholder="Buscar profesor, materia, edificio..."
                >

            </div>

        </div>


        <div class="col-lg-auto">

            <select
                name="estatus"
                class="form-select border-0"
            >

                <option value="">

                    Todos los estatus

                </option>


                @foreach($estatuses as $key => $label)

                    <option
                        value="{{ $key }}"
                        @selected($estatus === $key)
                    >

                        {{ $label }}

                    </option>

                @endforeach

            </select>

        </div>


        <div class="col-lg-auto">

            <button class="btn btn-brand px-4">

                <i class="bi bi-search"></i>

                Buscar

            </button>

        </div>

    </div>

</form>



<div class="row g-4">


@forelse($profesores as $profesor)


    <div class="col-md-6 col-xl-4">


        <div class="teacher-card">


            <span
                class="status-pill {{ $profesor->estatus_class }}"
            >

                {{ $profesor->estatus_label }}

            </span>


            <div class="card-top">


                <div class="d-flex gap-3 align-items-center">

                    <img
                        src="{{ $profesor->foto }}"
                        class="avatar"
                        alt="Foto del profesor"
                    >


                    <div>

                        <div class="teacher-name">

                            {{ $profesor->nombre }}

                        </div>


                        <div class="department">

                            {{ $profesor->departamento }}

                        </div>

                    </div>

                </div>



                <div class="location mt-4">

                    <i
                        class="bi bi-geo-alt-fill"
                        style="color:#6f7e49"
                    ></i>

                    {{ $profesor->ubicacion }}

                </div>


                <div class="location mt-2">

                    <i class="bi bi-envelope"></i>

                    {{ $profesor->email }}

                </div>


            </div>



            <div class="meta-row">

                <div class="row">

                    <div class="col-6 border-end">

                        <div class="meta-label">

                            Entrada

                        </div>

                        <div class="meta-value">

                            {{ $profesor->entrada?->format('H:i') }}

                        </div>

                    </div>


                    <div class="col-6 ps-3">

                        <div class="meta-label">

                            Salida

                        </div>

                        <div class="meta-value">

                            {{ $profesor->salida?->format('H:i') }}

                        </div>

                    </div>

                </div>

            </div>



            <div class="card-actions">


                <span class="small text-secondary">

                    <i class="bi bi-calendar3"></i>

                    {{ $profesor->horarios->count() }}

                    Horarios Disponibles

                </span>


                <div class="d-flex gap-2">


                    <a
                        href="mailto:{{ $profesor->email }}"
                        class="btn-icon"
                        title="Enviar correo"
                    >

                        <i class="bi bi-envelope"></i>

                    </a>


                    <a
                        href="{{ route('profesores.show', $profesor) }}"
                        class="btn-icon"
                        title="Ver detalles"
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

        <h3 class="mt-3">

            No encontramos profesores.

        </h3>

        <p class="text-secondary">

            Intenta realizar otra búsqueda.

        </p>

    </div>


@endforelse


</div>


@endsection