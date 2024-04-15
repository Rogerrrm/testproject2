<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurso;

class RecursoController extends Controller
{
    public function guardar(Request $request)
    {
        // Validar los datos
        $request->validate([
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'visibilidad' => 'required|in:publico,privado',
        ]);

        // Crear un nuevo recurso
        $recurso = new Recurso();
        $recurso->titulo = $request->titulo;
        $recurso->contenido = $request->contenido;
        $recurso->visibilidad = $request->visibilidad;
        $recurso->save();

        return response()->json(['message' => 'Recurso guardado correctamente'], 201);
    }
}
