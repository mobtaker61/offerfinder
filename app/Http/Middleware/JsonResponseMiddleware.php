<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // اگر درخواست API است و پاسخ JSON نیست
        if ($request->is('api/*') && !$response->headers->has('Content-Type')) {
            $response->headers->set('Content-Type', 'application/json');
            
            // اگر پاسخ HTML است، آن را به JSON تبدیل کن
            if (str_contains($response->headers->get('Content-Type'), 'text/html')) {
                return response()->json([
                    'message' => 'An error occurred',
                    'error' => $response->getContent()
                ], $response->getStatusCode());
            }
        }

        return $response;
    }
} 