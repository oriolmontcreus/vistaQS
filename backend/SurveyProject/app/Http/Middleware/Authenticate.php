<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Helpers\Constants\ResponseConstants;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * Note: The unauthenticated case is handled in the unauthenticated method
     * of the Handler class (App\Exceptions\Handler).
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'status' => ResponseConstants::RESPONSE_ERROR,
                'payload' => null
            ], 401);
        }

        return route('login');
    }
}
