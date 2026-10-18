<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    protected $fillable = [
        'nombre',
        'carrera',
        'semestre',
        'turno',
    ];

    public function alumnos(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(Asignacion::class);
    }
}