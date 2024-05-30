<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RaitingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Obtener todas las calificaciones del usuario con relaciones cargadas
        $ratings = $user->ratings()->with('restaurant', 'user')->get();

        if ($ratings->isEmpty()) {
            return response()->json(['message' => 'El usuario no tiene calificaciones asociadas'], 404);
        }

        // Mapear los datos necesarios
        $comentarios = $ratings->map(function ($rating) {
            return [
                'id' => $rating->id,
                'rating' => $rating->rating,
                'comment' => $rating->comment,
                'restaurant_name' => $rating->restaurant->name,
                'user_name' => $rating->user->name,
            ];
        });

        return response()->json([
            'comentarios' => $comentarios,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
            // Asegúrate de que también recibes el ID del restaurante
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        // Crear una nueva calificación
        $rating = new Rating();
        $rating->rating = $validatedData['rating'];
        $rating->comment = $validatedData['comment'];
        $rating->user_id = auth()->id(); // Asigna el ID del usuario autenticado
        $rating->restaurant_id = $validatedData['restaurant_id'];
        $rating->save();

        // Recuperar todas las valoraciones para este restaurante
        $ratings = Rating::where('restaurant_id', $validatedData['restaurant_id'])->get();

        // Calcular el nuevo promedio de valoración y redondear al entero más cercano
        $totalRatings = $ratings->count();
        $totalRatingSum = $ratings->sum('rating');
        $averageRating = $totalRatings > 0 ? round($totalRatingSum / $totalRatings) : 0;

        // Actualizar el promedio de valoración del restaurante
        $restaurant = Restaurant::findOrFail($validatedData['restaurant_id']);
        $restaurant->average_rating = $averageRating;
        $restaurant->save();

        return response()->json($rating, 201);
    }

    /**
     * Display the specified resource.
     */
    public function obtenerComentariosRestaurante($restaurante_id)
    {
        // Obtener todos los comentarios para el restaurante dado, incluyendo los nombres de usuario
        $comentarios = Rating::with('user')->where('restaurant_id', $restaurante_id)->get();

        // Devolver los comentarios como respuesta
        return response()->json($comentarios);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        try {
            // Buscar el comentario por ID
            $comentario = Rating::findOrFail($id);

            // Actualizar el comentario con los nuevos datos
            $comentario->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            // Recuperar todas las valoraciones para este restaurante
            $ratings = Rating::where('restaurant_id', $comentario->restaurant_id)->get();

            // Calcular el nuevo promedio de valoración y redondear al entero más cercano
            $totalRatings = $ratings->count();
            $totalRatingSum = $ratings->sum('rating');
            $averageRating = $totalRatings > 0 ? round($totalRatingSum / $totalRatings) : 0;

            // Actualizar el promedio de valoración del restaurante
            $restaurant = Restaurant::findOrFail($comentario->restaurant_id);
            $restaurant->average_rating = $averageRating;
            $restaurant->save();

            // Devolver una respuesta de éxito
            return response()->json(['message' => 'Comentario actualizado correctamente'], 200);
        } catch (\Exception $e) {
            // Manejar cualquier error que ocurra durante la actualización
            return response()->json(['error' => 'Error al actualizar el comentario'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        try {
            $comentario = Rating::findOrFail($id);
            $comentario->delete();

            return response()->json(['message' => 'Comentario eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el comentario'], 500);
        }
    }
}
