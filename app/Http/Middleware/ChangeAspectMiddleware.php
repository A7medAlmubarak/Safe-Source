<?php

namespace App\Http\Middleware;

use App\Aspects\ChangeAspect;
use Closure;
use Illuminate\Http\Request;

class ChangeAspectMiddleware
{
    protected ChangeAspect $changeAspect;

    public function __construct( ChangeAspect $changeAspect)
    {
        $this->changeAspect = $changeAspect;
    }

    public function handle(Request $request, Closure $next)
    {
        // Before request

        $this->changeAspect->before($request );

        $response = $next($request);

        // After request
        $this->changeAspect->after($request, $response);

        return $response;
    }
}
