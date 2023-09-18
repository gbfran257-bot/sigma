<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $requestClone = $request->duplicate();
        $requestBody = $requestClone->getContent();

        try {
            $response = $next($request);
        } catch (\Exception $exception) {
            $response = $this->handleException($exception);
        }

        $logData = [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_body' => $requestBody,
            'response_status' => $response->status(),
        ];

        if (isset($exception)) {
            $logData['error_message'] = $exception->getMessage();
            $logData['error_code'] = $exception->getCode();
        }

        Log::info('Request logged', $logData);

        return $response;
    }

    private function handleException(\Exception $exception)
    {
        throw $exception;
    }
}
