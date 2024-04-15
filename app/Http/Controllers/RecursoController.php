<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurso;
use Illuminate\Support\Facades\DB;

class RecursoController extends Controller
{
    public function guardar(Request $request)
    {
        // Validar los datos
        $request->validate([
            'titulo' => 'required|string',
            'contenido' => 'required|string',
            'visibilidad' => 'required|in:publico,privado',
            'curso_id' => 'required|exists:cursos,id', // Validar que el curso_id exista en la tabla de cursos
        ]);

        // Crear un nuevo recurso
        $recurso = new Recurso();
        $recurso->titulo = $request->titulo;
        $recurso->contenido_html = $request->contenido;
        $recurso->visibilidad = $request->visibilidad;
        $recurso->curso_id = $request->curso_id; // Asignar el curso_id proporcionado en la solicitud
        $recurso->save();

        return response()->json(['message' => 'Recurso guardado correctamente'], 201);
    }

    public function buscar()
    {
        $recursos = DB::select("SELECT * FROM recursos");

        return response()->json([
            'recursos' => $recursos,
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        // Validar los datos recibidos del formulario
        $request->validate([
            'titulo' => 'required|',
            'contenido_html' => 'required|',
            'visibilidad' => 'required|',
            'curso_id' => 'required|' // Asegúrate de reemplazar 'cursos' con el nombre real de tu tabla de cursos
        ]);

        // Buscar el recurso por su ID
        $recurso = Recurso::findOrFail($id);

        // Actualizar los campos del recurso
        $recurso->titulo = $request->titulo;
        $recurso->contenido_html = $request->contenido_html;
        $recurso->visibilidad = $request->visibilidad;
        $recurso->curso_id = $request->curso_id;

        // Guardar los cambios en la base de datos
        $recurso->save();

        // Devolver una respuesta JSON con un mensaje de éxito
        return response()->json(['message' => 'Recurso actualizado correctamente'], 200);
    }

    public function buscarCursosRecursos(Request $request)
    {
        // Obtiene el grupoId del cuerpo de la solicitud
        $grupoId = $request->input('grupoId');

        // Realiza la consulta SQL utilizando el grupoId
        $recursos = DB::select("SELECT * FROM recursos WHERE curso_id = ?", [$grupoId]);

        return response()->json([
            'recursos' => $recursos,
        ]);
    }
}
