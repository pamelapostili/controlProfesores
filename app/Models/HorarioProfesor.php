<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioProfesor extends Model
{
    protected $table = 'horarios_profesores';

    protected $fillable = [
        'profesor_id',
        'dia',
        'materia',
        'hora_inicio',
        'hora_fin',
        'edificio',
        'aula',
        'tipo',
    ];

    public function profesor(): BelongsTo
    {
        return $this->belongsTo(Profesor::class);
    }
}