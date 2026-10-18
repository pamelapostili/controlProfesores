<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'allen@gmail.com'],
            [
                'name' => 'Alejandro',
                'password' => Hash::make('allen123'),
                'rol' => 'alumno',
            ]
        );

        User::updateOrCreate(
            ['email' => 'postis@gmail.com'],
            [
                'name' => 'Pamela',
                'password' => Hash::make('postis123'),
                'rol' => 'alumno',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pugberto@gmail.com'],
            [
                'name' => 'Pugberto',
                'password' => Hash::make('pugberto123'),
                'rol' => 'profesor',
            ]
        );
    }
}
