<?php
namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorPanelController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        // Cada profesor consulta exclusivamente su propio perfil.
        $profesor = Profesor::where('email', $usuario->email)
        ->with(['horarios', 'asignaciones.grupo'])
        ->firstOrFail();

        return view('profesores.panel', compact(
            'usuario',
            'profesor'
        ));
    }
}
