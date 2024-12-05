<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\myUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'phone' => 'required|digits:10',
            'password' => 'required|string|min:6',
        ]);

        // Busca al usuario por su número de teléfono
        $user = myUser::where('phone', $request->phone)->first();

        // Verifica si el usuario existe y si la contraseña es correcta
        if ($user && Hash::check($request->password, $user->password)) {
            // Verifica si el usuario está baneado
            if ($user->is_banned) {
                return response()->json([
                    'message' => 'Tu cuenta ha sido baneada.'
                ], 403);
            }

            // Devuelve los datos del usuario si no está baneado
            return response()->json($user);
        } else {
            return response()->json([
                'message' => 'Credencias no validas'
            ], 401);
        }
    }

}
