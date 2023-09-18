<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiExceptionHandler extends ExceptionHandler
{
    public function render($request, $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return response()->json(['error' => 'No estás autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Recurso no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return parent::render($request, $exception);
    }
}