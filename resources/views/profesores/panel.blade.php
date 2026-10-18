
@extends('layouts.app')

@section('title', 'Mi panel | ControlProfesores')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="text-success fw-bold small">
                UNILIFE · PORTAL DOCENTE
            </span>
            <h1 class="fw-bold mt-2">¡Hola, {{ $profesor->nombre }}!</h1>
            <p class="text-secondary">
                Administra tu información y consulta tus grupos.
            </p>
        </div>

        <a href="{{ route('profile.edit') }}"
           class="btn btn-outline-success rounded-pill">
            Mi cuenta
        </a>
    </div>

    <div class="row g-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">

                @if($profesor->foto)
                    <img src="{{ $profesor->foto }}"
                         alt="Foto del profesor"
                         class="rounded-circle mb-3"
                         style="width:100px;height:100px;object-fit:cover">
                @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3"
                         style="width:100px;height:100px;font-size:2rem">
                        <i class="bi bi-person"></i>
                    </div>
                @endif

                <h4 class="fw-bold">{{ $profesor->nombre }}</h4>

                <p class="text-secondary mb-1">
                    {{ $profesor->departamento }}
                </p>

                <p class="small">
                    <i class="bi bi-envelope me-2"></i>
                    {{ $profesor->email }}
                </p>

                <hr>

                <p class="small text-secondary mb-1">ESTATUS ACTUAL</p>

                <span class="badge bg-success-subtle text-success rounded-pill p-2">
                    {{ $profesor->estatus }}
                </span>

                <p class="mt-3 mb-1">
                    <i class="bi bi-geo-alt me-2"></i>
                    {{ $profesor->ubicacion }}
                </p>

                <a href="{{ route('profile.edit') }}"
                   class="btn btn-success rounded-pill mt-3">
                    Editar mi cuenta
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h4 class="fw-bold">Mi jornada laboral</h4>

                <div class="row mt-3">
                    <div class="col-6">
                        <p class="text-secondary small mb-1">HORA DE ENTRADA</p>
                        <h3 class="fw-bold">
                            {{ $profesor->entrada?->format('H:i') ?? '--:--' }}
                        </h3>
                    </div>

                    <div class="col-6">
                        <p class="text-secondary small mb-1">HORA DE SALIDA</p>
                        <h3 class="fw-bold">
                            {{ $profesor->salida?->format('H:i') ?? '--:--' }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold">Mis horarios y grupos</h4>

                @forelse($profesor->horarios as $horario)
                    <div class="border rounded-3 p-3 mt-3">
                        <div class="d-flex justify-content-between flex-wrap gap-2">
                            <strong>{{ $horario->materia }}</strong>
                            <span class="text-success">
                                {{ $horario->hora_inicio }}
                                -
                                {{ $horario->hora_fin }}
                            </span>
                        </div>

                        <p class="text-secondary mb-0 mt-2">
                            <i class="bi bi-building me-1"></i>
                            Edificio {{ $horario->edificio ?? 'Por asignar' }}
                            · Aula {{ $horario->aula ?? 'Por asignar' }}
                        </p>
                    </div>
                @empty
                    <p class="text-secondary mt-3">
                        Aún no tienes horarios registrados.
                    </p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
