<?php
namespace App\Http\Controllers;
use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $estatus = $request->input('estatus');

        $alumno = $request->user();

        $profesores = Profesor::query()
            ->with('horarios')

            // Mostrar solamente profesores asignados al grupo del alumno.
            ->when($alumno && $alumno->rol === 'alumno', function ($query) use ($alumno) {
                $query->whereHas('asignaciones', function ($asignacion) use ($alumno) {
                    $asignacion->where('grupo_id', $alumno->grupo_id);
                });
            })

            // Buscador por nombre, correo, departamento, materia o ubicación.
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('departamento', 'like', "%{$search}%")
                        ->orWhereHas('horarios', function ($horario) use ($search) {
                            $horario->where('materia', 'like', "%{$search}%")
                                ->orWhere('edificio', 'like', "%{$search}%")
                                ->orWhere('aula', 'like', "%{$search}%");
                        });
                });
            })

            // Filtro por estatus.
            ->when($estatus, function ($query) use ($estatus) {
                $query->where('estatus', $estatus);
            })

            ->orderBy('nombre')
            ->get();

        $estatuses = [
            'en_clase' => 'En clase',
            'libre' => 'Libre',
            'comida' => 'Horario de comida',
            'por_llegar' => 'Ya no tarda en llegar',
            'ya_se_fue' => 'Ya se fue',
            'cerca' => 'Está cerca',
            'ubicado' => 'Ubicado en edificio',
        ];

        return view(
            'profesores.index',
            compact('profesores', 'search', 'estatus', 'estatuses')
        );
    }

    public function show(Request $request, Profesor $profesor)
    {
        $alumno = $request->user();

        // Impedir que un alumno consulte profesores de otro grupo.
        if ($alumno && $alumno->rol === 'alumno') {
            $tieneAcceso = $profesor->asignaciones()
                ->where('grupo_id', $alumno->grupo_id)
                ->exists();

            abort_unless($tieneAcceso, 403);
        }

        $profesor->load('horarios');

        return view('profesores.show', compact('profesor'));
    }
}
