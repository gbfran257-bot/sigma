<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;


class ApiErrorMiddleware
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (ValidationException $e) {
            return $this->convertValidationExceptionToResponse($e, $request);
        } catch (ModelNotFoundException $e) {
            $modelName = class_basename($e->getModel());
            return $this->errorResponse("No existe una instancia de {$modelName} con el ID especificado.", 404);
        } catch (AuthorizationException $e) {
            return $this->errorResponse($e->getMessage(), 403);
        } catch (HttpException $e) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->errorResponse($e->getMessage(), 500);
            }
            return $this->errorResponse('Ha ocurrido un error inesperado. Por favor, intenta nuevamente más tarde.', 500);
        }
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }

    protected function errorResponse($message, $statusCode)
    {
        return new JsonResponse(['error' => $message], $statusCode);
    }
}
