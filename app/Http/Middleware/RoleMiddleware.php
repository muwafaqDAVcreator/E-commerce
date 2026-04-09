<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect('login');
        }

        $user = \Illuminate\Support\Facades\Auth::user();

        // Admin has full access
        if ($user->role === 'Admin') {
            return $next($request);
        }

        // Exact role match
        if ($user->role === $role) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}
