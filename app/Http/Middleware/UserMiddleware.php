<?php

namespace App\Http\Middleware;

use App\Traits\CompanyTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    use CompanyTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->getUser()->role != 'user') {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
