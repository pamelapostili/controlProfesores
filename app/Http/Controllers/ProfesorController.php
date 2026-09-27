<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('q', ''));

        $estatus = $request->get('estatus');

        $profesores = Profesor::query()

            ->with('horarios')

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'nombre',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'departamento',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas(
                        'horarios',
                        function ($horario) use ($search) {

                            $horario
                                ->where(
                                    'materia',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'edificio',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'aula',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                });
            })

            ->when(
                $estatus,
                fn ($query) =>
                    $query->where('estatus', $estatus)
            )

            ->orderBy('nombre')

            ->get();

        $estatuses = [

            'en_clase' =>
                'En clase',

            'libre' =>
                'Libre',

            'comida' =>
                'Horario de comida',

            'por_llegar' =>
                'Ya no tarda en llegar',

            'ya_se_fue' =>
                'Ya se fue',

            'cerca' =>
                'Está cerca',

            'ubicado' =>
                'Ubicado en edificio',
        ];

        return view(
            'profesores.index',
            compact(
                'profesores',
                'search',
                'estatus',
                'estatuses'
            )
        );
    }


    public function show(Profesor $profesor)
    {
        $profesor->load('horarios');

        return view(
            'profesores.show',
            compact('profesor')
        );
    }
}