<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function validador(Request $request)
    {
        \Log::info('Request recibido', $request->all());
    
        // Validar la solicitud
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        \Log::info('Validación pasada');
    
        // Intentar encontrar el usuario por su email
        $user = User::where('email', $request->email)->first();
    
        \Log::info('Usuario encontrado', ['user' => $user]);
    
        if ($user) {
            \Log::info('Usuario existe');
    
            // Verificar si la contraseña es correcta
            if (Hash::check($request->password, $user->password)) {
                \Log::info('Contraseña verificada');
    
                if ($user->type == 1) {
                    \Log::info('Usuario es admin');
                    return response()->json(['mensaje' => 'Bienvenido, eres admin'], 200);
                } else {
                    \Log::info('Usuario es cliente');
                    return response()->json(['mensaje' => 'Bienvenido, eres cliente'], 200);
                }
            } else {
                \Log::info('Contraseña incorrecta');
            }
        } else {
            \Log::info('Usuario no encontrado');
        }
    
        // Responder con un error si las credenciales son incorrectas
        \Log::info('Credenciales incorrectas');
        return response()->json(['error' => 'Credenciales incorrectas'], 401);
    }
    

}
