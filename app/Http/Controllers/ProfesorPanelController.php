<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfesorPanelController extends Controller
{
    /**
     * Mostrar el panel del profesor.
     */

public function index(Request $request)
{
    $usuario = $request->user();

    $profesor = Profesor::where('email', $usuario->email)
        ->with(['horarios', 'asignaciones.grupo'])
        ->firstOrFail();

    // Obtener las notificaciones del profesor.
    $notificaciones = $usuario->notifications()
        ->latest()
        ->get();

    // Obtener únicamente las notificaciones pendientes de leer.
    $notificacionesNoLeidas = $usuario->unreadNotifications()
        ->latest()
        ->get();

    return view('profesores.panel', compact(
        'usuario',
        'profesor',
        'notificaciones',
        'notificacionesNoLeidas'
    ));
}


    /**
     * Actualizar perfil, fotografía, jornada y horarios.
     */
    public function actualizar(Request $request)
    {
        $usuario = $request->user();

        $profesor = Profesor::where('email', $usuario->email)
            ->firstOrFail();

        $datos = $request->validate([
            'nombre' => [
                'string',
                'max:255',
            ],

            'email' => [
                'email',
                'max:255',
                Rule::unique('profesores', 'email')
                    ->ignore($profesor->id),
            ],

            'departamento' => [
                'nullable',
                'string',
                'max:255',
            ],

            'estatus' => [
                Rule::in([
                    'En Clase',
                    'Libre',
                    'Horario de Comida',
                    'Ya No Tarda en Llegar',
                    'Fin Jornada',
                    'Está Cerca',
                    'Ocupado',
                ]),
            ],

            'ubicacion' => [
                'nullable',
                'string',
                'max:255',
            ],

            'entrada' => [
                'nullable',
                'date_format:H:i',
            ],

            'salida' => [
                'nullable',
                'date_format:H:i',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            // El formulario siempre debe incluir este campo.
            // Indica que el formulario contiene la sección de horarios.
            'horarios_present' => [
                'accepted',
            ],

            'horarios' => [
                'sometimes',
                'nullable',
                'array',
            ],

            'horarios.*.id' => [
                'sometimes',
                'nullable',
                'integer',
                'distinct',
            ],

'horarios.*.dia' => [
    'required',
    'string',
    'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado',
],

            'horarios.*.materia' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],

            'horarios.*.grupo' => [
                'sometimes',
                'nullable',
                'string',
                'max:100',
                'regex:/^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]+$/',
            ],

            'horarios.*.edificio' => [
                'sometimes',
                'nullable',
                'string',
                'max:100',
            ],

            'horarios.*.aula' => [
                'sometimes',
                'nullable',
                'string',
                'max:100',
            ],

            'horarios.*.hora_inicio' => [
                'sometimes',
                'nullable',
                'date_format:H:i',
            ],

            'horarios.*.hora_fin' => [
                'sometimes',
                'nullable',
                'date_format:H:i',
            ],
        ]);

        // Separar los datos que pertenecen a otras tablas.
        $horarios = $datos['horarios'] ?? [];
        $foto = $request->file('foto');

        unset(
            $datos['foto'],
            $datos['horarios'],
            $datos['horarios_present']
        );

        // Comprobar que la hora final sea posterior a la inicial.
        foreach ($horarios as $indice => $horario) {

    $horaInicio = $horario['hora_inicio'] ?? null;
    $horaFin = $horario['hora_fin'] ?? null;

    // Comparar solamente cuando ambas horas tengan un valor.
    if (
        filled($horaInicio) &&
        filled($horaFin) &&
        $horaFin <= $horaInicio
    ) {
        throw ValidationException::withMessages([
            "horarios.$indice.hora_fin" =>
                'La hora de fin debe ser posterior a la hora de inicio.',
        ]);
    }

    // Si es un horario nuevo, solicitar sus datos básicos.
    if (empty($horario['id'])) {

        $camposObligatorios = [
            'dia' => 'Debes seleccionar un día.',
            'materia' => 'La materia es obligatoria.',
            'grupo' => 'El grupo es obligatorio.',
            'hora_inicio' => 'La hora de inicio es obligatoria.',
            'hora_fin' => 'La hora de fin es obligatoria.',
        ];

        foreach ($camposObligatorios as $campo => $mensaje) {
            if (blank($horario[$campo] ?? null)) {
                throw ValidationException::withMessages([
                    "horarios.$indice.$campo" => $mensaje,
                ]);
            }
        }
    }
}

        // Obtener los IDs de los horarios que permanecen en el formulario.
        $idsRecibidos = collect($horarios)
            ->pluck('id')
            ->filter(fn ($id) => filled($id))
            ->map(fn ($id) => (int) $id)
            ->values();

        if (
            $idsRecibidos->unique()->count()
            !== $idsRecibidos->count()
        ) {
            throw ValidationException::withMessages([
                'horarios' =>
                    'No puedes enviar horarios duplicados.',
            ]);
        }

        // Verificar que todos los IDs pertenezcan al profesor.
        $idsExistentes = $profesor->horarios()
            ->whereIn('id', $idsRecibidos->all())
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        if (
            $idsExistentes->count()
            !== $idsRecibidos->count()
        ) {
            throw ValidationException::withMessages([
                'horarios' =>
                    'Uno de los horarios no pertenece a tu perfil.',
            ]);
        }

        DB::transaction(function () use (
            $profesor,
            $datos,
            $horarios,
            $idsRecibidos,
            $foto
        ) {
            // 1. Actualizar los datos personales y la jornada.
            $profesor->update($datos);

            // 2. Actualizar la foto si se seleccionó una nueva.
            if ($foto) {
                $rutaAnterior = $profesor->foto;

                $nuevaRuta = $foto->store(
                    'fotos-profesores',
                    'public'
                );

                $profesor->update([
                    'foto' => $nuevaRuta,
                ]);

                if ($rutaAnterior) {
                    Storage::disk('public')
                        ->delete($rutaAnterior);
                }
            }

            // 3. Eliminar los horarios que ya no se enviaron.
            $profesor->horarios()
                ->when(
                    $idsRecibidos->isNotEmpty(),
                    fn ($query) => $query->whereNotIn(
                        'id',
                        $idsRecibidos->all()
                    )
                )
                ->when(
                    $idsRecibidos->isEmpty(),
                    fn ($query) => $query->whereNotNull('id')
                )
                ->delete();

            // 4. Actualizar los horarios existentes y crear los nuevos.
// 4. Actualizar los horarios existentes y crear los nuevos.
foreach ($horarios as $horario) {

    $id = $horario['id'] ?? null;

    unset($horario['id']);

    // Evitar crear registros completamente vacíos.
    if (!$id && collect($horario)->every(fn ($valor) => blank($valor))) {
        continue;
    }

    // Comprobar que el día esté presente.
    if (blank($horario['dia'] ?? null)) {
        throw ValidationException::withMessages([
            'horarios' => 'Debes seleccionar el día de cada horario.',
        ]);
    }

    if ($id) {

        // Buscar el horario perteneciente al profesor.
        $horarioExistente = $profesor->horarios()
            ->whereKey($id)
            ->firstOrFail();

        // Actualizar incluyendo el día.
        $horarioExistente->update([
            'dia' => $horario['dia'],
            'materia' => $horario['materia'] ?? null,
            'grupo' => $horario['grupo'] ?? null,
            'edificio' => $horario['edificio'] ?? null,
            'aula' => $horario['aula'] ?? null,
            'hora_inicio' => $horario['hora_inicio'] ?? null,
            'hora_fin' => $horario['hora_fin'] ?? null,
        ]);

    } else {

        // Crear un horario nuevo incluyendo el día.
        $profesor->horarios()->create([
            'dia' => $horario['dia'],
            'materia' => $horario['materia'],
            'grupo' => $horario['grupo'],
            'edificio' => $horario['edificio'] ?? null,
            'aula' => $horario['aula'] ?? null,
            'hora_inicio' => $horario['hora_inicio'],
            'hora_fin' => $horario['hora_fin'],
        ]);
    }
}
        });

        return redirect()
            ->route('profesor.panel')
            ->with(
                'success',
                'Tu perfil y tus horarios se actualizaron correctamente.'
            );
    }
}
