<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignaciones', function (Blueprint $table) {

            $table->id();

            $table->foreignId('grupo_id')
                ->constrained('grupos')
                ->cascadeOnDelete();

            $table->foreignId('profesor_id')
                ->constrained('profesores')
                ->cascadeOnDelete();

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'grupo_id',
                'profesor_id',
                'materia_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignaciones');
    }
};