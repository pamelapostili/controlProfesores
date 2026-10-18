<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profesor extends Model
{
    protected $table = 'profesores';

    protected $fillable = [
        'nombre',
        'email',
        'foto',
        'departamento',
        'oficina',
        'entrada',
        'salida',
        'estatus',
        'estatus_detalle',
        'ubicacion',
    ];

    protected $casts = [
        'entrada' => 'datetime:H:i',
        'salida' => 'datetime:H:i',
    ];

    public function horarios(): HasMany
    {
        return $this->hasMany(HorarioProfesor::class);
    }

    public function getEstatusLabelAttribute(): string
    {
        return match ($this->estatus) {

            'en_clase' => 'En clase',

            'libre' => 'Libre',

            'comida' => 'Horario de comida',

            'por_llegar' => 'Ya no tarda en llegar',

            'ya_se_fue' => 'Ya se fue',

            'cerca' => 'Está cerca',

            'ubicado' => 'Ubicado en edificio',

            default => 'Sin información',
        };
    }

    public function getEstatusClassAttribute(): string
    {
        return match ($this->estatus) {

            'en_clase' => 'status-class',

            'libre' => 'status-free',

            'comida' => 'status-food',

            'por_llegar' => 'status-coming',

            'ya_se_fue' => 'status-gone',

            'cerca' => 'status-near',

            'ubicado' => 'status-building',

            default => 'status-default',
        };
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(Asignacion::class);
    }
}
