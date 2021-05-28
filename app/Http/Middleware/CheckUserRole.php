<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $res = [];
            // Get the authenticated user 
            $user = auth()->user();

            // Check the user's role
            if ($user->role !== 'admin') {
                $res['error'] = 'No tienes permiso para realizar esta acción';
                return response($res, 400);
            }

            return $next($request);
            
        } catch (Exception $e) {
            $res['error'] = 'Hubo un error en el servidor, intentalo mas tarde.';
            return response($res, 400);
        }
    }
}
