<?php

namespace App\Aspects;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TransactionAspect
{
    public function before(Request $request): void
    {
        DB::beginTransaction();
    }

    public function after(Request $request, Response $response): void
    {
        try {
            if ($response->isSuccessful()) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        } catch (Throwable $e) {
            // Log the exception if needed
            Log::error('Transaction failed: ' . $e->getMessage());
            DB::rollBack(); // Rollback the transaction on exception
        }
    }
}
