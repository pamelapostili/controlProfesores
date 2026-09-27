<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');

            $table->string('email')->unique();

            $table->string('foto')->nullable();

            $table->string('departamento')->nullable();

            $table->string('oficina')->nullable();

            $table->time('entrada')->nullable();

            $table->time('salida')->nullable();

            $table->string('estatus')->default('libre');

            $table->string('estatus_detalle')->nullable();

            $table->string('ubicacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profesores');
    }
};