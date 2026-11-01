<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HorarioProfesor;
use App\Notifications\ClasePorComenzar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EnviarRecordatoriosClases extends Command
{
    protected $signature = 'clases:recordatorios';

    protected $description = 'Envía recordatorios de clases próximas';

    public function handle(): int
    {
        $ahora = now();
        $diaActual = mb_strtolower(
            $ahora->locale('es')->dayName
        );

        $horarios = HorarioProfesor::with('profesor.usuario')->get();

        foreach ($horarios as $horario) {

            if (mb_strtolower(trim($horario->dia)) !== $diaActual) {
                continue;
            }

            $usuario = $horario->profesor?->usuario;

            if (!$usuario) {
                continue;
            }

            $inicio = Carbon::parse(
                $ahora->toDateString() . ' ' . $horario->hora_inicio
            );

            $minutosRestantes = (int) (
                ($inicio->timestamp - $ahora->copy()->startOfMinute()->timestamp) / 60
            );

            foreach ([15, 5] as $minutos) {

                if ($minutosRestantes !== $minutos) {
                    continue;
                }

                $insertado = DB::table('recordatorios_clases_enviados')
                    ->insertOrIgnore([
                        'horario_profesor_id' => $horario->id,
                        'fecha_clase' => $ahora->toDateString(),
                        'minutos_antes' => $minutos,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                if ($insertado) {
                    $usuario->notify(
                        new ClasePorComenzar($horario, $minutos)
                    );

                    $this->info(
                        "Aviso enviado a {$usuario->name}: {$horario->materia}"
                    );
                }
            }
        }

        return self::SUCCESS;
    }
}
