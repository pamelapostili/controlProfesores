<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesorController;

Route::get(
    '/',
    [ProfesorController::class, 'index']
)->name('profesores.index');


Route::get(
    '/profesores/{profesor}',
    [ProfesorController::class, 'show']
)->name('profesores.show');