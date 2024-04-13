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
}