<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeCustomerOrAnon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (is_null($user)){
            return $next($request);
        }

        if ($user ->user_type === 'A'|| $user ->user_type === 'E') {
            return $request->expectsJson()
                ? abort(403, 'Não pode aceder ao carrinho.')
                : redirect()->route('root')
                ->with('alert-msg', 'Não pode aceder ao carrinho.')
                ->with('alert-type', 'danger');;
        }
        return $next($request);
    }
}
