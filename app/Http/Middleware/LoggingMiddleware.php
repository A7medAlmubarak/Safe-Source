<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

class LoggingMiddleware
{
    protected $console;

    public function __construct()
    {
        $this->console = new ConsoleOutput();
    }

    public function handle(Request $request, Closure $next)
    {
        // Before request
        Log::info('Request started', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user' => $request->user()?->id
        ]);

        $response = $next($request);

        // After request
        Log::info('Request completed', [
            'url' => $request->fullUrl(),
            'status' => $response->status(),
            'duration' => defined('LARAVEL_START') ? (microtime(true) - LARAVEL_START) : 0
        ]);

        return $response;
    }
} 