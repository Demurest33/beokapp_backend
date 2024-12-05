<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\myUser;

class myUsersController extends Controller
{
    public function index()
    {
        $users = myUser::withCount([
            'orders as preparing_orders_count' => function ($query) {
                $query->where('status', 'preparando');
            },
            'orders as ready_orders_count' => function ($query) {
                $query->where('status', 'listo');
            },
            'orders as delivered_orders_count' => function ($query) {
                $query->where('status', 'entregado');
            },
            'orders as canceled_orders_count' => function ($query) {
                $query->where('status', 'cancelado');
            },
        ])->get();

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

    public function toggleBan(Request $request, $userId)
    {
        // Buscar el usuario
        $user = myUser::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Alternar el estado de baneo
        $user->is_banned = !$user->is_banned;
        $user->save();

        // Opcional: Enviar una notificación al usuario sobre el cambio de estado
        // Puedes implementar esto si lo deseas

        return response()->json([
            'success' => true,
            'message' => $user->is_banned ? 'Usuario baneado correctamente.' : 'Usuario desbaneado correctamente.',
            'user' => $user,
        ]);
    }
}
