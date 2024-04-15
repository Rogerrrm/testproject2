<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Obtiene la sesión del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserSession(Request $request)
    {
        // Verifica si hay un usuario autenticado
        if ($request->user()) {
            return $request->user();
        } else {
            return response()->json(['message' => 'No hay usuario autenticado'], 401);
        }
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function eliminar($id)
    {
        // Buscar el usuario por su ID
        $usuario = User::find($id);

        // Verificar si el usuario existe
        if ($usuario) {
            // Eliminar el usuario
            $usuario->delete();
            return response()->json(['message' => 'Usuario eliminado exitosamente'], 200);
        } else {
            // El usuario no existe
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    public function actualizar(Request $request, $id)
    {
        // Buscar el usuario por su ID
        $usuario = User::find($id);

        // Verificar si el usuario existe
        if ($usuario) {
            // Actualizar los datos del usuario
            $usuario->update($request->all());
            return response()->json(['message' => 'Usuario actualizado exitosamente'], 200);
        } else {
            // El usuario no existe
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }
}