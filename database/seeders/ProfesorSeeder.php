<?php

namespace Database\Seeders;

use App\Models\Profesor;
use Illuminate\Database\Seeder;

class ProfesorSeeder extends Seeder
{
    public function run(): void
    {
        $profesor = Profesor::where('nombre', 'Pugberto')->first();

        if (!$profesor) {
            $this->command->warn(
                'No se encontró al profesor Pugberto. No se asignó la foto.'
            );

            return;
        }

        $profesor->update([
            'foto' => 'profesores/pugberto.jpeg',
        ]);

        $this->command->info(
            'Fotografía asignada correctamente al profesor.'
        );

        $profesorTaiga = Profesor::where('nombre', 'Taiga')->first();

        if ($profesorTaiga) {
            $profesorTaiga->update([
                'foto' => 'profesores/taiga.jpg',
            ]);

            $this->command->info(
                'Fotografía de Taiga asignada correctamente.'
            );
        } else {
            $this->command->warn(
                'No se encontró al profesor Taiga.'
            );
        }
    }
}