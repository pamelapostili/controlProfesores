<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ControlProfesoresSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // 1. GRUPOS
            DB::table('grupos')->updateOrInsert(
                ['nombre' => 'A'],
                [
                    'carrera' => 'Desarrollo de Software',
                    'semestre' => 10,
                    'turno' => 'Vespertino',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            DB::table('grupos')->updateOrInsert(
                ['nombre' => 'B'],
                [
                    'carrera' => 'Desarrollo de Software',
                    'semestre' => 10,
                    'turno' => 'Vespertino',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $grupoA = DB::table('grupos')
                ->where('nombre', 'A')->first();

            $grupoB = DB::table('grupos')
                ->where('nombre', 'B')->first();

            // 2. ALUMNOS
            DB::table('users')->updateOrInsert(
                ['email' => 'postis@gmail.com'],
                [
                    'name' => 'Pamela',
                    'password' => Hash::make('postis123'),
                    'rol' => 'alumno',
                    'grupo_id' => $grupoA->id,
                    'matricula' => '2311081826',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            DB::table('users')->updateOrInsert(
                ['email' => 'allen@gmail.com'],
                [
                    'name' => 'Alejandro',
                    'password' => Hash::make('allen123'),
                    'rol' => 'alumno',
                    'grupo_id' => $grupoB->id,
                    'matricula' => '2311080494',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            // 3. CUENTAS DE LOS PROFESORES
            DB::table('users')->updateOrInsert(
                ['email' => 'pugberto@gmail.com'],
                [
                    'name' => 'Pugberto',
                    'password' => Hash::make('pugberto123'),
                    'rol' => 'profesor',
                    'grupo_id' => null,
                    'matricula' => null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            DB::table('users')->updateOrInsert(
                ['email' => 'taiga@gmail.com'],
                [
                    'name' => 'Taiga',
                    'password' => Hash::make('taiga123'),
                    'rol' => 'profesor',
                    'grupo_id' => null,
                    'matricula' => null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $pugbertoUser = DB::table('users')
                ->where('email', 'pugberto@gmail.com')
                ->first();

            $taigaUser = DB::table('users')
                ->where('email', 'taiga@gmail.com')
                ->first();

            // 4. PROFESORES Y UBICACIONES
            DB::table('profesores')->updateOrInsert(
                ['email' => 'pugberto@gmail.com'],
                [
                    //'user_id' => $pugbertoUser->id,
                    'nombre' => 'Pugberto',
                    'departamento' => 'SW',
                    'oficina' => 'Edificio 5 - Cubo 13',
                    'entrada' => '07:00:00',
                    'salida' => '15:00:00',
                    'estatus' => 'libre',
                    'estatus_detalle' => 'Disponible',
                    'ubicacion' => 'Edificio D5 - Aula 211',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            DB::table('profesores')->updateOrInsert(
                ['email' => 'taiga@gmail.com'],
                [
                    
                //'user_id' => $taigaUser->id,
                    'nombre' => 'Taiga',
                    'departamento' => 'Sistemas',
                    'oficina' => 'Edificio 5 - Oficina 29',
                    'entrada' => '08:00:00',
                    'salida' => '16:00:00',
                    'estatus' => 'ocupado',
                    'estatus_detalle' => 'No disponible',
                    'ubicacion' => 'Edificio D5 - Aula 301',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $pugberto = DB::table('profesores')
                ->where('email', 'pugberto@gmail.com')
                ->first();

            $taiga = DB::table('profesores')
                ->where('email', 'taiga@gmail.com')
                ->first();

            // 5. MATERIAS
            DB::table('materias')->updateOrInsert(
                ['clave' => 'MAT101'],
                [
                    'nombre' => 'Matemáticas',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            DB::table('materias')->updateOrInsert(
                ['clave' => 'PROG101'],
                [
                    'nombre' => 'Programación',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            DB::table('materias')->updateOrInsert(
                ['clave' => 'BD101'],
                [
                    'nombre' => 'Bases de Datos',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $matematicas = DB::table('materias')
                ->where('clave', 'MAT101')->first();

            $programacion = DB::table('materias')
                ->where('clave', 'PROG101')->first();

            $basesDatos = DB::table('materias')
                ->where('clave', 'BD101')->first();

            // 6. ASIGNACIONES: GRUPO, PROFESOR Y MATERIA
            $asignaciones = [
                [
                    'grupo_id' => $grupoA->id,
                    'profesor_id' => $pugberto->id,
                    'materia_id' => $matematicas->id,
                ],
                [
                    'grupo_id' => $grupoA->id,
                    'profesor_id' => $taiga->id,
                    'materia_id' => $programacion->id,
                ],
                [
                    'grupo_id' => $grupoB->id,
                    'profesor_id' => $pugberto->id,
                    'materia_id' => $basesDatos->id,
                ],
                [
                    'grupo_id' => $grupoB->id,
                    'profesor_id' => $taiga->id,
                    'materia_id' => $matematicas->id,
                ],
            ];

            foreach ($asignaciones as $asignacion) {
                DB::table('asignaciones')->updateOrInsert(
                    $asignacion,
                    [
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            // 7. HORARIOS DE PUGBERTO
            $horariosPugberto = [
                ['dia' => 'Lunes', 'materia' => 'Matemáticas',
                    'hora_inicio' => '07:00', 'hora_fin' => '09:00',
                    'edificio' => 'A', 'aula' => '101', 'tipo' => 'clase'],

                ['dia' => 'Martes', 'materia' => 'Bases de Datos',
                    'hora_inicio' => '09:00', 'hora_fin' => '11:00',
                    'edificio' => 'A', 'aula' => '102', 'tipo' => 'clase'],

                ['dia' => 'Miércoles', 'materia' => 'Matemáticas',
                    'hora_inicio' => '07:00', 'hora_fin' => '09:00',
                    'edificio' => 'A', 'aula' => '101', 'tipo' => 'clase'],

                ['dia' => 'Jueves', 'materia' => 'Bases de Datos',
                    'hora_inicio' => '09:00', 'hora_fin' => '11:00',
                    'edificio' => 'A', 'aula' => '102', 'tipo' => 'clase'],

                ['dia' => 'Viernes', 'materia' => 'Matemáticas',
                    'hora_inicio' => '08:00', 'hora_fin' => '10:00',
                    'edificio' => 'A', 'aula' => '101', 'tipo' => 'clase'],
            ];

            // 8. HORARIOS DE TAIGA
            $horariosTaiga = [
                ['dia' => 'Lunes', 'materia' => 'Programación',
                    'hora_inicio' => '08:00', 'hora_fin' => '10:00',
                    'edificio' => 'B', 'aula' => '201', 'tipo' => 'clase'],

                ['dia' => 'Martes', 'materia' => 'Matemáticas',
                    'hora_inicio' => '11:00', 'hora_fin' => '13:00',
                    'edificio' => 'B', 'aula' => '202', 'tipo' => 'clase'],

                ['dia' => 'Miércoles', 'materia' => 'Programación',
                    'hora_inicio' => '08:00', 'hora_fin' => '10:00',
                    'edificio' => 'B', 'aula' => '201', 'tipo' => 'clase'],

                ['dia' => 'Jueves', 'materia' => 'Matemáticas',
                    'hora_inicio' => '11:00', 'hora_fin' => '13:00',
                    'edificio' => 'B', 'aula' => '202', 'tipo' => 'clase'],

                ['dia' => 'Viernes', 'materia' => 'Programación',
                    'hora_inicio' => '09:00', 'hora_fin' => '11:00',
                    'edificio' => 'B', 'aula' => '201', 'tipo' => 'clase'],
            ];

            // 9. GUARDAR LOS HORARIOS SIN DUPLICARLOS
            foreach ([
                [$pugberto->id, $horariosPugberto],
                [$taiga->id, $horariosTaiga],
            ] as [$profesorId, $horarios]) {

                foreach ($horarios as $horario) {
                    DB::table('horarios_profesores')->updateOrInsert(
                        [
                            'profesor_id' => $profesorId,
                            'dia' => $horario['dia'],
                            'hora_inicio' => $horario['hora_inicio'],
                        ],
                        [
                            'materia' => $horario['materia'],
                            'hora_fin' => $horario['hora_fin'],
                            'edificio' => $horario['edificio'],
                            'aula' => $horario['aula'],
                            'tipo' => $horario['tipo'],
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );
                }
            }
        });
    }
}
