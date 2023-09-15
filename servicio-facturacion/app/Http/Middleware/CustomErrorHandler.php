<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CustomErrorHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No estás autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        $response = $next($request);

        if ($response instanceof Response && $response->getStatusCode() === Response::HTTP_NOT_FOUND) {
            return response()->json(['error' => 'Ruta no encontrada'], Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
