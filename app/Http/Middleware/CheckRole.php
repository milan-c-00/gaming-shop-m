<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $userRole = $request->user()->role;

        if (($role == 'admin' && $userRole != 1) || ($role == 'user' && $userRole != 0)) {
            return response(["message" => "Unauthorized!"], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
