<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ApiErrorHandler
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (AuthenticationException $exception) {
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (RouteNotFoundException $exception) {
            return response()->json(['error' => 'Ruta no encontrada'], 404);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
}