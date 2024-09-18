<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CitaNotificaciones extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($permisos)
    {
        $user = User::where('permisos', $permisos)->first();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $notifications = $user->unreadNotifications;

        return response()->json([
            'notifications' => $notifications
        ]);

    }
}
