<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\myUser;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|digits:10',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Verificar si ya existe un usuario con el teléfono proporcionado
        $existingUser = myUser::where('phone', $request->phone)->first();
        if ($existingUser) {
            return response()->json([
                'message' => 'El teléfono ya está registrado',
            ], 409); // Código de error 409: Conflicto
        }

        $user = myUser::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => myUser::ROLE_CLIENTE,  // Asumimos que el rol por defecto es 'CLIENTE'
            'verified_at' => null,  // Puede ser null hasta que se verifique el usuario
        ]);

        return response()->json($user, 201);
        // Crear un nuevo usuario
    }
}
