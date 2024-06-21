<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function validador(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar el usuario en la base de datos
        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Si no coincide el usuario o la contraseña, devolver un mensaje de error
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        // Verificar el tipo de usuario
        if ($user->type === 1) {
            // Si es un administrador, devolver un mensaje de bienvenida para admin
            return response()->json(['mensaje' => 'Bienvenido, eres admin'], 200);
        } elseif ($user->type === 0) {
            // Si es un cliente, devolver un mensaje de bienvenida para cliente
            return response()->json(['mensaje' => 'Bienvenido, eres cliente'], 200);
        } else {
            // Si el tipo de usuario no está definido correctamente, devolver un mensaje de error
            return response()->json(['error' => 'Tipo de usuario no válido'], 400);
        }
    }
}
