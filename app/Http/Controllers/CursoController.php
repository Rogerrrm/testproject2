<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'etapa' => 'required|in:ESO,BTX,CF',
            'descripcion' => 'required|string|max:750',
        ]);

        $curso = new Curso();
        $curso->nombre = $request->nombre;
        $curso->etapa = $request->etapa;
        $curso->descripcion = $request->descripcion;
        $curso->save();

        return response()->json(['message' => 'Curso guardado correctamente'], 200);
    }

    public function buscar()
    {
        $cursos = DB::select("SELECT * FROM cursos");

        return response()->json([
            'cursos' => $cursos,
        ]);
    }

    public function eliminarCurso($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            $curso->delete();

            return response()->json(['message' => 'Curso eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el curso'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Buscar el curso por su ID
        $curso = Curso::find($id);

        // Verificar si el curso existe
        if (!$curso) {
            return response()->json(['error' => 'Curso no encontrado'], 404);
        }

        // Validar los datos de la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'etapa' => 'required|in:ESO,BTX,CF',
            'descripcion' => 'required|string|max:750',
        ]);

        // Actualizar el curso con los nuevos datos
        $curso->nombre = $request->nombre;
        $curso->etapa = $request->etapa;
        $curso->descripcion = $request->descripcion;
        $curso->save();

        // Devolver una respuesta de éxito
        return response()->json(['message' => 'Curso actualizado correctamente'], 200);
    }

}
