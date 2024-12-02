<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\myUser;

class myUsersController extends Controller
{
    public function index()
    {
        $users = myUser::all();
        return response()->json($users);
    }

    public function updateRole(Request $request, $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'role' => 'required|in:CLIENTE,ADMIN,AUXILIAR',
        ]);

        // Encontrar el usuario
        $user = myUser::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Actualizar el rol
        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Rol actualizado exitosamente', 'user' => $user], 200);
    }
}
