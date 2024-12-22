<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitingMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->ip();

        // Dakikada maksimum 60 istek
        if ($this->limiter->tooManyAttempts($key, 60)) {
            return response()->json([
                'message' => 'Çok fazla istek gönderdiniz. Lütfen biraz bekleyin.'
            ], 429);
        }

        $this->limiter->hit($key, 60); // 1 dakika

        $response = $next($request);

        return $response->header('X-RateLimit-Limit', 60)
                       ->header('X-RateLimit-Remaining', $this->limiter->remaining($key, 60));
    }
}
