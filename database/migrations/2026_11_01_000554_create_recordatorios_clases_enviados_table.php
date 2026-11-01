
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recordatorios_clases_enviados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horario_profesor_id')
                ->constrained('horarios_profesores')
                ->cascadeOnDelete();

            $table->date('fecha_clase');
            $table->unsignedTinyInteger('minutos_antes');
            $table->timestamps();

            $table->unique([
                'horario_profesor_id',
                'fecha_clase',
                'minutos_antes'
            ], 'recordatorio_clase_unico');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recordatorios_clases_enviados');
    }
};
