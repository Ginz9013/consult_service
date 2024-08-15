<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    // override
    protected function unauthenticated($request, array $guards)
    {
        echo "Has bug, ['status' => 401, 'message' => 'Unauthenticated.']";
        return response()->json(['status' => 401, 'message' => 'Unauthenticated.'], 401);
    }
}
