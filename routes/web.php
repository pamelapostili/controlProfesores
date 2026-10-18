<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ProfesorPanelController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
})->name('inicio.publico');

Route::middleware('auth')->group(function () {

    // Redirige a la pantalla correspondiente según el rol.
    Route::get('/dashboard', function () {
        $usuario = Auth::user();
        if ($usuario->rol === 'profesor') {
            return redirect()->route('profesor.panel');
        }

        return redirect()->route('profesores.index');
    })->name('dashboard');

    // Panel exclusivo para profesores.
    Route::get('/profesor/panel', [
        ProfesorPanelController::class,
        'index'
    ])->middleware('role:profesor')->name('profesor.panel');

    // Directorio de profesores para alumnos.
    Route::get('/profesores', [
        ProfesorController::class,
        'index'
    ])->middleware('role:alumno')->name('profesores.index');

    Route::get('/profesores/{profesor}', [
        ProfesorController::class,
        'show'
    ])->middleware('role:alumno')->name('profesores.show');

    // Perfil personal de Breeze.
    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');
});

require __DIR__.'/auth.php';
