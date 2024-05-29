<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Obtener todos los restaurantes del usuario
        $restaurantes = $user->restaurantes()->get();

        // Verificar si el usuario tiene restaurantes asociados
        if ($restaurantes->isEmpty()) {
            return response()->json(['message' => 'El usuario no tiene restaurantes asociados'], 404);
        }

        return response()->json([
            'Restaurante' => $restaurantes,
        ]);
    }

    public function index2(Request $request)
    {
        $stars = $request->query('stars');

        // Filtrar restaurantes por el número de estrellas proporcionado
        $restaurants = Restaurant::where('average_rating', $stars)->get();

        return response()->json(['Restaurante' => $restaurants]);
    }


    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Agregar el user_id al array validado
        $validatedData['user_id'] = $userId;

        // Crear un nuevo restaurante con los datos validados
        $restaurant = Restaurant::create($validatedData);

        // Retornar una respuesta JSON con el restaurante creado y el código de estado 201 (Created)
        return response()->json($restaurant, 201);
    }

    public function edit($id)
    {
        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            return redirect()->back();
        }
        return Inertia::render('Inforestaurante', ['Restaurant' => $restaurant]);
    }
    public function delete($id)
    {
        try {
            $comentario = Restaurant::findOrFail($id);
            $comentario->delete();

            return response()->json(['message' => 'Comentario eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el comentario'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            // Otras validaciones para otros campos...
        ]);

        try {
            // Buscar el restaurante por ID
            $restaurant = Restaurant::findOrFail($id);

            // Actualizar el restaurante con los nuevos datos
            $restaurant->update([
                'name' => $request->name,
                'description' => $request->description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                // Otros campos del restaurante...
            ]);

            // Devolver una respuesta de éxito
            return response()->json(['message' => 'Restaurante actualizado correctamente'], 200);
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la actualización
            return response()->json(['error' => 'Error al actualizar el restaurante'], 500);
        }
    }
}