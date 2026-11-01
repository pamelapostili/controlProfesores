<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\HorarioProfesor;

class ClasePorComenzar extends Notification
{
    use Queueable;

    protected $horario;
    protected $minutosAntes;

    public function __construct(
        HorarioProfesor $horario,
        int $minutosAntes
    ) {
        $this->horario = $horario;
        $this->minutosAntes = $minutosAntes;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'titulo' => '¡Tu clase está por comenzar!',
            'mensaje' => "Tu clase de {$this->horario->materia} comienza en {$this->minutosAntes} minutos.",
            'materia' => $this->horario->materia,
            'hora_inicio' => $this->horario->hora_inicio,
            'hora_fin' => $this->horario->hora_fin,
            'edificio' => $this->horario->edificio,
            'aula' => $this->horario->aula,
            'minutos_antes' => $this->minutosAntes,
            'tipo' => 'clase_proxima',
        ];
    }
}
