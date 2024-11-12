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
            return response()->json($user);
        } else {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
    }
}
