<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPosSource
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Retrieve the POS API Key from the environment variable
        $posApiKey = env('POS_API_KEY');

        // Check if the Authorization header is set correctly
        if ($request->header('Authorization') !== 'Bearer ' . $posApiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access Denied.',
            ], Response::HTTP_FORBIDDEN);  // 403 Forbidden
        }

        return $next($request);
    }
}
