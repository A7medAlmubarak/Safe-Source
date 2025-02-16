<?php

namespace App\Http\Middleware;

use App\Aspects\ChangeAspect;
use Closure;
use App\Aspects\LogAspect;
use App\Aspects\TransactionAspect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AspectMiddleware
{
    protected LogAspect $logAspect;
    protected TransactionAspect $transactionAspect;

    public function __construct(LogAspect $logAspect, TransactionAspect $transactionAspect )
    {
        $this->logAspect = $logAspect;
        $this->transactionAspect = $transactionAspect;
    }

    public function handle(Request $request, Closure $next)
    {
        // Before request
        $this->transactionAspect->before($request);
        $this->logAspect->before($request);

        $response = $next($request);

        // After request
        $this->logAspect->after($request, $response);
        $this->transactionAspect->after($request, $response);

        return $response;
    }
}
