<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeAdminOrCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->user_type === 'E') {
            return $request->expectsJson()
                ? abort(403, 'Não tem permissões.')
                : redirect()->route('root')
                ->with('alert-msg', 'Não tem permissões.')
                ->with('alert-type', 'danger');;
        }
        return $next($request);
    }
}
