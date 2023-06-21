<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (empty($user) || $user ->user_type !== 'A') {
            return $request->expectsJson()
                ? abort(403, 'Não é administrador.')
                : redirect()->route('root')
                ->with('alert-msg', 'Não é administrador.')
                ->with('alert-type', 'danger');;
        }
        return $next($request);
    }
}
