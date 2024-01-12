<?php

namespace App\Http\Middleware;

use App\Traits\CompanyTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveMiddleware
{
    use CompanyTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $this->getUser();
        if ($user->status != 'active') {
            auth()->logout();
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => 'Your account is Nonactive!'], 403);
            }
            if ($user->role === 'user') {
                return redirect()->route('index');
            }
            return redirect()->route('home')->with('error', 'Your account is Nonactive!');
        }
        return $next($request);
    }
}
