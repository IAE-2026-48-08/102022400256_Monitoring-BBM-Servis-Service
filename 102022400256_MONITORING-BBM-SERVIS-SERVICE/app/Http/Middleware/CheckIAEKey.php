<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIAEKey
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('X-IAE-KEY') !== env('IAE_API_KEY')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API Key',
                'errors' => null
            ], 401);
        }

        return $next($request);
    }
}