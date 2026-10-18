@extends('layouts.app')
@section('title', $profesor->nombre)
@section('content')

<a href="{{ route('profesores.index') }}" class="text-decoration-none" style="color:#6f7e49">
    <i class="bi bi-arrow-left"></i> Regresar
</a>

<div class="detail-box mt-4 mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex gap-4 align-items-center">
                <img src="{{ $profesor->foto }}" class="detail-avatar">
                <div>
                    <span class="status-pill {{ $profesor->estatus_class }} position-static">
                        {{ $profesor->estatus_label }}
                    </span>

                    <h1 class="h2 fw-bold mt-2">
                        {{ $profesor->nombre }}
                    </h1>

                    <p class="text-secondary">
                        {{ $profesor->departamento }}
                    </p>

                    <a href="mailto:{{ $profesor->email }}" style="color:#6f7e49">
                        <i class="bi bi-envelope"></i>
                        {{ $profesor->email }}
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="meta-row mb-0">
                <div class="row">
                    <div class="col-6 border-end">
                        <div class="meta-label"> Entrada</div>
                        <div class="meta-value"> {{ $profesor->entrada?->format('H:i') }}</div>
                    </div>

                    <div class="col-6 ps-3">
                        <div class="meta-label"> Salida </div>
                        <div class="meta-value"> {{ $profesor->salida?->format('H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="detail-box">
            <h2 class="h5 fw-bold">Situación actual</h2>
            <div class="p-3 rounded-4 mt-3" style="background:#edf2df">
                <strong>
                    {{ $profesor->estatus_label }}
                </strong>
                <div class="small text-secondary mt-1"> {{ $profesor->estatus_detalle }}</div>
            </div>

            <div class="mt-4">
                <small class="text-secondary"> UBICACIÓN</small>
                <div class="fw-semibold mt-1">
                    <i class="bi bi-geo-alt-fill" style="color:#6f7e49"></i> {{ $profesor->ubicacion }}
                </div>
            </div>

            <div class="mt-4">
                <small class="text-secondary">OFICINA</small>
                <div class="fw-semibold mt-1">
                    <i class="bi bi-door-open" style="color:#6f7e49"></i>
                    {{ $profesor->oficina }}
                </div>
            </div>

            <a href="mailto:{{ $profesor->email }}" class="btn btn-brand w-100 mt-4">
                <i class="bi bi-envelope"></i> Contactar por Correo
            </a>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="detail-box">
            <h2 class="h5 fw-bold"> Horario Completo </h2>
            <p class="text-secondary small"> Consulta las clases y ubicación del profesor.</p>
            @foreach($profesor->horarios as $horario)
                <div class="schedule">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <span class="day"> {{ $horario->dia }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>{{ $horario->materia }}</strong>
                            <div class="small text-secondary mt-1">
                                <i class="bi bi-building"></i>{{ $horario->edificio }}Aula{{ $horario->aula }}
                            </div>
                        </div>

                        <div class="col-md-4 text-md-end">
                            <strong>
                                {{ substr($horario->hora_inicio, 0, 5) }}-{{ substr($horario->hora_fin, 0, 5) }}
                            </strong>

                            <div class="small text-secondary">{{ $horario->tipo }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection