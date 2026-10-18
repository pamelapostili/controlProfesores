<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profesor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        $profesor = Profesor::create([

            'nombre' =>
                'Dra. Mariana López Hernández',

            'email' =>
                'mariana.lopez@universidad.edu.mx',

            'foto' =>
                'https://i.pravatar.cc/300?img=47',

            'departamento' =>
                'Ingeniería de Software',

            'oficina' =>
                'Edificio A · Oficina 204',

            'entrada' =>
                '07:30',

            'salida' =>
                '15:30',

            'estatus' =>
                'en_clase',

            'estatus_detalle' =>
                'Dando clase de Desarrollo Web',

            'ubicacion' =>
                'Edificio A · Aula 203',

        ]);


        $profesor->horarios()->createMany([

            [
                'dia' => 'Lunes',

                'materia' =>
                    'Desarrollo Web Profesional',

                'hora_inicio' =>
                    '08:00',

                'hora_fin' =>
                    '10:00',

                'edificio' =>
                    'Edificio A',

                'aula' =>
                    '203',

                'tipo' =>
                    'Clase',
            ],

            [
                'dia' => 'Lunes',

                'materia' =>
                    'Aplicaciones Web Progresivas',

                'hora_inicio' =>
                    '11:00',

                'hora_fin' =>
                    '13:00',

                'edificio' =>
                    'Edificio B',

                'aula' =>
                    '105',

                'tipo' =>
                    'Clase',
            ],

            [
                'dia' => 'Martes',

                'materia' =>
                    'Arquitectura de Software',

                'hora_inicio' =>
                    '09:00',

                'hora_fin' =>
                    '11:00',

                'edificio' =>
                    'Edificio A',

                'aula' =>
                    '204',

                'tipo' =>
                    'Clase',
            ],

        ]);


        $profesor2 = Profesor::create([

            'nombre' =>
                'Mtro. Carlos Eduardo Ramírez',

            'email' =>
                'carlos.ramirez@universidad.edu.mx',

            'foto' =>
                'https://i.pravatar.cc/300?img=12',

            'departamento' =>
                'Tecnologías de la Información',

            'oficina' =>
                'Edificio C · Oficina 108',

            'entrada' =>
                '08:00',

            'salida' =>
                '16:00',

            'estatus' =>
                'libre',

            'estatus_detalle' =>
                'Disponible para atención',

            'ubicacion' =>
                'Edificio C · Oficina 108',

        ]);


        $profesor2->horarios()->createMany([

            [
                'dia' => 'Lunes',

                'materia' =>
                    'Bases de Datos',

                'hora_inicio' =>
                    '10:00',

                'hora_fin' =>
                    '12:00',

                'edificio' =>
                    'Edificio C',

                'aula' =>
                    '301',

                'tipo' =>
                    'Clase',
            ],

            [
                'dia' => 'Martes',

                'materia' =>
                    'Programación Backend',

                'hora_inicio' =>
                    '08:00',

                'hora_fin' =>
                    '10:00',

                'edificio' =>
                    'Edificio C',

                'aula' =>
                    '205',

                'tipo' =>
                    'Clase',
            ],

            [
                'dia' => 'Viernes',

                'materia' =>
                    'Tutoría académica',

                'hora_inicio' =>
                    '12:00',

                'hora_fin' =>
                    '14:00',

                'edificio' =>
                    'Edificio C',

                'aula' =>
                    '108',

                'tipo' =>
                    'Asesoría',
            ],

        ]);
    }
}