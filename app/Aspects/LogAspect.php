<?php
namespace App\Aspects;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogAspect
{
    public function before(Request $request): void
    {
        try {
            Log::info("Request starting for route: " . $request->path(), [
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user' => auth()->id() ?? 'guest'
            ]);
        } catch (Throwable $e) {
            Log::error("Logging failed in before method: " . $e->getMessage());
        }
    }

    public function after(Request $request, Response $response): void
    {
        try {
            Log::info("Response completed for route: " . $request->path(), [
                'status' => $response->getStatusCode(),
                'duration' => microtime(true) - LARAVEL_START
            ]);
        } catch (Throwable $e) {
            Log::error("Logging failed in after method: " . $e->getMessage());
        }
    }
}
